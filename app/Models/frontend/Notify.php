<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'pincode',
        'resource',
    ];
     public function user()
    {
        return $this->belongsTo(EcosansarUsers::class); // Assuming User model is named "User"
    }
}
