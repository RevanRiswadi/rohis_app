<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasPengeluaran extends Model
{
    protected $table = 'kas_pengeluaran';

    protected $fillable = [
        'tanggal',
        'keperluan',
        'nominal',
        'catatan',
        'foto_struk',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
