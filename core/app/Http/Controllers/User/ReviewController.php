<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:service,software',
            'product_id' => 'required|integer|gt:0',
            'like'       => 'required|in:1,0',
            'rating'     => 'required|integer|min:1|max:5',
        ]);


        $booking    = null;
        $type       = $request->type;
        $user       = auth()->user();
        $serviceId  = 0;
        $softwareId = 0;

        if ($type == 'service') {
            $booking  = Booking::paid()->where('service_id', $request->product_id)->where('buyer_id', $user->id)->where('working_status', Status::WORKING_COMPLETED)->with(['service', 'service.user'])->first();
        } else {
            $booking  = Booking::paid()->where('software_id', $request->product_id)->where('buyer_id', $user->id)->where('status', Status::BOOKING_PAID)->with(['software', 'software.user'])->first();
        }

        if (!$booking) {
            $notify[] = ['error', 'You can only review completed orders that haven\'t been reviewed yet. Please check if your order is completed and hasn\'t been reviewed already.'];
            return back()->withNotify($notify);
        }


        if ($type == 'service') {
            $service = $booking->service;
            if ($request->like) {
                $service->likes += 1;
            } else {
                $service->dislike += 1;
            }

            $serviceId = $service->id;
            $owner     = $service->user;

            $service->total_review += 1;
            $total_sum_ratings = $service->total_rating * ($service->total_review - 1);
            $total_sum_ratings += $request->rating;
            $service->total_rating = $total_sum_ratings / $service->total_review;
            $service->save();


            $owner->total_review += 1;
            $total_sum_ratings = $owner->total_rating * ($owner->total_review - 1);
            $total_sum_ratings += $request->rating;
            $owner->total_rating = $total_sum_ratings / $owner->total_review;
            $owner->save();
        } else {
            $software = $booking->software;

            if ($request->like) {
                $software->likes += 1;
            } else {
                $software->dislike += 1;
            }

            $softwareId = $software->id;
            $owner      = $software->user;

            $software->total_review += 1;
            $total_sum_ratings = $software->total_rating * ($software->total_review - 1);
            $total_sum_ratings += $request->rating;
            $software->total_rating = $total_sum_ratings / $software->total_review;
            $software->save();


            $owner->total_review += 1;
            $total_sum_ratings = $owner->total_rating * ($owner->total_review - 1);
            $total_sum_ratings += $request->rating;
            $owner->total_rating = $total_sum_ratings / $owner->total_review;
            $owner->save();
        }


        $booking->review_status = Status::YES;
        $booking->save();

        $review              = new Review();
        $review->user_id     = $user->id;
        $review->to_id       = $owner->id;
        $review->service_id  = $serviceId;
        $review->software_id = $softwareId;
        $review->rating      = $request->rating;
        $review->review      = $request->review;

        if ($request->like) {
            $review->like_dislike = 1;
        } else {
            $review->like_dislike = 0;
        }

        $review->save();

        $notify[] = ['success', 'Your review has been taken successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'like'   => 'required|in:1,0'
        ]);

        $review = Review::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$review) {
            $notify[] = ['error', 'Review not found'];
            return back()->withNotify($notify);
        }

        $oldRating = $review->rating;
        $oldLikeDislike = $review->like_dislike;

        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->like_dislike = $request->like;

        if ($review->service_id) {
            $product = $review->service;
        } else {
            $product = $review->software;
        }
        $owner = $product->user;

        if ($oldRating != $review->rating) {
            $total_sum_ratings = $product->total_rating * $product->total_review;
            $total_sum_ratings = $total_sum_ratings - $oldRating + $review->rating;
            $product->total_rating = $total_sum_ratings / $product->total_review;
            $product->save();

            $total_sum_ratings = $owner->total_rating * $owner->total_review;
            $total_sum_ratings = $total_sum_ratings - $oldRating + $review->rating;
            $owner->total_rating = $total_sum_ratings / $owner->total_review;
            $owner->save();
        }

        if ($oldLikeDislike != $review->like_dislike) {
            if ($oldLikeDislike == 1 && $review->like_dislike == 0) {
                $product->likes -= 1;
                $product->dislike += 1;
            } elseif ($oldLikeDislike == 0 && $review->like_dislike == 1) {
                $product->likes += 1;
                $product->dislike -= 1;
            }
            $product->save();
        }

        $review->save();

        $notify[] = ['success', 'Review updated successfully'];
        return back()->withNotify($notify);
    }


    public function delete($id)
    {
        $review = Review::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$review) {
            $notify[] = ['error', 'Review not found'];
            return back()->withNotify($notify);
        }

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

        foreach ($booking->where('buyer_id', auth()->id())->get() as $book) {
            $book->review_status = Status::NO;
            $book->save();
        }

        $review->delete();

        $notify[] = ['success', 'Review deleted successfully'];
        return back()->withNotify($notify);
    }
}
