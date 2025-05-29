<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\frontend\ConsumerAskReview;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if 'user_id' is set in the session
        // if (!Session::has('user_id')) {
        //     // If not, redirect to the login page with the intended URL
        //     return redirect()->route('consumer_login')->with('redirect_conrev', $request->url());
        // }

        // return $next($request);
        
        
        
    

    // Retrieve the review request based on the 'review_id' parameter
     $reviewId = $request->query('review_id');
    $reviewRequest = ConsumerAskReview::find($reviewId);

    // Get the logged-in user ID from the session
     $loggedInUserId = Session::get('user_id'); 
  

    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest || $reviewRequest->user_id !== $loggedInUserId) {
        return redirect()->route('consumer_login')->with('error', 'Unauthorized access to this review request.');
    }

    return $next($request);
}
}
