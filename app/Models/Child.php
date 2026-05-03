<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'name',
        'gender',
        'date_of_birth',
        'birth_weight',
        'birth_height',
        'asi_eksklusif',
        'photo',
    ];

    protected static function booted(): void
    {
        static::creating(function ($child) {
            $child->uuid = $child->uuid ?? \Illuminate\Support\Str::uuid();
        });
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'birth_weight'  => 'decimal:2',
            'birth_height'  => 'decimal:2',
            'asi_eksklusif' => 'boolean',
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

    public function vaccinations()
    {
        return $this->hasMany(ChildVaccination::class);
    }

    /**
     * Hitung usia anak dalam bulan
     */
    public function getAgeInMonthsAttribute(): int
    {
        return (int) $this->date_of_birth->diffInMonths(now());
    }
}
