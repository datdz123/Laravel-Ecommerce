<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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
            $oldImage=$category->image;
            if(!empty($request->image_id)){
                $tempImage=TempImage::find($request->image_id);
                $extArray=explode('.',$tempImage->name);
                $ext=last($extArray);
                $newImageName=$category->id.'.'.$ext;
                $sPath=public_path() . '/tempImage/' . $tempImage->name;
                $dPath=public_path() . '/images/img_new/' . $newImageName;
                File::copy($sPath, $dPath);


                    $dPath = public_path() . '/images/img_new/thumb/' . $newImageName;
                    $img = Image::make($sPath);
                    $img->fit(450, 600, function ($constraint) {
                        $constraint->upsize();
                    });
                    $img->save($dPath);



                $category->image=$newImageName;
                $category->save();
                //Delete Old Image
//                File::delete(public_path(). '/images/img_new/thumb/' . $oldImage);
//                File::delete(public_path(). '/images/img_new/' . $oldImage);
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

        if ($delete) {
            // Delete the image from the directory
            File::delete(public_path(). '/images/img_new/thumb/' . $delete->image);
            File::delete(public_path(). '/images/img_new/' . $delete->image);

            // Delete the category from the database
            $delete->delete();

            return redirect()->route('categories.list')->with('success', 'Category and its image deleted successfully');
        } else {
            return redirect()->route('categories.list')->with('error', 'Category not found');
        }    }

//    public function destroyImage($id,Request $request){
//        $category = Category::find($id);
//        if (empty($category)) {
//            $request->session()->flash('error','Category not found');
//           return  response()->json([
//               'status'=>'false',
//               'notFound'=>'true',
//               'message'=>'Category not found'
//           ], 404);
//
//        }
//        File::delete(public_path(). '/images/img_new/thumb/' . $category->image);
//        File::delete(public_path(). '/images/img_new/' . $category->image);
//        $category->delete();
//        $request->session()->flash('success','Category deleted successfully');
//        return reponse()->json([
//            'status'=>'true',
//            'success'=>'Category deleted successfully']);
//    }

}
