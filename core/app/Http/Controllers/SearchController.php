<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Service;
use App\Models\Software;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;

        $pageTitle = $search ? "Search results for - $search" : "Search results";

        $items['service']  = Service::searchable(['name'])->active()->userActiveCheck()->checkData()->latest()->limit(10)->with('user')->get();
        $items['software'] = Software::searchable(['name'])->active()->userActiveCheck()->checkData()->latest()->limit(10)->with('user')->get();
        $items['job']      = Job::searchable(['name'])->active()->userActiveCheck()->checkData()->latest()->limit(10)->with('user')->get();

        // Calculate counts for each item type
        $counts = [
            'service' => count($items['service']),
            'software' => count($items['software']),
            'job' => count($items['job']),
        ];

        // Find the key with the maximum count
        $maxKey = array_keys($counts, max($counts))[0];

        return view('Template::products', compact('pageTitle', 'items', 'search', 'maxKey'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:service,software,job',
            'level.*'    => 'nullable|integer|gt:0',
            'feature.*'  => 'nullable|integer|gt:0',
            'featured'   => 'nullable|in:true,false',
        ]);

        $type       = $request->type;
        $features   = $request->feature;
        $levels     = $request->level;
        $range      = $request->price;
        $skill      = $request->skill;
        $priceRange = [0, 0];



        if ($type == 'service') {
            $products = Service::query();
        } elseif ($type == 'software') {
            $products = Software::query();
        } else {
            $products = Job::query();
        }

        if ($request->featured == 'true') {
            $products = $products->featured();
        }

        if ($features) {
            $products = $products->whereJsonContains('features', $features);
        }

        if ($skill) {
            $products = $products->whereJsonContains('skill', $skill);
        }

        if ($levels) {
            $products = $products->whereHas('user', function ($q) use ($levels) {
                $q->whereIn('level_id', $levels);
            });
        }

        if ($range) {
            $rangeArray = explode("-", filter_var($range, FILTER_SANITIZE_NUMBER_INT));
            $products   = $products->whereBetween('price', $rangeArray);
            $priceRange = $rangeArray;
        }

        $products = $products->active()->sorting()->userActiveCheck()->checkData()->latest()->with(['user', 'user.level']);

        if (request()->tag) {
            $products = $products->whereJsonContains('tag', request()->tag);
        }

        if (request()->skill) {
            $products = $products->whereJsonContains('skill', request()->skill);
        }

        $priceRange = $this->priceRangeCalc($products); // keep this above pagination

        $products = $products->paginate(getPaginate(9));


        if ($request->ajax()) {
            $view = view('Template::partials.product_list', compact('products', 'type'))->render();

            return response()->json([
                'html'         => $view,
                'priceRange'   => $priceRange,
                'pagination'   => [
                    'total'      => $products->total(),
                    'per_page'   => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page'  => $products->lastPage(),
                    'from'       => $products->firstItem(),
                    'to'         => $products->lastItem(),
                ],
            ]);
        }
    }

    protected function priceRangeCalc($products)
    {
        $minPrice = $products->min('price');
        $maxPrice = $products->max('price');

        return [$minPrice, $maxPrice];
    }
}
