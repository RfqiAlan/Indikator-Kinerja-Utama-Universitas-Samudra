<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'fakultas',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get fakultas data from config
     */
    public function getFakultasDataAttribute(): ?array
    {
        return config('unsam.fakultas.' . $this->fakultas);
    }

    /**
     * Get fakultas name
     */
    public function getFakultasNamaAttribute(): ?string
    {
        return $this->fakultas_data['nama'] ?? null;
    }

    /**
     * Get prodi list for this fakultas
     */
    public function getProdiListAttribute(): array
    {
        return $this->fakultas_data['prodi'] ?? [];
    }

    public function googleDriveToken(): HasOne
    {
        return $this->hasOne(GoogleDriveToken::class);
    }
}
