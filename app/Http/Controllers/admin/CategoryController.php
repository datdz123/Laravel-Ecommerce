<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;


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

    public function edit($categoryID,Request $request)
    {
        $category = Category::find($categoryID);

        // If the category doesn't exist, redirect back with an error message
       if(empty($category)){

           return redirect()->route('categories.list');
       }

        // Pass the category to the view
        return view('admin.category.edit', ['category' => $category]);
    }

    public function update(Request $request, $categoryID)
    {
        $category = Category::find($categoryID);
        if (empty($category)) {
            return response()->json(
                [
                    'status'=>'false',
                    'notFound'=>'true',
                    'message'=>'Category not found'
                ], 404);
        }

        // If the category doesn't exist, redirect back with an error message
//        if (!$category) {
//            return redirect()->back()->with('error', 'Category not found');
//        }
        // Validate the request data
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if($validator->passes()){

            $category->name=$request->name;
            $category->slug=$request->slug;
            $category->status=$request->status;
            $category->save();
            $category->update($request->all());
            if(!empty($request->image_id)){
                $tempImage=TempImage::find($request->image_id);
                $extArray=explode('.',$tempImage->name);
                $ext=last($extArray);
                $newImageName=$category->id.'.'.$ext;

                // Delete the old image if it exists
                if (File::exists(public_path() . '/images/' . $category->image)) {
                    File::delete(public_path() . '/images/' . $category->image);
                }

                $category->image=$newImageName;
                $category->save();
                File::move(public_path() . '/tempImage/' . $tempImage->name, public_path() . '/images/' . $newImageName);
            }
            $request->session()->flash('success','Category updated successfully');
            return redirect()->route('categories.edit', ['category' => $category->id]);

        }
        else{
            return response()->json(
                [
                    'status'=>'false',
                    'message'=>$validator->errors()->all()
                ]);
        }
    }

    public function delete($id)
    {
        $delete = Category::find($id)->delete();

        return redirect()->route('categories.list')->with('success', 'Category deleted successfully');
    }

}
