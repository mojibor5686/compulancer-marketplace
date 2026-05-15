<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Job;
use App\Models\Review;
use App\Models\Service;
use App\Models\Software;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FetchController extends Controller
{
    public function fetchReviews(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'skip' => 'required|integer|gt:0',
            'type' => 'required|in:service,software,profile',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $type = $request->type;
        $reviews = Review::query();

        if ($type === 'service') {
            $reviews = $reviews->where('service_id', $id);
        } elseif ($type === 'software') {
            $reviews = $reviews->where('software_id', $id);
        }
        // For 'profile', we don't filter by service_id or software_id
        // We fetch all reviews related to the user
        elseif ($type === 'profile') {
            $reviews = $reviews->where('to_id', $id);
        }

        // Apply general filters (skip, limit, and ordering)
        $reviews = $reviews->where('user_id', '!=', auth()->id()) // Exclude own review
            ->latest()
            ->skip($request->skip)
            ->with('user')
            ->limit(5)
            ->get();

        if (!$reviews->count()) {
            return response()->json([
                'last' => true,
                'error' => 'No more reviews to show'
            ]);
        }

        $view = view('Template::partials.load_reviews', compact('reviews'))->render();
        return response()->json([
            'success' => true,
            'last'    => $reviews->count() < 5,
            'html'    => $view
        ]);
    }


    public function fetchComments(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'skip' => 'required|integer|gt:0',
            'type' => 'required|in:service,software,job',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $type = $request->type;
        $comments = Comment::query();

        if ($type === 'service') {
            $comments  = $comments->where('service_id', $id);
        } elseif ($type === 'software') {
            $comments = $comments->where('software_id', $id);
        } else {
            $comments = $comments->where('job_id', $id);
        }

        $comments = $comments->latest()->skip($request->skip)->with(['user', 'replies', 'replies.user'])->limit(5)->get();

        if (!$comments->count()) {
            return response()->json([
                'error' => 'No more comments to show'
            ]);
        }

        $view = view('Template::partials.load_comment_reply', compact('comments'))->render();

        return response()->json([
            'success' => true,
            'html'    => $view
        ]);
    }

    public function fetchFeaturedServices(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'skip' => 'required|integer|gt:0',
            'type' => 'required|in:service,software,job',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $productItems = Service::active()->featured()->userActiveCheck()->checkData()->latest()->skip($request->skip)->with('user')->limit(5)->get();
        if (count($productItems)) {
            $type = $request->type;
            $view = view('Template::partials.load_featured_service', compact('productItems', 'type'))->render();

            return response()->json([
                'success' => true,
                'html'    => $view
            ]);
        } else {
            return response()->json([
                'error' => 'No more featured service to show!'
            ]);
        }
    }

    public function fetchProducts(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'type'           => 'required|in:service,software,job',
            'skip'           => 'required|integer|gt:0',
            'search'         => 'nullable|string',
            'user_id'        => 'nullable|integer|gt:0',
            'category_id'    => 'nullable|integer|gt:0',
            'subcategory_id' => 'nullable|integer|gt:0',
        ]);


        if ($validate->fails()) {
            return response()->json(
                ['error' => $validate->errors()->all()]
            );
        }

        $type          = $request->type;
        $search        = $request->search;
        $userId        = $request->user_id;
        $categoryId    = $request->category_id;
        $subcategoryId = $request->subcategory_id;
        $routeName = $request->route_name;

        if ($type) {
            $modelClass = "App\\Models\\" . ucfirst(trim($type));
            $products = $modelClass::active()->userActiveCheck()->checkData();
        } else {
            return response()->json([
                'error' => 'Type not found!'
            ]);
        }

        if ($search) {
            $products  = $products->searchable(['name']);
        }
        if ($userId) {
            $products  = $products->where('user_id', $userId);
        }
        if ($categoryId) {
            $products = $products->where('category_id', $categoryId);
        }
        if ($subcategoryId) {
            $products  = $products->where('sub_category_id', $subcategoryId);
        }

        $products = $products->latest()->skip($request->skip)->with('user');
        $products = $products->limit($routeName == 'public.profile' ? 9 : 8);
        $products = $products->get();

        if (!$products->count()) {
            return response()->json([
                'error' => 'No more items to show!'
            ]);
        }

        if ($type == 'service') {
            $type       = 'service';
            $view       = view('Template::partials.load_services', compact('products', 'type', 'routeName'))->render();
        } elseif ($type == 'software') {
            $type       = 'software';
            $view       = view('Template::partials.load_services', compact('products', 'type', 'routeName'))->render();
        } else {
            $type       = 'job';
            $view       = view('Template::partials.load_services', compact('products', 'type', 'routeName'))->render();
        }

        return response()->json([
            'success' => true,
            'html'    => $view
        ]);
    }
}
