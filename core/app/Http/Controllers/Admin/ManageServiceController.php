<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\ExtraService;
use App\Models\Feature;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\WorkFile;
use App\Models\Review;
use App\Models\Comment;

class ManageServiceController extends Controller
{
    public $pageTitle;

    protected function serviceData($scope = null)
    {
        if ($scope) {
            $services = Service::$scope();
        } else {
            $services = Service::query();
        }
        $services  = $services->searchable(['name', 'user:username', 'category:name', 'subCategory:name'])->filter(['user_id'])->latest()->with(['user', 'category', 'subCategory'])->paginate(getPaginate());
        $pageTitle = $this->pageTitle . ' Services';
        return view('admin.service.index', compact('pageTitle', 'services'));
    }

    public function all()
    {
        $this->pageTitle = 'All';
        return $this->serviceData(null);
    }
    public function pending()
    {
        $this->pageTitle = 'Pending';
        return $this->serviceData('pending');
    }

    public function approved()
    {
        $this->pageTitle = 'Approved';
        return $this->serviceData('approved');
    }

    public function canceled()
    {
        $this->pageTitle = 'Rejected';
        return $this->serviceData('canceled');
    }

    public function closed()
    {
        $this->pageTitle = 'Closed';
        return $this->serviceData('closed');
    }

    public function statusChange($id, $type)
    {
        $service = Service::where('id', $id)->where('status', Status::PENDING)->firstOrFail();

        if ($type == 'approve') {
            $notification    = 'approved';
            $service->status = Status::APPROVED;
        } else {
            $notification    = 'rejected';
            $service->status = Status::CANCELED;
        }

        $service->save();


        $emailShortCodes = [
            'service_name'    => $service->name,
            'message'         => 'Service ' . $notification . ' by admin'
        ];

        notify($service->user, 'SERVICE_STATUS_CHANGED', $emailShortCodes);

        $notify[] = ['success', "Service $notification successfully"];
        return back()->withNotify($notify);
    }

    public function featuredStatusChange($id, $type)
    {
        $service = Service::where('id', $id)->where('status', Status::APPROVED)->firstOrFail();

        if ($type == 'featured') {
            $notification      = 'featured';
            $service->featured = Status::YES;
        } else {
            $notification      = 'unfeatured';
            $service->featured = Status::NO;
        }

        $service->updated_at = now();
        $service->save();

        $emailShortCodes = [
            'service_name'    => $service->name,
            'message'         => 'Service ' . $notification . ' by admin'
        ];

        notify($service->user, 'SERVICE_FEATURED_STATUS_CHANGED', $emailShortCodes);

        $notify[] = ['success', "Service $notification successfully"];
        return back()->withNotify($notify);
    }

    public function details($id)
    {
        $pageTitle = 'Service Details';
        $service   = Service::with(['extraServices', 'user'])->findOrFail($id);
        $features  = Feature::find($service->features);
        return view('admin.service.details', compact('pageTitle', 'service', 'features'));
    }

    protected function serviceBookingData($scope = null)
    {
        $bookings = Booking::where('service_id', '!=', 0);

        if ($scope) {
            $bookings = $bookings->$scope();
        }

        $bookings = $bookings->searchable(['order_number', 'service:name'])
            ->latest()
            ->with(['service', 'buyer', 'seller'])
            ->filter(['buyer_id'])
            ->paginate(getPaginate());

        $pageTitle = $this->pageTitle . ' Bookings';
        return view('admin.service.booking_list', compact('pageTitle', 'bookings'));
    }

    public function bookingAll()
    {
        $this->pageTitle = 'All';
        return $this->serviceBookingData();
    }

    public function bookingPending()
    {
        $this->pageTitle = 'Pending';
        return $this->serviceBookingData('pending');
    }

    public function bookingCompleted()
    {
        $this->pageTitle = 'Completed';
        return $this->serviceBookingData('completed');
    }

    public function bookingDelivered()
    {
        $this->pageTitle = 'Delivered';
        return $this->serviceBookingData('delivered');
    }

    public function bookingInprogress()
    {
        $this->pageTitle = 'Inprogress';
        return $this->serviceBookingData('inprogress');
    }

    public function bookingDisputed()
    {
        $this->pageTitle = 'Disputed';
        return $this->serviceBookingData('disputed');
    }

    public function bookingRefunded()
    {
        $this->pageTitle = 'Refunded';
        return $this->serviceBookingData('refunded');
    }

    public function bookingExpired()
    {
        $this->pageTitle = 'Expired';
        return $this->serviceBookingData('expired');
    }

    public function bookingDetails($id)
    {
        $pageTitle = 'Service Booking Details';

        $details       = Booking::where('service_id', '!=', 0)->with(['service', 'buyer', 'seller', 'disputer'])->findOrFail($id);
        $extraServices = ExtraService::where('service_id', $details->service_id)->find(json_decode($details->extra_services));

        $workFiles = WorkFile::where('booking_id', $details->id)->latest()->with(['sender', 'receiver'])->get();
        $chats     = Chat::where('booking_id', $details->id)->with('user')->get();

        return view('admin.service.booking_details', compact('pageTitle', 'details', 'extraServices', 'workFiles', 'chats'));
    }

