<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'username',
        'password',
        'image',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Automatically hash passwords only if needed.
     * But allow plain text (for older or non-bcrypt passwords).
     */
    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return;
        }

        // ✅ Check if password already hashed with bcrypt
        if (Hash::info($value)['algo'] === 'bcrypt') {
            $this->attributes['password'] = $value;
        }
        // ✅ Check if password looks like a bcrypt hash (starts with $2y$)
        elseif (str_starts_with($value, '$2y$')) {
            $this->attributes['password'] = $value;
        }
        else {
            // ✅ Save as plain text (no bcrypt)
            $this->attributes['password'] = $value;
        }
    }
}
