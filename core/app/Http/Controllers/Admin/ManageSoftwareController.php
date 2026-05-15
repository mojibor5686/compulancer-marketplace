<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feature;
use App\Models\Software;
use App\Models\Comment;
use App\Models\Review;

class ManageSoftwareController extends Controller
{
    public $pageTitle;

    protected function softwareData($scope = null)
    {
        if ($scope) {
            $softwares = Software::$scope();
        } else {
            $softwares = Software::query();
        }

        $softwares = $softwares->searchable(['name', 'user:username', 'category:name', 'subCategory:name'])->filter(['user_id'])->latest()->with(['user', 'category', 'subCategory'])->paginate(getPaginate());
        $pageTitle = $this->pageTitle . ' Softwares';

        return view('admin.software.index', compact('pageTitle', 'softwares'));
    }

    public function all()
    {
        $this->pageTitle = 'All';
        return $this->softwareData(null);
    }
    public function pending()
    {
        $this->pageTitle = 'Pending';
        return $this->softwareData('pending');
    }

    public function approved()
    {
        $this->pageTitle = 'Approved';
        return $this->softwareData('approved');
    }

    public function canceled()
    {
        $this->pageTitle = 'Rejected';

        return $this->softwareData('canceled');
    }

    public function closed()
    {
        $this->pageTitle = 'Closed';
        return $this->softwareData('closed');
    }

    public function statusChange($id, $type)
    {
        $software = Software::where('id', $id)->where('status', Status::PENDING)->firstOrFail();

        if ($type == 'approve') {
            $notification     = 'approved';
            $software->status = Status::APPROVED;
        } else {
            $notification     = 'rejected';
            $software->status = Status::CANCELED;
        }

        $software->updated_at = now();
        $software->save();

        $emailShortCodes = [
            'software_name'   => $software->name,
            'message'         => 'Software ' . $notification . ' by admin'
        ];

        notify($software->user, 'SOFTWARE_STATUS_CHANGED', $emailShortCodes);

        $notify[] = ['success', "Software $notification successfully"];
        return back()->withNotify($notify);
    }

    public function details($id)
    {
        $pageTitle = 'Software Details';
        $software  = Software::with('user')->findOrFail($id);
        $features  = Feature::find($software->features);
        return view('admin.software.details', compact('pageTitle', 'software', 'features'));
    }

    public function salesLog()
    {
        $pageTitle = 'Software Sales Log';
        $salesLog  = Booking::where('software_id', '!=', 0)->with(['buyer', 'seller', 'software'])->latest()->paginate(getPaginate());
        return view('admin.software.sales_log', compact('pageTitle', 'salesLog'));
    }

    public function featured($id)
    {
        $software = Software::where('id', $id)->where('status', Status::APPROVED)->firstOrFail();

        if (!$software->featured) {
            $notification       = 'featured';
            $software->featured = Status::YES;
        } else {
            $notification       = 'unfeatured';
            $software->featured = Status::NO;
        }

        $software->updated_at = now();
        $software->save();

        $emailShortCodes = [
            'software_name'   => $software->name,
            'message'         => 'Software ' . $notification . ' by admin'
        ];

        notify($software->user, 'SOFTWARE_FEATURED_STATUS_CHANGED', $emailShortCodes);

        $notify[] = ['success', "Software $notification successfully"];
        return back()->withNotify($notify);
    }

    public function reviews($id)
    {
        $pageTitle = 'Software Reviews';
        $reviews = Review::where('software_id', $id)->with(['user', 'software'])->latest()->paginate(getPaginate());
        return view('admin.software.reviews', compact('pageTitle', 'reviews'));
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
        $pageTitle = 'Software Comments';
        $comments = Comment::where('software_id', $id)->with(['user', 'software'])->latest()->paginate(getPaginate());
        return view('admin.software.comments', compact('pageTitle', 'comments'));
    }

    public function commentDelete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        $notify[] = ['success', 'Comment deleted successfully'];
        return back()->withNotify($notify);
    }
}
