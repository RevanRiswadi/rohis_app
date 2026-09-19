<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasIuran extends Model
{
    protected $table = 'kas_iuran';

    protected $fillable = [
        'piket_member_id',
        'tanggal_pertemuan',
        'nominal',
        'sudah_bayar',
        'status_pertemuan',
        'keterangan_libur',
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date',
        'sudah_bayar' => 'boolean',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(PiketMember::class, 'piket_member_id');
    }
}
