<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'event_date',
        'location',
        'speaker',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];
}
