<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'nisn', 'class', 'major', 'whatsapp_number',
        'reason', 'preferred_division', 'status',
    ];

    public static function pendingCount(): int
    {
        return static::query()
            ->whereRaw('LOWER(status) = ?', ['pending'])
            ->count();
    }

    public static function statusCounts(): array
    {
        $counts = static::query()
            ->selectRaw('LOWER(status) as status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'pending' => (int) ($counts['pending'] ?? 0),
            'accepted' => (int) ($counts['accepted'] ?? 0),
            'rejected' => (int) ($counts['rejected'] ?? 0),
        ];
    }
}
