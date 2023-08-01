<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurants';

    protected $fillable = [
        'user_id', 'name', 'name_katakana', 'review', 'food_picture', 'map_url', 'comment', 'tel'
    ];
}
