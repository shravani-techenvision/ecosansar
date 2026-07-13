<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurImpact extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'count',
        'suffix',
        'description',
        'display_order',
        'status',
    ];
}
