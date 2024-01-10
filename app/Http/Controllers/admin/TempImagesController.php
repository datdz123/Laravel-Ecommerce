<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class TempImagesController extends Controller
{
    public function create()
    {
        return view('admin.temp-images.create');
    }
}
