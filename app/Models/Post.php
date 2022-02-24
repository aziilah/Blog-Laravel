<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Sluggable;


    protected $guarded = ['id'];
                // use with is a Eager Loading

    protected $with = ['category', 'author'];   

    public function scopeFilter($query, array $filters)
    {
        
        // Callback
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                 $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
             });
         });

        // Callback
        $query->when($filters['category'] ?? false, 
        function($query, $category) {   
            return $query->whereHas('category', function($query) use ($category)//query ini punya relationship dengan category, kita akan lakukan apa.. //use ($category) meruujk kepada untuk keseluruhan query ni
            { 
                $query->where('slug', $category);
            });
        });

        // arrow function
        $query->when($filters['author'] ?? false, 
        fn($query, $author) => 
            $query->whereHas('author', fn($query) =>        $query->where('username', $author)
            )
            );

    }
    public function category()
    {
        return $this->belongsTo(Category::class); 
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

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
