<?php

use App\Models\Category;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home', [  //home.blade.php
        "title" =>  "Home",
        "active" => "home"
    ]);
});

Route::get('/about', function () {
    return view('about', [  //about.blade.php
        "title" => "About",
        "name" => "Aziilah",
        "email" => "aziilahawg@gmail",
        "image" => "naevis.png",
        "active" => "about",
    ]);
});

//panggil Controller yg ada Class Index()
Route::get('/posts', [PostController::class, 'index']);

// HALAMAN SINGLE POST
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

Route::get('/categories', function() {
    return view('categories', [
        'title' => 'Post Categories',
        'active' => "categories",
        'categories' => Category::all() //ambil dari Model Category
        
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest'); //->name('login') merujuk kasi tahu laravel mana route login (if user masuk page tanpa auth, dia kena redirect ke halaman login)
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', function() {
    return view('/dashboard.index');
})->middleware('auth');

//slug
// ketika ada request dlm method get ke url, panggil controller dan method nya
Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

//CRUD
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

/*
Route::get('/categories/{category:slug}', function(Category $category) {
    return view('posts', [
        'title' => "Post By Category : $category->name",
        "active" => "categories",
        'posts' => $category->posts->load('category', 'author')    //1 category has Many posts
        
    ]);
});

Route::get('/authors/{author:username}', function(User $author) { //{user} = user_id sebab Default
    return view('posts', [
        'title' => "Post By Author : $author->name",
        "active" => "posts",
        'posts' => $author->posts->load('category', 'author'), //1 user hasMany posts //setelah ambil semua data posts, kita load category&authorakauser
        //select author ikut username, select posts ikut posts.userId, dan load category n user Models
    ]);
});


//kalau ada user akses ke alamat ini, jalankan function atas
//mengembalikan sebuah view
*/

Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');
