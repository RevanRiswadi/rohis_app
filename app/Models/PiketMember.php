<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiketMember extends Model
{
    protected $guarded = ['id'];

    public function attendances()
    {
        return $this->hasMany(PiketAttendance::class);
    }

    public function kasIuran()
    {
        return $this->hasMany(KasIuran::class);
    }

    public function kajianAttendances()
    {
        return $this->hasMany(KajianAttendance::class);
    }
}
