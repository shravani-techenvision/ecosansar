<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Pincode;
use App\Models\frontend\PincodeCheckSave;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use DB;

class PincodeCheckController extends Controller
{
   public function checkPincode(Request $request)
    {
           
        // Validate the pincode
        $request->validate([
            'pincode' => 'required|digits:6', // Adjust this rule according to your requirements
        ]);

        $pincode = $request->input('pincode');

        // Check if the pincode exists in the database
        $exists = Pincode::where('pincode', $pincode)->exists();

        if ($exists) {
            // If it exists, return a message
            return response()->json(['success' => true, 'message' => 'Yay! We’re Available in Your Area! ']);
        } else {
            // If it does not exist, redirect to a new page
            return redirect('/service-not-available'); // Adjust this to your actual route
        }
    }
    public function servicenotavailable(){
        return view('frontend/servicenotavail');
    }
     public function checkPincodeSave(Request $req){
         
         
        $req->validate([
            'collagent_name' => 'required',
            'collagent_phoneno' => 'required',
            'address2' => 'required',
        ]);
        $pincode = new PincodeCheckSave();
         $pincode->collagent_name = $req->collagent_name;
          $pincode->collagent_phoneno = $req->collagent_phoneno;
          
        $pincode->name = $req->name;
        $pincode->phone_no = $req->phone_no;
          $pincode->latitude = $req->latitude2;
        $pincode->longitude = $req->longitude2;
         $pincode->address = $req->address2;
          $pincode->message = $req->message;
        $pincode->save();
        Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
    }
// public function nearby(Request $request)
// {
//     $enteredPincode = $request->pincode;

//     // Step 1: Find latitude/longitude of entered pincode from ecosansar_users table
//     $userLocation = DB::table('ecosansar_users')
//         ->where('pincode', $enteredPincode)
//         ->whereNotNull('latitude')
//         ->whereNotNull('longitude')
//         ->first();

//     if (!$userLocation) {
//         return response()->json([], 404); // No such pincode exists
//     }

//     $latitude = $userLocation->latitude;
//     $longitude = $userLocation->longitude;

//     // Step 2: Fetch collection agents from nearby pincodes (within 40km for now)
//     $users = DB::table('ecosansar_users as eu')
//         ->leftJoin('recyclable_reviews as rr', 'eu.id', '=', 'rr.user_id')
//          ->where('eu.user_type', 'sab')  
//         ->whereNotNull('eu.latitude')
//         ->whereNotNull('eu.longitude')
//         ->select(
//             'eu.id',
//             'eu.name',
//             'eu.user_type',
//             'eu.address',
//             'eu.mobile',
//             'eu.pincode',
//             'eu.latitude',
//             'eu.longitude',
//             DB::raw('ROUND(AVG(rr.rating), 1) as avg_rating'),
//             DB::raw("(
//                 6371 * acos(
//                     cos(radians($latitude)) *
//                     cos(radians(eu.latitude)) *
//                     cos(radians(eu.longitude) - radians($longitude)) +
//                     sin(radians($latitude)) *
//                     sin(radians(eu.latitude))
//                 )
//             ) AS distance")
//         )
//         ->groupBy('eu.id', 'eu.name', 'eu.address', 'eu.mobile', 'eu.pincode', 'eu.latitude', 'eu.longitude')
//       // ->having('distance', '<=', 40) // Initially set to 40 km radius
//         ->orderBy('distance')
//         ->get();

//     return response()->json([
//         'data' => $users
//     ]);
// }

public function nearby(Request $request)
{
    $enteredPincode = $request->pincode;

    // Step 1: Try to get lat/lng of entered pincode from existing users
    $userLocation = DB::table('ecosansar_users')
        ->where('pincode', $enteredPincode)
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->first();

    // Step 2: If not found, get lat/lng of closest pincode from users table
    if (!$userLocation) {
        $fallback = DB::table('ecosansar_users')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('latitude', 'longitude')
            ->groupBy('latitude', 'longitude')
            ->first(); // fallback to any valid lat/lng from table

        if (!$fallback) {
            return response()->json([
                'data' => [],
                'message' => 'No valid location found to perform nearby search.'
            ], 404);
        }

        $latitude = $fallback->latitude;
        $longitude = $fallback->longitude;
    } else {
        $latitude = $userLocation->latitude;
        $longitude = $userLocation->longitude;
    }

    // Step 3: Get nearby users (sab only)
    $users = DB::table('ecosansar_users as eu')
        ->leftJoin('recyclable_reviews as rr', 'eu.id', '=', 'rr.user_id')
        ->where('eu.user_type', 'sab')
        ->whereNotNull('eu.latitude')
        ->whereNotNull('eu.longitude')
        ->select(
            'eu.id',
            'eu.name',
            'eu.user_type',
            'eu.address',
            'eu.mobile',
            'eu.pincode',
            'eu.latitude',
            'eu.longitude',
            DB::raw('ROUND(AVG(rr.rating), 1) as avg_rating'),
            DB::raw("(
                6371 * acos(
                    cos(radians($latitude)) *
                    cos(radians(eu.latitude)) *
                    cos(radians(eu.longitude) - radians($longitude)) +
                    sin(radians($latitude)) *
                    sin(radians(eu.latitude))
                )
            ) AS distance")
        )
        ->groupBy('eu.id', 'eu.name', 'eu.address', 'eu.mobile', 'eu.pincode', 'eu.latitude', 'eu.longitude')
        ->orderBy('distance')
        ->get();

    return response()->json([
        'data' => $users
    ]);
}





}
