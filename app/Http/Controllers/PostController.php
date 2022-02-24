<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;


class PostController extends Controller
{
    //buat method default
    public function index()
    {
        $title = '';    //pada awal title ini kosong

        if(request('category')) {
            $category = Category::firstWhere('slug', request('category')); //cari dlm db Category yg slug sama dgn category
            $title = ' in ' . $category->name; //klu ada category, timpa jadi title
        }

        if(request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = ' by ' . $author->name;
        }


        return view('posts', [  //posts.blade.php
            "title" => "All Posts" . $title, //$title dapat dari request diatas
            "active" => "posts",
            // "posts" => Post::all(), //panggil Model Post guna :: dengan sebuah method all untuk dapatkan semua data posting
            // use with is a Eager Loading
            // ambil semua data dlm table posts, serta users@author dan categories (buat 3 query ja)
            // letak parameter, selepas looping, x query tapi ambil data dlm post
            // "posts" => Post::latest()->get() //data latest akan diletak diatas
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString() //untuk pagination
        ]);
    }

    //untuk menampilkan satu posting
    public function show(Post $post) //Route kirim Class Model(Post) ke sini utk diikat / bind disini, $post adalah variable yg di tangkap dari Route sana {post}! MESTI SAMA!!!
    {
        return view('post', [   //post.blade.php
            "title" => "Single Post",
            "active" => "posts",
            "post" => $post, //cari posting merujuk dari slug..ambil dari funtion  parameetre diatas
        ]);
    }

}
