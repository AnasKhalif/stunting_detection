<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\City;

class StuntingResult extends Model
{
    use HasFactory;

    protected $table = 'stunting_results';

    protected $fillable = [
        'gender',
        'age',
        'birth_weight',
        'birth_length',
        'weight',
        'height',
        'city_id',
        'prediction_result',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
