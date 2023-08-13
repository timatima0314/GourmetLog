<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriyTag extends Model
{
    use HasFactory;

    protected $table = 'categoriy_tags';
    protected $fillable = [
        'category_id', 'restaurant_id'
    ];
    // public function categoie()
    // {
    //     return $this->belongsTo(Categorie::class);
    // }
}
