<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RecyclableReview extends Model
{
    use HasFactory;
    public function user()
{
    return $this->belongsTo(EcosansarUsers::class, 'login_user_id', 'id');
}

}
