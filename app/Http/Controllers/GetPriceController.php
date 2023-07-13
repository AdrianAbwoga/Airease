<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class GetPriceController extends Controller
{
    public function __invoke(Request $request)
    {
        $flightData = json_decode($request->query('flight'));

        $airline = $flightData->itineraries[0]->segments[0]->carrierCode;
        $departure = $flightData->itineraries[0]->segments[0]->departure->iataCode;
        $destination = $flightData->itineraries[0]->segments[0]->arrival->iataCode;
        $travelClass = $flightData->travelerPricings[0]->fareDetailsBySegment[0]->cabin;
        $price = $flightData->price->total;

        /*
        <p class="mb-1">Airline: {{ $flight->itineraries[0]->segments[0]->carrierCode }}</p>
                                    <p class="mb-1">Departure: {{ $flight->itineraries[0]->segments[0]->departure->iataCode }}</p>
                                    <p class="mb-1">Destination: {{ $flight->itineraries[0]->segments[0]->arrival->iataCode }}</p>
                                    <p class="mb-1">Travel Class: {{ $flight->travelerPricings[0]->fareDetailsBySegment[0]->cabin }}</p>
                                    <p class="mb-1">Price (EUR): {{ $flight->price->total }}</p>



        if ($request->isMethod('post')) {
            // Handle payment processing logic based on the selected payment method
            $paymentMethod = $request->input('payment_method');

            // Perform payment processing and redirect to success or failure page
            // ...
        }*/

        return view('price')->with([
            'airline' => $airline,
            'departure' => $departure,
            'destination' => $destination,
            'travelClass' => $travelClass,
            'price' => $price,
        ]);
    }
}