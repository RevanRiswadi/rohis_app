<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KajianAttendance extends Model
{
    protected $table = 'kajian_attendances';

    protected $fillable = [
        'schedule_id',
        'piket_member_id',
        'hadir',
    ];

    protected $casts = [
        'hadir' => 'boolean',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(PiketMember::class, 'piket_member_id');
    }
}
