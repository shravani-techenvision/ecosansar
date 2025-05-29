<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;
    protected $fillable = [
         
        'post_id',
        'notify_id',
        'post_usertype',
        'notification_status'
    ];
}
