<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity',
        'url',
        'method',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}