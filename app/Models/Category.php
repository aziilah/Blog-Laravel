<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function posts() //posts() sebab ada banyak aka Many
    {
        //1 category hasMany posts
        return $this->hasMany(Post::class);
    }
}
