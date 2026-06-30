<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DownloadPoster extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'poster_image',
        'poster_pdf',
        'status'
    ];
}
