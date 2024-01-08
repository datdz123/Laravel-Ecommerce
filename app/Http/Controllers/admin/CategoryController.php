<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // code to handle the index action
    }

    public function create()
    {
    return view('admin.category.create');
    }

    public function store(Request $request)
    {
        // code to handle the store action
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
