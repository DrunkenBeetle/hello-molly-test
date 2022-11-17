<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unsplash extends Model
{
    public $fillable = [
        'search_term'
    ];

    public function items()
    {
        return $this->hasMany(UnsplashItem::class);
    }
}
