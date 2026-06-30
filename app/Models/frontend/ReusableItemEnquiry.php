<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReusableItemEnquiry extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'mobile',
        'quantity',
        'lid_colour',
        'delivery_place',
        'required_by_date',
        'notes',
    ];
    protected $dates = [
        'deleted_at',
    ];
    
}
