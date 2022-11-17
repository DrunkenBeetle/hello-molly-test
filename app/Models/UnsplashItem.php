<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnsplashItem extends Model
{
    public $fillable = [
        'unsplash_api_id',
        'description',
        'full_url',
        'thumbnail_url'
    ];
}
