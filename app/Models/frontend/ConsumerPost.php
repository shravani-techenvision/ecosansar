<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\Weight;

class ConsumerPost extends Model
{
    public function weight()
    {
        return $this->belongsTo(Weight::class, 'quantity');
    }
    // public function resource()
    // {
    //     // Assuming you have a ConsumerResourcePost model
    //     return $this->hasOne(ConsumerResourcePost::class, 'post_id'); // Adjust the foreign key column name
    // }
}
