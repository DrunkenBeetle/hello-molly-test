<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unsplash extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(UnsplashItem::class);
    }
}
