<?php

namespace App\Models\admin;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Volunteer extends Authenticatable
{
    use HasFactory, Notifiable;
     protected $fillable = [
        'name',
        'email',
        'password',
        // Add other fields here
    ];
}
