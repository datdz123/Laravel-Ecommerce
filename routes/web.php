<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\TempImagesController;


Route::get('/', function () {
    return view('Home');
});
Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin.login');

Route::group(['prefix'=>'admin'],function (){

   Route::group(['middleware'=>'admin.guest'],function (){
       Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
       Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
   });

   Route::group(['middleware'=>'admin.auth'],function (){
       Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashboard');
       Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');

       //Category Route
       Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
       Route::get('/categories/list',[CategoryController::class,'index'])->name('categories.list');
       Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
       Route::get('/categories', [CategoryController::class,'index'])->name('categories.list');
       Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

       Route::get('/categories/delete/{category}',[CategoryController::class,'delete'])->name('categories.delete');

       Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');




   });

});
