<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $guarded = [

    ];

    //sacando las cats para getAlbums
    public function Category()
    {
        # code...
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
