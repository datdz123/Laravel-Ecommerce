<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
                $image->move(public_path().'/images',$newName);
                return response()->json([
                    'status'=>true,
                    'image_id'=>$tempImage->id,
                    'message'=>'Image uploaded successfully',
//                    'temp_image_id'=>$tempImage->id,
//                    'image_url'=>asset('images/'.$newName)
                ]);
            }
    }
}
