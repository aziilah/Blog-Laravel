<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class Post 
{
    //untuk simpan data 
    //buat properties static..boleh diakses mudah di class nya
    private static $blog_posts = [
        [
            "title" => "Judul Post Pertama Ilah",
            "slug" => "judul-post-pertama",
            "author" => "Aziilah Awang",
            "body" => "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illum assumenda quas dicta id eius nulla error ducimus maiores repudiandae voluptates, aliquid dignissimos inventore facilis excepturi eos necessitatibus delectus, cum suscipit soluta asperiores commodi non esse? Sunt quam possimus tenetur, accusantium quaerat aut fugit sint vel pariatur itaque. Similique temporibus cumque, iusto dolorum at eos laudantium non esse, vitae labore dolore reiciendis illum. Ad ipsum numquam architecto perferendis, voluptate autem asperiores optio hic corporis, debitis voluptatem sint earum id provident sit."
        ],
        [
            "title" => "Judul Post Kedua Dhika",
            "slug" => "judul-post-kedua",
            "author" => "Sandhika Galiih",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum, id. Facilis, quis libero! Soluta harum repellat consectetur quae? Earum, ipsum amet. Eaque quis voluptas enim totam ex minus perferendis asperiores cum in voluptate sunt natus repellendus accusamus facere neque commodi at perspiciatis numquam, explicabo, odio vero fugiat officiis voluptatem adipisci. Officia, commodi dolore aliquid incidunt voluptatibus porro, error perferendis dicta tempora cupiditate dignissimos vero facilis cumque veritatis, voluptate ipsum illum perspiciatis rem saepe fuga excepturi culpa consequatur. Impedit nam consectetur ea soluta? Dolores aliquid sed, expedita accusamus debitis sunt, maxime libero vel est, ducimus illo odit quia aliquam cum velit!"
        ]
        ];
    
        //method static
        public static function all()
        {   
            //untuk ambil semua data
            //kembalikan data blog_post diatas
            return collect(self::$blog_posts);  //wrap as a collection!!!
        }

        //untuk ambil satu data..ambil semua data dulu..baru looping
        public static function find($slug)
        {
            //ambil semua post..
            $posts = static::all(); //$posts jadi collection
            
        //     //posting yg dijumpa masuk ke dlm array
        //     $post = []; 

        //     //..looping one by one as $p
        //     foreach( $posts as $p) {  

        //     //if slug yg dikirim ke parameter..
        //     if( $p["slug"] === $slug) { 

        //         $post = $p; //..then masukkan posting tu ke dlm $post
        //     }
        // }

        return $posts->firstWhere('slug', $slug);   //klau jumpa, kembalikan hasilnya
        //ambil semua $posts yg bentuk dia collection ..lalu cari@kasi sebuah method bernama first() utk ambil data pertama..dimana 'slug' sama dengan $slug
    } 

}
