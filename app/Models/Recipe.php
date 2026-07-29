<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Recipe extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'recipes';

    protected $fillable = [
        'id', 'name', 'ingredients', 'time',
        'difficulty', 'portion', 'image', 'steps',
    ];

    // MongoDB sudah mengembalikan array secara native,
    // hanya cast tipe numerik saja supaya tidak jadi string
    protected $casts = [
        'id'      => 'integer',
        'time'    => 'integer',
        'portion' => 'integer',
    ];
}
