<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    public function index()
    {
        echo 'Welcome to admin dashboard';
    }
    public function logout()
    {
       return redirect()->route('admin.login');
    }

}
