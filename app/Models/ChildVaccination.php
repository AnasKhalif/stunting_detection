<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildVaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'vaccine_code',
        'given_date',
        'batch_no',
        'given_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'given_date' => 'date',
        ];
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function giver()
    {
        return $this->belongsTo(User::class, 'given_by');
    }
}
