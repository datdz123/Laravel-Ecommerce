<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
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
        }

        return redirect()->route('categories.list')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        // code to handle the edit action
    }

    public function update(Request $request, $id)
    {
        // code to handle the update action
    }
}
