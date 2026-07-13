<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowItWorksSection extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'step_number',
        'title',
        'description',
        'image',
        'position'
    ];
}
