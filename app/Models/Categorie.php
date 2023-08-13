<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Categorie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'user_id', 'name', 'deleted_at'
    ];

    // public function categoriy_tags(){
    //     return $this->hasMany(CategoriyTag::class);
    // }

    // public static function booted(){
    //     static::deleted(function($categorie){
    //         // dd($categorie);
    //         $categorie->categoriy_tags()->delete();
    //     });
    // }
}
