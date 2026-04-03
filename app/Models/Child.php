<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'date_of_birth',
        'birth_weight',
        'birth_height',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'birth_weight'  => 'decimal:2',
            'birth_height'  => 'decimal:2',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stuntingResults()
    {
        return $this->hasMany(StuntingResult::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Hitung usia anak dalam bulan
     */
    public function getAgeInMonthsAttribute(): int
    {
        return (int) $this->date_of_birth->diffInMonths(now());
    }
}
