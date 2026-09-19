<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Otomatis membuat 'slug' dari 'title' sebelum disimpan
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($announcement) {
            if (empty($announcement->slug)) {
                $announcement->slug = Str::slug($announcement->title);
            }
        });

        static::updating(function ($announcement) {
            if ($announcement->isDirty('title') && empty($announcement->slug)) {
                $announcement->slug = Str::slug($announcement->title);
            }
        });
    }
}
