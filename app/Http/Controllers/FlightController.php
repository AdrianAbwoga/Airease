<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function searchFlights(Request $request)
    {
        $accessKey = '1c69867d3f54c5cf05a2f79404d5ecea';
        $departure = $request->input('departure');
        $arrival = $request->input('arrival');

        $client = new Client();
        $response = $client->request('GET', 'http://api.aviationstack.com/v1/flights', [
            'query' => [
                'access_key' => $accessKey,
                'dep_iata' => $departure,
                'arr_iata' => $arrival,
            ],
        ]);

        $flightData = json_decode($response->getBody(), true);

        // Process the flight data and return the view with flight data
        return view('flight-search')->with('flightData', $flightData['data']);
    }
}
