<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'restaurants';

    protected $fillable = [
        'user_id', 'name', 'name_katakana', 'review',
        'food_picture', 'map_url', 'comment', 'tel', 
        // 'categorie',
         'deleted_at', 'categorieId'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class);
    }
}
