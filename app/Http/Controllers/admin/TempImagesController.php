<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {
            $image=$request->image;
            if(!empty($image)){
                $ext=$image->getClientOriginalExtension();
                $newName=time().'.'.$ext;
                $tempImage=new TempImage();
                $tempImage->name=$newName;
                $tempImage->save();
                $image->move(public_path().'/tempImage',$newName);
                return response()->json([
                    'status'=>true,
                    'image_id'=>$tempImage->id,
                    'message'=>'Image uploaded successfully',
//                    'temp_image_id'=>$tempImage->id,
//                    'image_url'=>asset('images/'.$newName)
                ]);
            }
    }
    public function removeImage(Request $request, $id)
    {
        $category = Category::find($id);

        // If the category doesn't exist, return an error response
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // If the category has an image, delete it
        if ($category->image) {
            Storage::delete('public/images/' . $category->image);
            $category->image = null;
            $category->save();
        }

        // Return a success response
        return response()->json(['success' => 'Image removed successfully'], 200);
    }
}

