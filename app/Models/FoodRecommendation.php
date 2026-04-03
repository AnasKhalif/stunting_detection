<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nutritional_info',
        'recipe',
        'category',
        'image',
    ];
}
