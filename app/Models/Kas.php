<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    // Supaya Laravel tahu kalau tabel kita namanya 'kas'
    protected $table = 'kas';

    // Kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'tanggal',
        'jenis',
        'nominal',
        'keterangan',
    ];
}
