<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    // Define the relationship with CommentReply
    public function replies()
    {
        return $this->hasMany(CommentReply::class, 'comment_id')->where('active', 1);
    }
}
