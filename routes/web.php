<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
    Route::get('/post/{id}',     [HomeController::class, 'detail'])->name('post.detail');
    Route::get('/category/{id}', [HomeController::class, 'category'])->name('category.show');

    Route::get('/posts', [HomeController::class, 'posts'])->name('posts');
});


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('login', [AuthController::class, 'post'])->name('loginPost');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile',   [DashboardController::class, 'profile'])->name('profile');

    Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {
        Route::post('update/{id}', [PagesController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
        Route::get('show',         [PostController::class, 'show'])->name('show');
        Route::get('select',       [PostController::class, 'select'])->name('select');
        Route::get('create',       [PostController::class, 'create'])->name('create')->middleware('access:user');
        Route::get('detail/{id}',  [PostController::class, 'detail'])->name('detail');
        Route::get('review/{id}',  [PostController::class, 'review'])->name('review');
        Route::get('edit/{id}',    [PostController::class, 'edit'])->name('edit');
        Route::get('delete/{id}',  [PostController::class, 'delete'])->name('delete');
        Route::post('update/{id}', [PostController::class, 'update'])->name('update');
        Route::post('store',       [PostController::class, 'store'])->name('store');
        Route::post('upload',      [PostController::class, 'upload'])->name('upload');
        Route::post('verif/{id}',  [PostController::class, 'verif'])->name('verif')->middleware('access:admin');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('show',         [CategoryController::class, 'show'])->name('show');
        Route::get('select',       [CategoryController::class, 'select'])->name('select');
        Route::get('detail/{id}',  [CategoryController::class, 'detail'])->name('detail');
        Route::get('edit/{id}',    [CategoryController::class, 'edit'])->name('edit');
        Route::get('delete/{id}',  [CategoryController::class, 'destroy'])->name('delete');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('store',       [CategoryController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'sub-category', 'as' => 'sub-category.'], function () {
        Route::get('show',         [SubCategoryController::class, 'show'])->name('show');
        Route::get('select',       [SubCategoryController::class, 'select'])->name('select');
        Route::get('detail/{id}',  [SubCategoryController::class, 'detail'])->name('detail');
        Route::get('edit/{id}',    [SubCategoryController::class, 'edit'])->name('edit');
        Route::get('delete/{id}',  [SubCategoryController::class, 'destroy'])->name('delete');
        Route::post('update/{id}', [SubCategoryController::class, 'update'])->name('update');
        Route::post('store',       [SubCategoryController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'tag', 'as' => 'tag.'], function () {
        Route::get('show',         [TagController::class, 'show'])->name('show');
        Route::get('select',       [TagController::class, 'select'])->name('select');
        Route::get('detail/{id}',  [TagController::class, 'detail'])->name('detail');
        Route::get('edit/{id}',    [TagController::class, 'edit'])->name('edit');
        Route::get('delete/{id}',  [TagController::class, 'delete'])->name('delete');
        Route::post('update/{id}', [TagController::class, 'update'])->name('update');
        Route::post('store',       [TagController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('show',         [UserController::class, 'show'])->name('show');
        Route::get('select',       [UserController::class, 'select'])->name('select');
        Route::get('detail/{id}',  [UserController::class, 'detail'])->name('detail');
        Route::get('edit/{id}',    [UserController::class, 'edit'])->name('edit');
        Route::get('delete/{id}',  [UserController::class, 'delete'])->name('delete');
        Route::post('update/{id}', [UserController::class, 'update'])->name('update');
        Route::post('store',       [UserController::class, 'store'])->name('store');
    });
});
