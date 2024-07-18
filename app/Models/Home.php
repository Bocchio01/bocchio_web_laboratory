<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Home extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'img',
    ];


    // Clear projects cache upon modifying an entry
    protected static function boot()
    {
        parent::boot();

        static::saving(function() {
            Cache::forget('homes');
        });
    }
}