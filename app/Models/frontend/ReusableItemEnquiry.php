<?php

namespace App\Models\frontend;

use App\Models\admin\ReusableResource;
use App\Models\frontend\EcosansarUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReusableItemEnquiry extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'reusable_resource_id',
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
    public function resource()
    {
        return $this->belongsTo(ReusableResource::class, 'reusable_resource_id');
    }

    public function user()
    {
        return $this->belongsTo(EcosansarUsers::class, 'user_id');
    }
    
}
