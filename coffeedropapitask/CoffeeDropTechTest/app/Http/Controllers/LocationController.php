<?php

namespace App\Http\Controllers;

use App\Models\Location;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller 
{
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        $distance = $earthRadius * $c; 

        Log::info('Haversine Calculation:', [
            'lat1' => $lat1,
            'lon1' => $lon1,
            'lat2' => $lat2,
            'lon2' => $lon2,
            'latDelta' => $latDelta,
            'lonDelta' => $lonDelta,
            'a' => $a,
            'c' => $c,
            'distance' => $distance
        ]);

        return $distance;
    }

    public function popLatLngLocation(){
        $locations = Location::all();

        foreach($locations as $location){
            if($location->postcode && empty($location->latitude) && empty($location->longitude)){
                $response = Http::get("https://api.postcodes.io/postcodes/{$location->postcode}");

                Log::info("Postcodes.io Response for {$location->postcode}: ", $response->json());

                if($response->successful()){
                    $data = $response->json();

                    if (!empty($data['result']['latitude']) && !empty($data['result']['longitude'])) {
                        $location->latitude = $data['result']['latitude'];
                        $location->longitude = $data['result']['longitude'];
                        $location->save();
                       
                        Log::info("Updated {$location->postcode} with latitude {$data['result']['latitude']} and longitude {$data['result']['longitude']}");
                    }
                } else{
                    Log::warning("Failed to log coords for postcode: {$location->postcode}");
                }
            }
        }

        $locations = Location::all();
        Log::info('Locations with coordinates after update:', $locations->toArray());
    }

    public function store(Request $request)
    {
        $request->validate([
            'postcode' => 'required|string',
            'address' => 'nullable|string',
            'opening_time' => 'nullable|array',
            'closing_time' => 'nullable|array',
        ]);
    
        $postcode = $request->input('postcode');
    
        $response = Http::get("https://api.postcodes.io/postcodes/{$postcode}");
    
        if ($response->failed()) {
            return response()->json(['error' => 'Invalid postcode'], 400);
        }
    
        $data = $response->json();
        $latitude = $data['result']['latitude'] ?? null;
        $longitude = $data['result']['longitude'] ?? null;

        $opening_times = $request->input('opening_times', []);
        $closing_times = $request->input('closing_times', []);
    
        $location = new Location();
        
        $location->postcode = $postcode;
        $location->address = $request->input('address');

        $location->open_monday = $opening_times['monday'] ?? null;
        $location->open_tuesday = $opening_times['tuesday'] ?? null;
        $location->open_wednesday = $opening_times['wednesday'] ?? null;
        $location->open_thursday = $opening_times['thursday'] ?? null;
        $location->open_friday = $opening_times['friday'] ?? null;
        $location->open_saturday = $opening_times['saturday'] ?? null;
        $location->open_sunday = $opening_times['sunday'] ?? null;

        $location->closed_monday = $closing_times['monday'] ?? null;
        $location->closed_tuesday = $closing_times['tuesday'] ?? null;
        $location->closed_wednesday = $closing_times['wednesday'] ?? null;
        $location->closed_thursday = $closing_times['thursday'] ?? null;
        $location->closed_friday = $closing_times['friday'] ?? null;
        $location->closed_saturday = $closing_times['saturday'] ?? null;
        $location->closed_sunday = $closing_times['sunday'] ?? null;

        $location->latitude = $latitude;
        $location->longitude = $longitude;

        $location->save();

        if ($location->save()) {
            Log::info("Location created successfully:", [
                'location_id' => $location->id,
                'postcode' => $location->postcode,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude
            ]);
        } else {
            Log::error("Failed to save location.");
        }


        if (!$location) {
            return response()->json(['error' => 'Failed to save location'], 500);
        }

        return response()->json($location, 201);
    }

    public function getNearestLocation(Request $request)
    {
        $request->validate([
            'postcode' => 'required|string'
        ]);

        $postcode = $request->input('postcode');

        $response = Http::get("https://api.postcodes.io/postcodes/{$postcode}");

        if ($response->failed()) {
            return response()->json(['error' => 'Invalid postcode'], 400);
        }

        $data = $response->json();

        if (!isset($data['result']['latitude']) || !isset($data['result']['longitude'])) {
            return response()->json(['error' => 'Could not fetch coordinates for postcode'], 400);
        }

        $lat = $data['result']['latitude'];
        $lng = $data['result']['longitude'];

        Log::info('Postcode coordinates: ', [
            'latitude' => $lat,
            'longitude' => $lng
        ]);

        $locations = Location::all();
        Log::info('Locations with coordinates:', $locations->toArray());

        if ($locations->isEmpty()) {
            return response()->json(['error' => 'No locations found'], 404);
        }

        $nearestLocation = null;
        $shortestDistance = PHP_FLOAT_MAX;

        foreach ($locations as $location) {
            if (!$location->latitude || !$location->longitude) {
                continue;
            }

            $distance = $this->haversineDistance($lat, $lng, $location->latitude, $location->longitude);

            Log::info('Checking Location:', [
                'location_id' => $location->id,
                'postcode' => $location->postcode,
                'lat' => $location->latitude,
                'lng' => $location->longitude,
                'distance_km' => $distance
            ]);

            if ($distance < $shortestDistance) {
                $shortestDistance = $distance;
                $nearestLocation = $location;
            }
        }

        if($nearestLocation){
            Log::info('Nearest location found: ', ['postcode' => $nearestLocation->postcode, 'distance_km' => $shortestDistance]);
        } else {
            Log::info('No nearest location found.');
        }

        if ($nearestLocation) {
            return response()->json([
                'nearest_location' => $nearestLocation,
                'distance_km' => round($shortestDistance, 2)
            ]);
        } else {
            return response()->json(['error' => 'No suitable locations found'], 404);
        }
    }
}