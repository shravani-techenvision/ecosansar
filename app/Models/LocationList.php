<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationList extends Model
{
    use SoftDeletes;

    protected $table = 'location_lists';

    protected $fillable = [
        'name',
        'phone',
        'address',
        'pincode',
        'latitude',
        'longitude',
        'rating',
    ];
}