<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiketAttendance extends Model
{
    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(PiketMember::class, 'piket_member_id');
    }
}
