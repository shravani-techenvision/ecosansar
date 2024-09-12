<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\UserActivityLog;

class UserActivityController extends Controller
{
    
    public function logActivity_save(string $activity, Request $request)
    {
        if (auth()->check()){
            UserActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => $activity,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
            ]);
        }
    }
    
}
