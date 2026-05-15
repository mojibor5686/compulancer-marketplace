<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Lib\RequiredConfig;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::latest('id')
            ->with('category')
            ->filter(['category_id', 'name'])
            ->searchable(['name', 'category:name'])
            ->paginate(getPaginate());

        $pageTitle     = "Manage Subcategories";
        $categories    = Category::active()->get();
        return view('admin.category.sub_categories', compact('pageTitle', 'subcategories', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $imageValidation = $id ? 'nullable' : 'required';

        $request->validate([
            'name'        => 'required|max:40',
            'category_id' => 'required|integer|exists:categories,id',
            'image'       => [$imageValidation, 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        if ($id) {
            $subcategory  = SubCategory::findOrFail($id);
            $notification = 'Subcategory updated successfully';
        } else {
            $subcategory  = new SubCategory();
            $notification = 'Subcategory added successfully';
        }

        if ($request->hasFile('image')) {
            $imageFileName      = fileUploader($request->image, getFilePath('subcategory'), getFileSize('subcategory'), @$subcategory->image);
            $subcategory->image = $imageFileName;
        }

        $subcategory->name        = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();

        RequiredConfig::configured('subcategory');
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return SubCategory::changeStatus($id);
    }
}
