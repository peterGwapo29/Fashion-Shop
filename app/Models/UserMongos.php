<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserMongos extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'users_mongos';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'address',
        'contact_number',
        'email',
        'password',
        'google_id',
        'google_token',
        'google_refresh_token',
        'image'
    ];
}
