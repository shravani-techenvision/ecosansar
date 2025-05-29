<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\EcosansarUsers;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
     // Function to get the user counts, grouped by address and user type
    public function getUserCounts()
    {
        // Fetch the user counts grouped by location (address) and user type
        $userCounts = EcosansarUsers::select('address', 'user_type', \DB::raw('count(*) as total'))
            ->groupBy('address', 'user_type')
            ->get();
    
        return response()->json($userCounts);
    }

    // Function to geocode an address using the Nominatim API
    public function geocodeAddress(Request $request)
    {
        $address = $request->input('address');

        // Send a request to Nominatim to get coordinates for the address
        $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($address) . "&format=json&limit=1";
        $response = Http::get($url);

        // Return the coordinates (latitude and longitude) from the API response
        return $response->json();
    }
}
