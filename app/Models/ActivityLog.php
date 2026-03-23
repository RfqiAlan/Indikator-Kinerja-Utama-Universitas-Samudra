<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'description',
        'ip_address',
        'user_agent',
        'email',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: only security/auth related logs.
     */
    public function scopeSecurity($query)
    {
        return $query->whereIn('action', [
            'login',
            'login_failed',
            'logout',
            'password_reset_request',
            'password_reset',
            'password_change',
            'lockout',
        ]);
    }
}
