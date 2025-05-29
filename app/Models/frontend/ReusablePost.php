<?php

namespace App\Models\frontend;
use App\Models\admin\ReusableResource;
use App\Models\admin\Weight;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReusablePost extends Model
{
    use HasFactory;
     public function resource()
{
    return $this->belongsTo(ReusableResource::class, 'resource_type', 'id');
}

public function weight()
{
    return $this->belongsTo(Weight::class, 'quantity', 'id');
}
public function user()
    {
        return $this->belongsTo(EcosansarUsers::class);
    }
}
