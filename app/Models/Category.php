<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // or 'categories' if that's your table name
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'description',
    ];
}
