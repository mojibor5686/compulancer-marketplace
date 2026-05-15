<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use App\Lib\RequiredConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Features';
        $features  = Feature::searchable(['name'])->latest()->paginate(getPaginate());
        return view('admin.features', compact('pageTitle', 'features'));
    }

    public function store(Request $request, $id = 0)
    {
        $uniqueRule = 'required|max:40|unique:features,name';
        if ($id) {
            $uniqueRule .= ',' . $id;
        }

        $request->validate([
            'name' => $uniqueRule
        ]);

        if ($id) {
            $feature      = Feature::findOrFail($id);
            $notification = 'Feature updated successfully';
        } else {
            $feature      = new Feature();
            $notification = 'Feature added successfully';
        }

        $feature->name = $request->name;
        $feature->save();

        RequiredConfig::configured('feature');
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Feature::changeStatus($id);
    }
}
