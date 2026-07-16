<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Suggestion extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'suggestions';

    protected $fillable = [
        'pengirim', 'jenis', 'judul', 'konten', 'bahan', 'status',
        // Field resep lengkap (untuk usulan resep baru)
        'time', 'difficulty', 'portion', 'ingredients', 'steps', 'image',
    ];

    // Default values
    protected $attributes = [
        'pengirim' => 'Anonim',
        'status'   => 'baru',
        'bahan'    => '',
    ];

    protected $casts = [
        'time'    => 'integer',
        'portion' => 'integer',
    ];
}
