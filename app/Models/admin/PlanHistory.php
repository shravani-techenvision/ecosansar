<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanHistory extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'plan_id',
        'plan_price',
        'plan_expiration_date',
        'plan_validity',
    ];
}
