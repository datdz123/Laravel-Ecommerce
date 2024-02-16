<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
//        $categories = Category::all(); // Lấy tất cả các bản ghi từ bảng categories

        $categories = Category::when($request->search, function ($query, $searchTerm) {
            return $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('slug', 'like', '%' . $searchTerm . '%');
        })->orderBy('id')->paginate($perPage = 10);




        return view('admin.category.list', ['categories' => $categories]);
    }

    public function create()
    {
    return view('admin.category.create');
    }





    public function store(Request $request)
    {
        $data = $request->all();

        $category = Category::create($data);
        if(!empty($request->image_id)){
            $tempImage=TempImage::find($request->image_id);
            $extArray=explode('.',$tempImage->name);
            $ext=last($extArray);
            $newImageName=$category->id.'.'.$ext;
            $category->image=$newImageName;
            $category->save();
            File::move(public_path() . '/tempImage/' . $tempImage->name, public_path() . '/images/' . $newImageName);
        }

        return redirect()->route('categories.list')->with('success', 'Category created successfully');
    }

    public function edit(Request $request,$id)
    {
        $category = Category::find($id);

        // If the category doesn't exist, redirect back with an error message
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }


        // Update the category with the request data
        $category->update($request->all());

        // Pass the category to the view
        return view('admin.category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        // If the category doesn't exist, redirect back with an error message
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validate the image
            // Add other fields as required
        ]);

        // Update the category with the request data
        $category->update($request->except('image')); // exclude the image from the update

        // If an image file is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image from the storage
            if ($category->image) {
                Storage::delete('public/images/' . $category->image);
            }

            // Store the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('public/images', $imageName);

            // Update the image name in the database
            $category->image = $imageName;
            $category->save();
        }

        // Redirect back with a success message
        return redirect()->route('categories.list', $category->id)->with('success', 'Category updated successfully');
    }

    public function delete($id)
    {
        $delete = Category::find($id)->delete();

        return redirect()->route('categories.list')->with('success', 'Category deleted successfully');
    }

}
