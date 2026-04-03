<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'health_worker_id',
        'child_id',
        'status',
        'subject',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function healthWorker()
    {
        return $this->belongsTo(User::class, 'health_worker_id');
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function messages()
    {
        return $this->hasMany(ConsultationMessage::class);
    }
}
