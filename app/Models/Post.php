<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    //property mana yang boleh diisi oleh user
    // protected $fillable = [
    //     'title',
    //     'excerpt',
    //     'body',
    // ];

    //tidak boleh diisi
    protected $guarded = ['id'];
                // use with is a Eager Loading
            // ambil semua data dlm table posts, serta users@author dan categories (buat 3 query ja)
            // letak parameter, selepas looping, x query tapi ambil data dlm post

    protected $with = ['category', 'author'];   //Eager Loading //setiap panggilan query Posts, category & author pun ikut

    public function scopeFilter($query, array $filters)
    {
        // // if ada searching dalam column Search
        // if( isset($filters['search']) ? $filters['search'] : false) {
        //     return $query->where('title', 'like', '%' . $filters['search'] . '%')
        //     ->orWhere('body', 'like', '%' . $filters['search'] . '%' );
        // }
        
        //versi Callback
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                 $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
             });
         });

        //versi Callback
        $query->when($filters['category'] ?? false, 
        function($query, $category) {   //join table dengan category  //chaining query
            return $query->whereHas('category', function($query) use ($category)//query ini punya relationship dengan category, kita akan lakukan apa.. //use ($category) meruujk kepada untuk keseluruhan query ni
            { 
                $query->where('slug', $category);//query dimana slug sama dgn category
            });
        });

        //versi arrow function
        $query->when($filters['author'] ?? false, 
        fn($query, $author) => 
            $query->whereHas('author', fn($query) =>        $query->where('username', $author)
            )
            );

    }
    //hubungkan Model Post dengan Model Category
    //nama method = nama Model (yg mahu dihubungkan)
    public function category()
    {
        //mengembalikan relation dari Model Post dengan Model Category
        //Model Post belongTo Model Category
        //1 post belongsTo 1 category
        return $this->belongsTo(Category::class); 
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id'); //tambah parameter user_id sebagai alias author
    }

    //dashboardpostcontroller
    //setiap Route akan cari post_'slug' bukan post_id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    //SLUGGABLE
    // class Post extends Model
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }





}
