<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }
    public function authenticate(Request $request)
    {
       $validator =Validator::make($request ->all(),[
           'email'=>'required|email',
           'password'=>'required|min:6|max:20'
       ]);

       if($validator->passes()){
           if (auth()->guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password ],$request->get('remember'))) {
               // Người dùng đã xác thực thành công
               return redirect()->route('admin.dashboard');
           }
       }
       else {
           return redirect()->route('admin.login')->with('fail','Email hoặc mật khẩu không đúng');

       }
    }
}
