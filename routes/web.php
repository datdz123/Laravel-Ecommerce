<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\TempImagesController;


Route::get('/', function () {
    return view('viewPage.home');
});
Route::get('/about', function () {
    return view('viewPage.about');
});

// Định nghĩa route cho trang veterinarian
Route::get('/vet', function () {
    return view('viewPage.vet');
});

// Định nghĩa route cho trang services
Route::get('/services', function () {
    return view('viewPage.services');
});

// Định nghĩa route cho trang gallery
Route::get('/gallery', function () {
    return view('viewPage.gallery');
});

// Định nghĩa route cho trang pricing
Route::get('/pricing', function () {
    return view('viewPage.pricing');
});

// Định nghĩa route cho trang blog
Route::get('/blog', function () {
    return view('viewPage.blog');
});

// Định nghĩa route cho trang contact
Route::get('/contact', function () {
    return view('viewPage.contact');
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
       Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
       Route::get('/categories/delete/{category}',[CategoryController::class,'delete'])->name('categories.delete');
       Route::delete('/categories/{category}/remove-image', [TempImagesController::class, 'removeImage'])->name('categories.removeImage');
       Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');




   });

});
