<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Lib\RequiredConfig;
use App\Rules\FileTypeValidate;

class CategoryController extends Controller
{
    public function categoryIndex()
    {
        $pageTitle  = 'All Categories';
        $categories = Category::searchable(['name'])->latest()->withCount('subcategories')->paginate(getPaginate());
        return view('admin.category.categories', compact('pageTitle', 'categories'));
    }

    public function categoryStore(Request $request)
    {
        $id = @$request->id;
        $imgRequired = $id ? 'nullable' : 'required';
        $request->validate([
            'name' => 'required|max:40|unique:categories,id,' . $id,
            'image' => [$imgRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);


        if ($id) {
            $category = Category::findOrFail($id);
            $notification = 'Category updated successfully';
        } else {
            $category = new Category();
            $notification = 'Category added successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'), $id ? $category->image : null);
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Couldn\'t upload your image']);
            }
        }

        $category->name = $request->name;
        $category->save();

        RequiredConfig::configured('category');
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        return Category::changeStatus($id);
    }
}
