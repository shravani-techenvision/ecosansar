<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionDrive extends Model
{
    protected $fillable = [
        'name',
        'contact_number',
        'location',
        'participants',
    ];
}