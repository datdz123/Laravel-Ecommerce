<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }
    // Xác Thực Đăng Nhập
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ]);


       if($validator->passes()){
           if (auth()->guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password ],$request->get('remember'))) {
               // Người dùng đã xác thực thành công
               $admin= auth()->guard('admin')->user();
               if ($admin->role==2) {
                   return redirect()->route('admin.dashboard');
               }
               else{
                   Auth::guard('admin')->logout();
                     return redirect()->route('admin.login')->with('error','Bạn Không có quyền truy cập');
               }

           }
           else{
               return redirect()->route('admin.login')->with('error','Email hoặc mật khẩu không đúng');
           }
       }
       else {
           return redirect()->route('admin.login')->withErrors($validator)->withInput($request->only('email'));

       }
    }


}
