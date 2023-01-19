<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Weather;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function getWeather(Request $request) {
        $token = $request->header('x-token');

        if ($token !== env('XTOKEN')) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token'
            ]);
        } else {
            $date = date('Y-m-d', strtotime($request->day));
            $weathers = Weather::whereDate('created_at', $date)->get();

            return response()->json([
                'status' => true,
                'data' => $weathers,
                'message' => 'Success'
            ]);
        }
    }
}
