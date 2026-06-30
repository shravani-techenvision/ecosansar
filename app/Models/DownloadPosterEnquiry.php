<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadPosterEnquiry extends Model
{
    use HasFactory;

    protected $table = 'download_poster_enquiries';

    protected $fillable = [
        'download_poster_id',
        'user_id',
        'name',
        'email',
        'mobile',
        'organization',
    ];

    /**
     * Relationship with Download Poster
     */
    public function poster()
    {
        return $this->belongsTo(DownloadPoster::class, 'download_poster_id');
    }

    /**
     * Relationship with Ecosansar User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\frontend\EcosansarUsers::class, 'user_id');
    }
}