    public function winSeller($id)
    {
        $booking = Booking::where('service_id', '!=', 0)->where('working_status', Status::WORKING_DISPUTED)->with(['seller', 'service'])->findOrFail($id);

        $booking->working_status = Status::WORKING_COMPLETED;
        $booking->save();

        $booking->seller->balance += $booking->final_price;
        $booking->seller->earning += $booking->final_price;
        $booking->seller->save();

        userLevel($booking->seller);

        $transaction               = new Transaction();
        $transaction->user_id      = $booking->seller->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $booking->seller->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Added for selling a service named ' . $booking->service->name . ' by system';
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'service_completed';
        $transaction->save();

        $chat             = new Chat();
        $chat->booking_id = $booking->id;
        $chat->admin      = 1;
        $chat->message    = 'System marked seller as winner';
        $chat->save();

        $emailShortCodes = [
            'winner_username' => $booking->seller->username,
            'product_type'    => 'Service',
            'product_name'    => $booking->service->name,
            'message'         => 'System decided that the seller is the winner'
        ];

        notify($booking->seller, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);
        notify($booking->buyer, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);

        $notify[] = ['success', 'Amount given to the seller successfully'];
        return back()->withNotify($notify);
    }

    public function winBuyer($id)
    {
        $booking = Booking::where('service_id', '!=', 0)->where('working_status', Status::WORKING_DISPUTED)->with(['buyer', 'service'])->findOrFail($id);

        $booking->status         = Status::BOOKING_REFUNDED;
        $booking->working_status = null;
        $booking->updated_at     = now();
        $booking->save();

        $booking->buyer->balance += $booking->final_price;
        $booking->buyer->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $booking->buyer->id;
        $transaction->amount       = $booking->final_price;
        $transaction->post_balance = $booking->buyer->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Added as refund for a service named ' . $booking->service->name . ' by system';
        $transaction->trx          = $booking->order_number;
        $transaction->remark       = 'service_refunded';
        $transaction->save();

        $chat             = new Chat();
        $chat->booking_id = $booking->id;
        $chat->admin      = 1;
        $chat->message    = 'System marked buyer as winner';
        $chat->save();

        $emailShortCodes = [
            'winner_username' => $booking->buyer->username,
            'product_type'    => 'Service',
            'product_name'    => $booking->service->name,
            'message'         => 'System decided that the buyer is the winner'
        ];

        notify($booking->seller, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);
        notify($booking->buyer, 'DISPUTED_PRODUCT_SETTLED', $emailShortCodes);

        $notify[] = ['success', 'Amount returned to the buyer successfully'];
        return back()->withNotify($notify);
    }

    public function reviews($id)
    {
        $pageTitle = 'Service Reviews';
        $reviews = Review::where('service_id', $id)->with(['user', 'service'])->paginate(getPaginate());
        return view('admin.service.reviews', compact('pageTitle', 'reviews'));
    }

    public function reviewDelete($id)
    {
        $review = Review::findOrFail($id);

        if ($review->service_id) {
            $product = $review->service;
        } else {
            $product = $review->software;
        }
        $owner = $product->user;

        if ($review->like_dislike) {
            $product->likes = max(0, $product->likes - 1);
        } else {
            $product->dislike = max(0, $product->dislike - 1);
        }

        $product->total_review = max(0, $product->total_review - 1);

        if ($product->total_review > 0) {
            $total_sum_ratings = ($product->total_rating * ($product->total_review + 1)) - $review->rating;
            $product->total_rating = $total_sum_ratings / $product->total_review;
        } else {
            $product->total_rating = 0;
        }
        $product->save();

        $owner->total_review = max(0, $owner->total_review - 1);

        if ($owner->total_review > 0) {
            $total_sum_ratings = ($owner->total_rating * ($owner->total_review + 1)) - $review->rating;
            $owner->total_rating = $total_sum_ratings / $owner->total_review;
        } else {
            $owner->total_rating = 0;
        }
        $owner->save();

        $booking = $review->service_id ?
            $review->service->bookings() :
            $review->software->bookings();

        foreach ($booking->where('buyer_id', $review->user_id)->get() as $book) {
            $book->review_status = Status::NO;
            $book->save();
        }

        $review->delete();

        $notify[] = ['success', 'Review deleted successfully'];
        return back()->withNotify($notify);
    }

    public function comments($id)
    {
        $pageTitle = 'Service Comments';
        $comments = Comment::where('service_id', $id)->with(['user', 'service'])->paginate(getPaginate());
        return view('admin.service.comments', compact('pageTitle', 'comments'));
    }

    public function commentDelete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        $notify[] = ['success', 'Comment deleted successfully'];
        return back()->withNotify($notify);
    }
}
