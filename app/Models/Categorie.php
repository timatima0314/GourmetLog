<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Categorie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'user_id', 'name', 'deleted_at'
    ];
    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'categoriy_tags','restaurant_id','category_id');
    }
}
