<?php

namespace App\Models\frontend;
use App\Models\admin\Resource;
use App\Models\admin\Weight;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclablePost extends Model
{
    use HasFactory;
    public function resource()
{
    return $this->belongsTo(Resource::class, 'resource_type', 'id');
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
