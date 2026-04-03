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
        'user_id',
        'child_id',
        'gender',
        'age',
        'height',
        'weight',
        'city_id',
        'district_name',
        'measurement_date',
        'z_score',
        'prediction_result',
        'who_standard_ref',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'measurement_date' => 'date',
            'height'           => 'decimal:2',
            'weight'           => 'decimal:2',
            'z_score'          => 'decimal:3',
        ];
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
