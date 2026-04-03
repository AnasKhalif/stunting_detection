<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable implements LaratrustUser
{
    use HasApiTokens;
    use HasRolesAndPermissions;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'name',
        'phone_number',
        'address',
        'date_of_birth',
        'gender',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth'     => 'date',
            'password'          => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Model $model): void {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }
        });
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function stuntingResults()
    {
        return $this->hasMany(StuntingResult::class);
    }

    public function consultationsAsParent()
    {
        return $this->hasMany(Consultation::class, 'parent_id');
    }

    public function consultationsAsHealthWorker()
    {
        return $this->hasMany(Consultation::class, 'health_worker_id');
    }

    public function healthWorkerProfile()
    {
        return $this->hasOne(HealthWorkerProfile::class);
    }
}
