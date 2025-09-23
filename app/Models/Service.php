<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Service extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'services';

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'duration', 
        'image', 
        'category',
        'is_featured'
    ];
}
