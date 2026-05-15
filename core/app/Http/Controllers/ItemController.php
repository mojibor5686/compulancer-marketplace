<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\JobBid;
use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use App\Models\Software;
use App\Models\SubCategory;
use App\Models\ExtraService;
use App\Http\Controllers\Controller;
use App\Models\Frontend;

class ItemController extends Controller
{
    public function service()
    {
        $pageTitle  = 'Service';
        $type       = 'service';
        return view('Template::home', compact('pageTitle', 'type'));
    }

    public function software()
    {
        $pageTitle  = 'Software';
        $type       = 'software';
        return view('Template::home', compact('pageTitle', 'type'));
    }

    public function job()
    {
        $pageTitle  = 'Job';
        $type       = 'job';
        return view('Template::home', compact('pageTitle', 'type'));
    }

    public function serviceDetails($slug, $id)
    {
        $pageTitle        = 'Service Details';
        $productDetails = Service::where('id', $id)->active()->userActiveCheck()->checkData()->with('user')->first();
        if (!$productDetails) {
            $notify[] = ['error', 'The requested service is no longer available or has been removed'];
            return redirect()->route('home')->withNotify($notify);
        }
        $extraServices    = ExtraService::where('service_id', $productDetails->id)->active()->latest()->get();
        $seoContents      = (object)seoContentSliced($productDetails->tag, $productDetails->name, $productDetails->description, getFilePath('service'), $productDetails->image, getFileSize('service'));
        $seoImage = getImage(getFilePath('service') . '/' . $productDetails->image, getFileSize('service'));
        return view('Template::service.service_details', compact('pageTitle', 'productDetails', 'extraServices', 'seoContents', 'seoImage'));
    }

    public function softwareDetails($slug, $id)
    {
        $pageTitle        = 'Software Details';
        $productDetails   = Software::where('id', $id)->active()->userActiveCheck()->checkData()->first();
        if (!$productDetails) {
            $notify[] = ['error', 'The requested software is no longer available or has been removed'];
            return redirect()->route('home')->withNotify($notify);
        }
        $seoContents      = (object)seoContentSliced($productDetails->tag, $productDetails->name, $productDetails->description, getFilePath('software'), $productDetails->image, getFileSize('software'));
        $seoImage = getImage(getFilePath('software') . '/' . $productDetails->image, getFileSize('software'));
        return view('Template::software.software_details', compact('pageTitle', 'productDetails', 'seoContents', 'seoImage'));
    }

    public function jobDetails($slug, $id)
    {
        $pageTitle      = 'Job Details';
        $productDetails = Job::where('id', $id)
            ->active()
            ->userActiveCheck()
            ->checkData()
            ->with(['jobBidings' => function ($query) {
                $query->latest();
            }, 'jobBidings.user', 'jobBidings.user.level'])
            ->first();

        if (!$productDetails) {
            $notify[] = ['error', 'The requested job is no longer available or has been removed'];
            return redirect()->route('home')->withNotify($notify);
        }

        // Handle AJAX request for loading more bids
        if (request()->ajax()) {
            $bids = $productDetails->jobBidings()
                ->latest()
                ->with('user')
                ->skip(request()->skip ?? 0)
                ->take(5)
                ->get();

            $html = '';
            foreach ($bids as $biding) {
                $html .= view('Template::partials.bid_item', compact('biding'))->render();
            }

            return response()->json([
                'success' => true,
                'html' => $html,
                'last' => $bids->count() < 5, // If less than 5 bids are returned, it means no more bids left
            ]);
        }

        // Normal page load
        $seoContents = (object)seoContentSliced(
            $productDetails->skill,
            $productDetails->name,
            $productDetails->description,
            getFilePath('job'),
            $productDetails->image,
            getFileSize('job')
        );

        $existingJobBidCheck = JobBid::where('job_id', $productDetails->id)
            ->where('user_id', auth()->id() ?? 0)
            ->exists();

        $seoImage = getImage(getFilePath('job') . '/' . $productDetails->image, getFileSize('job'));

        return view('Template::job_details', compact(
            'pageTitle',
            'productDetails',
            'seoContents',
            'existingJobBidCheck',
            'seoImage'
        ));
    }


    public function categoryWiseProduct($slug, $id)
    {
        $category = Category::where('id', $id)->active()->with('subCategories', function ($subCategories) {
            $subCategories->active();
        })->first();

        if (!$category) {
            $notify[] = ['error', 'The requested category is no longer available or has been removed'];
            return redirect()->route('home')->withNotify($notify);
        }

        $pageTitle = $category->name;
        $items = $this->getItems('category_id', $category->id, 'checkSubCategory');

        // Calculate counts for each item type
        $counts = [
            'service' => count($items['service']),
            'software' => count($items['software']),
            'job' => count($items['job']),
        ];

        // Find the key with the maximum count
        $maxKey = array_keys($counts, max($counts))[0];


        return view('Template::products', compact('pageTitle', 'category', 'items', 'maxKey'));
    }

    public function subcategoryWiseProduct($slug, $id)
    {
        $subcategory = SubCategory::where('id', $id)->active()->whereHas('category', function ($category) {
            $category->active();
        })->first();

        if (!$subcategory) {
            $notify[] = ['error', 'The requested subcategory is no longer available or has been removed'];
            return redirect()->route('home')->withNotify($notify);
        }

        $pageTitle = $subcategory->name;
        $items = $this->getItems('sub_category_id', $subcategory->id, 'checkCategory');
        $isSubcat = True;

        // Calculate counts for each item type
        $counts = [
            'service' => count($items['service']),
            'software' => count($items['software']),
            'job' => count($items['job']),
        ];

        // Find the key with the maximum count
        $maxKey = array_keys($counts, max($counts))[0];

        return view('Template::products', compact('pageTitle', 'subcategory', 'items', 'isSubcat', 'maxKey'));
    }

    public function publicProfile($username)
    {
        $pageTitle = 'User Profile';
        $user      = User::where('username', $username)->active()->with('jobBids')->first();

        if (!$user) {
            $notify[] = ['error', 'The requested user profile could not be found or has been deactivated'];
            return redirect()->route('home')->withNotify($notify);
        }

        $items = $this->getItems('user_id', $user->id, 'checkData');

        // Calculate counts for each item type
        $counts = [
            'service' => count($items['service']),
            'software' => count($items['software']),
            'job' => count($items['job']),
        ];

        // Find the key with the maximum count
        $maxKey = array_keys($counts, max($counts))[0];

        $seo = Frontend::where('data_keys', 'seo.data')->first()?->data_values;

        $seoContents = (object) [
            'description' => $user->about_me,
            'keywords' => array_merge(
                [$user->username, $user->designation, gs('site_name')],
                $seo?->keywords ?? []
            ),
        ];


        $seoImage = getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true);

        $reviews = Review::where('to_id', $user->id)->latest()->with('user')->get();
        return view('Template::public_profile', compact('pageTitle', 'user', 'reviews', 'items', 'maxKey', 'seoContents', 'seoImage'));
    }

    private function getItems($columnName, $columnValue, $scopeName = null)
    {
        $items    = ['Service', 'Software', 'Job'];
        $itemData = [];

        foreach ($items as $item) {
            $query = "App\\Models\\$item"::where($columnName, $columnValue)->active()->userActiveCheck();
            if ($scopeName) {
                $query->$scopeName();
            }
            $itemData[strtolower($item)] = $query->latest()->limit(10)->with('user')->get();
        }
        return $itemData;
    }
}
