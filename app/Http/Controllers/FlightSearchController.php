<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class FlightSearchController extends Controller
{
    /**
     * Using the GET endpoint
     * @param Request $request
     * @param Client $client
     * @return \Exception|GuzzleException|\Psr\Http\Message\StreamInterface
     */
//    public function __invoke (Request $request, Client $client)
//    {
//        $url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
//        $access_token = '8OGlswlpw0H6jmzvNk3p2V9wlBzW';
//
//        $data = [
//            'originLocationCode'     => 'BOS',
//            'destinationLocationCode' => 'PAR',
//            'departureDate'           => '2021-12-27',
//            'adults'                  => 1
//        ];
//
//        // To covert key value pairs into query parameters
//        $data = http_build_query($data);
//
//        // Append the query parameters to the URL
//        $url .= '?' . $data;
//
//        try {
//            $response = $client->get($url, [
//                'headers' => [
//                    'Accept' => 'application/json',
//                    'Authorization' => 'Bearer ' . $access_token
//                ],
//            ]);
//
//            return $response->getBody();
//        } catch (GuzzleException $exception) {
//            dd($exception);
//        }
//    }

    /**
     * Using the POST endpoint
     * @param Request $request
     * @param Client $client
     */
    public function __invoke (Request $request, Client $client)
    {
        $url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';

        if (session('access_token')) {
            $access_token = session('access_token');
        } else {
            $access_token = app('App\Http\Controllers\AccessTokenController')->__invoke($client)->access_token;
            session(['access_token' => $access_token]);
        }

        $travelers = [];

        for ($i = 1; $i <= $request['passengers']; $i++) {
            $travelers[] = [
                'id' => $i,
                'travelerType' => 'ADULT'
            ];
        }

        $data = [
            'originDestinations' => [
                [
                    'id' => 1,
                    'originLocationCode' => $request['from'],
                    'destinationLocationCode' => $request['to'],
                    'departureDateTimeRange' => [
                        'date' => $request['date']
                    ]
                ]
            ],
            'travelers' => $travelers,
            'sources' => [
                'GDS'
            ]
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token
                ],
                'json' => $data
            ]);

            $response = $response->getBody();
            $response = json_decode($response);

            return view('search')->with('flights', $response->data);
        } catch (GuzzleException $exception) {
            return $exception;
        }
    }
}

/* {
    "meta": {
        "count": 73,
        "links": {
            "self": "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=NBO&destinationLocationCode=PAR&departureDate=2023-07-16&adults=1"
        }
    },
    "data": [
        {
            "type": "flight-offer",
            "id": "1",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT11H",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:25:00"
                            },
                            "arrival": {
                                "iataCode": "CAI",
                                "terminal": "3",
                                "at": "2023-07-16T08:05:00"
                            },
                            "carrierCode": "MS",
                            "number": "850",
                            "aircraft": {
                                "code": "738"
                            },
                            "operating": {
                                "carrierCode": "MS"
                            },
                            "duration": "PT4H40M",
                            "id": "1",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "CAI",
                                "terminal": "3",
                                "at": "2023-07-16T09:40:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-16T14:25:00"
                            },
                            "carrierCode": "MS",
                            "number": "799",
                            "aircraft": {
                                "code": "789"
                            },
                            "operating": {
                                "carrierCode": "MS"
                            },
                            "duration": "PT4H45M",
                            "id": "2",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "440.62",
                "base": "179.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "440.62"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "MS"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "440.62",
                        "base": "179.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "1",
                            "cabin": "ECONOMY",
                            "fareBasis": "LRIKEO",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "2",
                            "cabin": "ECONOMY",
                            "fareBasis": "LRIKEO",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "2",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT18H40M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:25:00"
                            },
                            "arrival": {
                                "iataCode": "CAI",
                                "terminal": "3",
                                "at": "2023-07-16T08:05:00"
                            },
                            "carrierCode": "MS",
                            "number": "850",
                            "aircraft": {
                                "code": "738"
                            },
                            "operating": {
                                "carrierCode": "MS"
                            },
                            "duration": "PT4H40M",
                            "id": "85",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "CAI",
                                "terminal": "3",
                                "at": "2023-07-16T16:15:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-16T21:05:00"
                            },
                            "carrierCode": "MS",
                            "number": "801",
                            "aircraft": {
                                "code": "32N"
                            },
                            "operating": {
                                "carrierCode": "MS"
                            },
                            "duration": "PT5H50M",
                            "id": "86",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "441.20",
                "base": "179.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "441.20"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "MS"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "441.20",
                        "base": "179.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "85",
                            "cabin": "ECONOMY",
                            "fareBasis": "LRIKEO",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "86",
                            "cabin": "ECONOMY",
                            "fareBasis": "LRIKEO",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "3",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 7,
            "itineraries": [
                {
                    "duration": "PT12H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T19:00:00"
                            },
                            "arrival": {
                                "iataCode": "ADD",
                                "terminal": "2",
                                "at": "2023-07-16T21:10:00"
                            },
                            "carrierCode": "ET",
                            "number": "307",
                            "aircraft": {
                                "code": "7M8"
                            },
                            "operating": {
                                "carrierCode": "ET"
                            },
                            "duration": "PT2H10M",
                            "id": "109",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "ADD",
                                "terminal": "2",
                                "at": "2023-07-17T00:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2E",
                                "at": "2023-07-17T06:50:00"
                            },
                            "carrierCode": "ET",
                            "number": "734",
                            "aircraft": {
                                "code": "350"
                            },
                            "operating": {
                                "carrierCode": "ET"
                            },
                            "duration": "PT7H20M",
                            "id": "110",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "458.23",
                "base": "210.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "458.23"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "ET"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "458.23",
                        "base": "210.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "109",
                            "cabin": "ECONOMY",
                            "fareBasis": "HXOWKE",
                            "class": "H",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "110",
                            "cabin": "ECONOMY",
                            "fareBasis": "HXOWKE",
                            "class": "H",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "4",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 7,
            "itineraries": [
                {
                    "duration": "PT20H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T11:35:00"
                            },
                            "arrival": {
                                "iataCode": "ADD",
                                "terminal": "2",
                                "at": "2023-07-16T13:35:00"
                            },
                            "carrierCode": "ET",
                            "number": "319",
                            "aircraft": {
                                "code": "7M8"
                            },
                            "operating": {
                                "carrierCode": "ET"
                            },
                            "duration": "PT2H",
                            "id": "37",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "ADD",
                                "terminal": "2",
                                "at": "2023-07-17T00:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2E",
                                "at": "2023-07-17T06:50:00"
                            },
                            "carrierCode": "ET",
                            "number": "734",
                            "aircraft": {
                                "code": "350"
                            },
                            "operating": {
                                "carrierCode": "ET"
                            },
                            "duration": "PT7H20M",
                            "id": "38",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "522.23",
                "base": "274.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "522.23"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "ET"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "522.23",
                        "base": "274.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "37",
                            "cabin": "ECONOMY",
                            "fareBasis": "HXOWKE",
                            "class": "H",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "38",
                            "cabin": "ECONOMY",
                            "fareBasis": "HXOWKE",
                            "class": "H",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "5",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT15H45M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1B",
                                "at": "2023-07-16T22:45:00"
                            },
                            "arrival": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T04:50:00"
                            },
                            "carrierCode": "EK",
                            "number": "722",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT5H5M",
                            "id": "97",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T08:20:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T13:30:00"
                            },
                            "carrierCode": "EK",
                            "number": "73",
                            "aircraft": {
                                "code": "388"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT7H10M",
                            "id": "98",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "526.42",
                "base": "326.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "526.42"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "EK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "526.42",
                        "base": "326.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "97",
                            "cabin": "ECONOMY",
                            "fareBasis": "KLSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "K",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "98",
                            "cabin": "ECONOMY",
                            "fareBasis": "KLSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "K",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "6",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT22H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1B",
                                "at": "2023-07-16T22:45:00"
                            },
                            "arrival": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T04:50:00"
                            },
                            "carrierCode": "EK",
                            "number": "722",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT5H5M",
                            "id": "43",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T14:40:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T20:00:00"
                            },
                            "carrierCode": "EK",
                            "number": "75",
                            "aircraft": {
                                "code": "388"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT7H20M",
                            "id": "44",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "526.42",
                "base": "326.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "526.42"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "EK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "526.42",
                        "base": "326.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "43",
                            "cabin": "ECONOMY",
                            "fareBasis": "KLSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "K",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "44",
                            "cabin": "ECONOMY",
                            "fareBasis": "KLSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "K",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "7",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT35H40M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1B",
                                "at": "2023-07-16T22:45:00"
                            },
                            "arrival": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T04:50:00"
                            },
                            "carrierCode": "EK",
                            "number": "722",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT5H5M",
                            "id": "89",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-18T04:05:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-18T09:25:00"
                            },
                            "carrierCode": "EK",
                            "number": "71",
                            "aircraft": {
                                "code": "388"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT7H20M",
                            "id": "90",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "526.42",
                "base": "326.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "526.42"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "EK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "526.42",
                        "base": "326.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "89",
                            "cabin": "ECONOMY",
                            "fareBasis": "KLSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "K",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "90",
                            "cabin": "ECONOMY",
                            "fareBasis": "KLSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "K",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "8",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT17H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1B",
                                "at": "2023-07-16T16:35:00"
                            },
                            "arrival": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-16T22:40:00"
                            },
                            "carrierCode": "EK",
                            "number": "720",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT5H5M",
                            "id": "113",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T04:05:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T09:25:00"
                            },
                            "carrierCode": "EK",
                            "number": "71",
                            "aircraft": {
                                "code": "388"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT7H20M",
                            "id": "114",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "585.42",
                "base": "385.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "585.42"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "EK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "585.42",
                        "base": "385.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "113",
                            "cabin": "ECONOMY",
                            "fareBasis": "ULSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "U",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "114",
                            "cabin": "ECONOMY",
                            "fareBasis": "ULSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "U",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "9",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT21H55M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1B",
                                "at": "2023-07-16T16:35:00"
                            },
                            "arrival": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-16T22:40:00"
                            },
                            "carrierCode": "EK",
                            "number": "720",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT5H5M",
                            "id": "137",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T08:20:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T13:30:00"
                            },
                            "carrierCode": "EK",
                            "number": "73",
                            "aircraft": {
                                "code": "388"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT7H10M",
                            "id": "138",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "585.42",
                "base": "385.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "585.42"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "EK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "585.42",
                        "base": "385.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "137",
                            "cabin": "ECONOMY",
                            "fareBasis": "ULSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "U",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "138",
                            "cabin": "ECONOMY",
                            "fareBasis": "ULSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "U",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "10",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT28H25M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1B",
                                "at": "2023-07-16T16:35:00"
                            },
                            "arrival": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-16T22:40:00"
                            },
                            "carrierCode": "EK",
                            "number": "720",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT5H5M",
                            "id": "51",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DXB",
                                "terminal": "3",
                                "at": "2023-07-17T14:40:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T20:00:00"
                            },
                            "carrierCode": "EK",
                            "number": "75",
                            "aircraft": {
                                "code": "388"
                            },
                            "operating": {
                                "carrierCode": "EK"
                            },
                            "duration": "PT7H20M",
                            "id": "52",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "585.42",
                "base": "385.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "585.42"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "EK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "585.42",
                        "base": "385.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "51",
                            "cabin": "ECONOMY",
                            "fareBasis": "ULSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "U",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "52",
                            "cabin": "ECONOMY",
                            "fareBasis": "ULSOSKE1",
                            "brandedFare": "ECOFLEX",
                            "class": "U",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "11",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 7,
            "itineraries": [
                {
                    "duration": "PT26H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T05:00:00"
                            },
                            "arrival": {
                                "iataCode": "ADD",
                                "terminal": "2",
                                "at": "2023-07-16T07:15:00"
                            },
                            "carrierCode": "ET",
                            "number": "309",
                            "aircraft": {
                                "code": "7M8"
                            },
                            "operating": {
                                "carrierCode": "ET"
                            },
                            "duration": "PT2H15M",
                            "id": "123",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "ADD",
                                "terminal": "2",
                                "at": "2023-07-17T00:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2E",
                                "at": "2023-07-17T06:50:00"
                            },
                            "carrierCode": "ET",
                            "number": "734",
                            "aircraft": {
                                "code": "350"
                            },
                            "operating": {
                                "carrierCode": "ET"
                            },
                            "duration": "PT7H20M",
                            "id": "124",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "590.23",
                "base": "342.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "590.23"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "ET"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "590.23",
                        "base": "342.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "123",
                            "cabin": "ECONOMY",
                            "fareBasis": "VXOWKE",
                            "class": "V",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "124",
                            "cabin": "ECONOMY",
                            "fareBasis": "VXOWKE",
                            "class": "V",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "12",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT14H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T18:10:00"
                            },
                            "arrival": {
                                "iataCode": "DOH",
                                "at": "2023-07-16T23:25:00"
                            },
                            "carrierCode": "QR",
                            "number": "1336",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT5H15M",
                            "id": "31",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DOH",
                                "at": "2023-07-17T01:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T07:25:00"
                            },
                            "carrierCode": "QR",
                            "number": "41",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT7H",
                            "id": "32",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "595.28",
                "base": "390.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "595.28"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "QR"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "595.28",
                        "base": "390.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "31",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "32",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "13",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT20H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T01:25:00"
                            },
                            "arrival": {
                                "iataCode": "DOH",
                                "at": "2023-07-16T06:50:00"
                            },
                            "carrierCode": "QR",
                            "number": "1342",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT5H25M",
                            "id": "119",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DOH",
                                "at": "2023-07-16T15:05:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-16T21:15:00"
                            },
                            "carrierCode": "QR",
                            "number": "37",
                            "aircraft": {
                                "code": "351"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT7H10M",
                            "id": "120",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "595.28",
                "base": "390.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "595.28"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "QR"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "595.28",
                        "base": "390.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "119",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "120",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "14",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT28H5M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T18:10:00"
                            },
                            "arrival": {
                                "iataCode": "DOH",
                                "at": "2023-07-16T23:25:00"
                            },
                            "carrierCode": "QR",
                            "number": "1336",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT5H15M",
                            "id": "15",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DOH",
                                "at": "2023-07-17T15:05:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T21:15:00"
                            },
                            "carrierCode": "QR",
                            "number": "37",
                            "aircraft": {
                                "code": "351"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT7H10M",
                            "id": "16",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "598.56",
                "base": "390.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "598.56"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "QR"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "598.56",
                        "base": "390.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "15",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "16",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "15",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT31H",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T01:25:00"
                            },
                            "arrival": {
                                "iataCode": "DOH",
                                "at": "2023-07-16T06:50:00"
                            },
                            "carrierCode": "QR",
                            "number": "1342",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT5H25M",
                            "id": "3",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "DOH",
                                "at": "2023-07-17T01:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T07:25:00"
                            },
                            "carrierCode": "QR",
                            "number": "41",
                            "aircraft": {
                                "code": "77W"
                            },
                            "operating": {
                                "carrierCode": "QR"
                            },
                            "duration": "PT7H",
                            "id": "4",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "598.56",
                "base": "390.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "598.56"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "QR"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "598.56",
                        "base": "390.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "3",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "4",
                            "cabin": "ECONOMY",
                            "fareBasis": "NLR1R1RQ",
                            "brandedFare": "ECLASSIC",
                            "class": "N",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "16",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT12H5M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:15:00"
                            },
                            "arrival": {
                                "iataCode": "IST",
                                "at": "2023-07-16T10:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "638",
                            "aircraft": {
                                "code": "332"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT6H25M",
                            "id": "9",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "IST",
                                "at": "2023-07-16T12:35:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-16T15:20:00"
                            },
                            "carrierCode": "TK",
                            "number": "1825",
                            "aircraft": {
                                "code": "32Q"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT3H45M",
                            "id": "10",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "627.68",
                "base": "448.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "627.68"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "TK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "627.68",
                        "base": "448.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "9",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "10",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "17",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT13H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:15:00"
                            },
                            "arrival": {
                                "iataCode": "IST",
                                "at": "2023-07-16T10:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "638",
                            "aircraft": {
                                "code": "332"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT6H25M",
                            "id": "111",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "IST",
                                "at": "2023-07-16T14:20:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-16T17:05:00"
                            },
                            "carrierCode": "TK",
                            "number": "1833",
                            "aircraft": {
                                "code": "32Q"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT3H45M",
                            "id": "112",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "627.68",
                "base": "448.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "627.68"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "TK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "627.68",
                        "base": "448.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "111",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "112",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "18",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT15H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:15:00"
                            },
                            "arrival": {
                                "iataCode": "IST",
                                "at": "2023-07-16T10:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "638",
                            "aircraft": {
                                "code": "332"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT6H25M",
                            "id": "33",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "IST",
                                "at": "2023-07-16T15:50:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-16T18:30:00"
                            },
                            "carrierCode": "TK",
                            "number": "1827",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT3H40M",
                            "id": "34",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "627.68",
                "base": "448.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "627.68"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "TK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "627.68",
                        "base": "448.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "33",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "34",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "19",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT18H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:15:00"
                            },
                            "arrival": {
                                "iataCode": "IST",
                                "at": "2023-07-16T10:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "638",
                            "aircraft": {
                                "code": "332"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT6H25M",
                            "id": "115",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "IST",
                                "at": "2023-07-16T19:20:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-16T22:05:00"
                            },
                            "carrierCode": "TK",
                            "number": "1829",
                            "aircraft": {
                                "code": "32Q"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT3H45M",
                            "id": "116",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "627.68",
                "base": "448.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "627.68"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "TK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "627.68",
                        "base": "448.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "115",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "116",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "20",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT30H25M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:15:00"
                            },
                            "arrival": {
                                "iataCode": "IST",
                                "at": "2023-07-16T10:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "638",
                            "aircraft": {
                                "code": "332"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT6H25M",
                            "id": "53",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "IST",
                                "at": "2023-07-17T07:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T09:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "1821",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT3H40M",
                            "id": "54",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "627.68",
                "base": "448.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "627.68"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "TK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "627.68",
                        "base": "448.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "53",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "54",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "21",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT33H30M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:15:00"
                            },
                            "arrival": {
                                "iataCode": "IST",
                                "at": "2023-07-16T10:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "638",
                            "aircraft": {
                                "code": "332"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT6H25M",
                            "id": "64",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "IST",
                                "at": "2023-07-17T10:05:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T12:45:00"
                            },
                            "carrierCode": "TK",
                            "number": "1823",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT3H40M",
                            "id": "65",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "627.68",
                "base": "448.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "627.68"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "TK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "627.68",
                        "base": "448.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "64",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "65",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "22",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT32H20M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1C",
                                "at": "2023-07-16T04:15:00"
                            },
                            "arrival": {
                                "iataCode": "IST",
                                "at": "2023-07-16T10:40:00"
                            },
                            "carrierCode": "TK",
                            "number": "638",
                            "aircraft": {
                                "code": "332"
                            },
                            "operating": {
                                "carrierCode": "TK"
                            },
                            "duration": "PT6H25M",
                            "id": "49",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "SAW",
                                "at": "2023-07-17T08:55:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T11:35:00"
                            },
                            "carrierCode": "TK",
                            "number": "7764",
                            "aircraft": {
                                "code": "73H"
                            },
                            "duration": "PT3H40M",
                            "id": "50",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "639.18",
                "base": "448.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "639.18"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "TK"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "639.18",
                        "base": "448.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "49",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "50",
                            "cabin": "ECONOMY",
                            "fareBasis": "ELB2XPOW",
                            "brandedFare": "RS",
                            "class": "E",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "23",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT10H55M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "133",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T07:05:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T08:20:00"
                            },
                            "carrierCode": "LH",
                            "number": "1026",
                            "aircraft": {
                                "code": "32A"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "134",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "133",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "134",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "24",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT12H20M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "47",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T08:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2B",
                                "at": "2023-07-17T09:45:00"
                            },
                            "carrierCode": "LH",
                            "number": "1028",
                            "aircraft": {
                                "code": "319"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "48",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "47",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "48",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "25",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT13H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "29",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T09:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2B",
                                "at": "2023-07-17T10:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "1030",
                            "aircraft": {
                                "code": "32N"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "30",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "29",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "30",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "26",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT14H5M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "11",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T09:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T11:30:00"
                            },
                            "carrierCode": "LH",
                            "number": "4736",
                            "aircraft": {
                                "code": "321"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT2H30M",
                            "id": "12",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "11",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "12",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "27",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT16H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "35",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T12:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2B",
                                "at": "2023-07-17T13:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "1034",
                            "aircraft": {
                                "code": "321"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "36",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "35",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "36",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "28",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT18H45M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "99",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T15:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T16:10:00"
                            },
                            "carrierCode": "LH",
                            "number": "4750",
                            "aircraft": {
                                "code": "319"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H10M",
                            "id": "100",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "99",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "100",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "29",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT18H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "117",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T15:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T16:15:00"
                            },
                            "carrierCode": "LH",
                            "number": "4518",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "118",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "117",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "118",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "30",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT20H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "39",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T16:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2B",
                                "at": "2023-07-17T17:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "1040",
                            "aircraft": {
                                "code": "321"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "40",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "39",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "40",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "31",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT20H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "121",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T17:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T18:15:00"
                            },
                            "carrierCode": "LH",
                            "number": "4258",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "122",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "121",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "122",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "32",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT21H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "41",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T17:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2B",
                                "at": "2023-07-17T18:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "1046",
                            "aircraft": {
                                "code": "32Q"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "42",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "726.60",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "726.60",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "726.60",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "41",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "42",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "33",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT22H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "66",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T19:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T20:00:00"
                            },
                            "carrierCode": "LH",
                            "number": "4219",
                            "aircraft": {
                                "code": "388"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H",
                            "id": "67",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "66",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "67",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "34",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT22H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "68",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T18:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T20:00:00"
                            },
                            "carrierCode": "LH",
                            "number": "4338",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT2H",
                            "id": "69",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "68",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "69",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "35",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT22H40M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "87",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T18:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T20:05:00"
                            },
                            "carrierCode": "LH",
                            "number": "4841",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT2H5M",
                            "id": "88",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "87",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "88",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "36",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT22H45M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "101",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T19:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T20:10:00"
                            },
                            "carrierCode": "LH",
                            "number": "4751",
                            "aircraft": {
                                "code": "319"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H10M",
                            "id": "102",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "101",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "102",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "37",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT23H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "70",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T19:45:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T21:00:00"
                            },
                            "carrierCode": "LH",
                            "number": "4243",
                            "aircraft": {
                                "code": "744"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "71",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "70",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "71",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "38",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT23H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "72",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T19:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T21:00:00"
                            },
                            "carrierCode": "LH",
                            "number": "4430",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT2H",
                            "id": "73",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "72",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "73",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "39",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT23H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "74",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T18:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T21:00:00"
                            },
                            "carrierCode": "LH",
                            "number": "4495",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT3H",
                            "id": "75",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "74",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "75",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "40",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT23H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "76",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T20:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T21:00:00"
                            },
                            "carrierCode": "LH",
                            "number": "4640",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H",
                            "id": "77",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "76",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "77",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "41",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT24H5M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "13",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T20:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "1",
                                "at": "2023-07-17T21:30:00"
                            },
                            "carrierCode": "LH",
                            "number": "4844",
                            "aircraft": {
                                "code": "744"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H",
                            "id": "14",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "13",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "14",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "42",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT24H15M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "45",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T20:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2B",
                                "at": "2023-07-17T21:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "1050",
                            "aircraft": {
                                "code": "321"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "46",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "45",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "46",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "43",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT25H30M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "62",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T21:40:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2B",
                                "at": "2023-07-17T22:55:00"
                            },
                            "carrierCode": "LH",
                            "number": "1052",
                            "aircraft": {
                                "code": "321"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H15M",
                            "id": "63",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.33",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.33",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.33",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "62",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "63",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "44",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT8H40M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:50:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2E",
                                "at": "2023-07-17T07:30:00"
                            },
                            "carrierCode": "KQ",
                            "number": "112",
                            "aircraft": {
                                "code": "788"
                            },
                            "operating": {
                                "carrierCode": "KQ"
                            },
                            "duration": "PT8H40M",
                            "id": "84",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "739.36",
                "base": "568.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "739.36"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "KQ"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "739.36",
                        "base": "568.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "84",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "45",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-15",
            "lastTicketingDateTime": "2023-07-15",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT28H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "80",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-18T01:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-18T02:00:00"
                            },
                            "carrierCode": "LH",
                            "number": "4592",
                            "aircraft": {
                                "code": "74H"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT1H",
                            "id": "81",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "745.54",
                "base": "555.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "745.54",
                "additionalServices": [
                    {
                        "amount": "65.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "745.54",
                        "base": "555.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "80",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "81",
                            "cabin": "ECONOMY",
                            "fareBasis": "QNCOWKE",
                            "brandedFare": "ECOSAVERA",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "46",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT11H51M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "125",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T09:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T10:50:00"
                            },
                            "carrierCode": "KL",
                            "number": "2003",
                            "aircraft": {
                                "code": "320"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "126",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "125",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "126",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "47",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT12H56M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "139",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T10:35:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T11:55:00"
                            },
                            "carrierCode": "KL",
                            "number": "2007",
                            "aircraft": {
                                "code": "320"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "140",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "139",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "140",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "48",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT14H41M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "91",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T12:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T13:40:00"
                            },
                            "carrierCode": "KL",
                            "number": "1233",
                            "aircraft": {
                                "code": "73H"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H15M",
                            "id": "92",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "91",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "92",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "49",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT16H26M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "55",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T14:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T15:25:00"
                            },
                            "carrierCode": "KL",
                            "number": "2009",
                            "aircraft": {
                                "code": "319"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H25M",
                            "id": "56",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "55",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "56",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "50",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT16H51M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "129",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T14:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T15:50:00"
                            },
                            "carrierCode": "KL",
                            "number": "2013",
                            "aircraft": {
                                "code": "318"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "130",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "129",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "130",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "51",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT18H46M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "103",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T16:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T17:45:00"
                            },
                            "carrierCode": "KL",
                            "number": "1243",
                            "aircraft": {
                                "code": "73H"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H15M",
                            "id": "104",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "103",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "104",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "52",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT20H6M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "17",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T17:50:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T19:05:00"
                            },
                            "carrierCode": "KL",
                            "number": "1245",
                            "aircraft": {
                                "code": "73W"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H15M",
                            "id": "18",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "17",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "18",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "53",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT21H1M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "5",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T18:40:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T20:00:00"
                            },
                            "carrierCode": "KL",
                            "number": "2017",
                            "aircraft": {
                                "code": "318"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "6",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "5",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "6",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "54",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT23H6M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "21",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T20:35:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T22:05:00"
                            },
                            "carrierCode": "KL",
                            "number": "2023",
                            "aircraft": {
                                "code": "320"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H30M",
                            "id": "22",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "21",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "22",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "55",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT32H56M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "143",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-18T06:35:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-18T07:55:00"
                            },
                            "carrierCode": "KL",
                            "number": "1223",
                            "aircraft": {
                                "code": "73H"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H20M",
                            "id": "144",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "143",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "144",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "56",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT33H11M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "27",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-18T06:50:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-18T08:10:00"
                            },
                            "carrierCode": "KL",
                            "number": "144",
                            "aircraft": {
                                "code": "73J"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H20M",
                            "id": "28",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "27",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "28",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "57",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT33H41M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "KL",
                            "number": "566",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "95",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-18T07:15:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-18T08:40:00"
                            },
                            "carrierCode": "KL",
                            "number": "1227",
                            "aircraft": {
                                "code": "73W"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H25M",
                            "id": "96",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "748.53",
                "base": "553.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "748.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "748.53",
                        "base": "553.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "95",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "96",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "58",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT11H50M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T09:10:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-16T16:40:00"
                            },
                            "carrierCode": "KQ",
                            "number": "116",
                            "aircraft": {
                                "code": "788"
                            },
                            "operating": {
                                "carrierCode": "KQ"
                            },
                            "duration": "PT8H30M",
                            "id": "107",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-16T18:40:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-16T20:00:00"
                            },
                            "carrierCode": "KQ",
                            "number": "3095",
                            "aircraft": {
                                "code": "318"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "108",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "766.45",
                "base": "570.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "766.45"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "KQ"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "766.45",
                        "base": "570.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "107",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "108",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "59",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT25H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T09:10:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-16T16:40:00"
                            },
                            "carrierCode": "KQ",
                            "number": "116",
                            "aircraft": {
                                "code": "788"
                            },
                            "operating": {
                                "carrierCode": "KQ"
                            },
                            "duration": "PT8H30M",
                            "id": "78",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T08:20:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T09:45:00"
                            },
                            "carrierCode": "KQ",
                            "number": "1227",
                            "aircraft": {
                                "code": "737"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H25M",
                            "id": "79",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "766.45",
                "base": "570.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "766.45"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "KQ"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "766.45",
                        "base": "570.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "78",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "79",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "60",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT33H35M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T09:10:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-16T16:40:00"
                            },
                            "carrierCode": "KQ",
                            "number": "116",
                            "aircraft": {
                                "code": "788"
                            },
                            "operating": {
                                "carrierCode": "KQ"
                            },
                            "duration": "PT8H30M",
                            "id": "82",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T16:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T17:45:00"
                            },
                            "carrierCode": "KQ",
                            "number": "1243",
                            "aircraft": {
                                "code": "737"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H15M",
                            "id": "83",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "766.45",
                "base": "570.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "766.45"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "KQ"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "766.45",
                        "base": "570.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "82",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "83",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "61",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT8H30M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2E",
                                "at": "2023-07-17T07:00:00"
                            },
                            "carrierCode": "AF",
                            "number": "813",
                            "aircraft": {
                                "code": "789"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT8H30M",
                            "id": "59",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "774.91",
                "base": "599.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "774.91",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "774.91",
                        "base": "599.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "59",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "62",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT11H51M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "127",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T09:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T10:50:00"
                            },
                            "carrierCode": "AF",
                            "number": "1241",
                            "aircraft": {
                                "code": "320"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "128",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "127",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "128",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "63",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT12H56M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "141",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T10:35:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T11:55:00"
                            },
                            "carrierCode": "AF",
                            "number": "1341",
                            "aircraft": {
                                "code": "320"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "142",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "141",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "142",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "64",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT14H41M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "93",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T12:25:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T13:40:00"
                            },
                            "carrierCode": "AF",
                            "number": "8233",
                            "aircraft": {
                                "code": "73H"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H15M",
                            "id": "94",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "93",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "94",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "65",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT16H26M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "57",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T14:00:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T15:25:00"
                            },
                            "carrierCode": "AF",
                            "number": "1641",
                            "aircraft": {
                                "code": "319"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H25M",
                            "id": "58",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "57",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "58",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "66",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT16H51M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "131",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T14:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T15:50:00"
                            },
                            "carrierCode": "AF",
                            "number": "1741",
                            "aircraft": {
                                "code": "318"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "132",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "131",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "132",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "67",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT18H46M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "105",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T16:30:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T17:45:00"
                            },
                            "carrierCode": "AF",
                            "number": "8239",
                            "aircraft": {
                                "code": "73H"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H15M",
                            "id": "106",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "105",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "106",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "68",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT20H6M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "19",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T17:50:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T19:05:00"
                            },
                            "carrierCode": "AF",
                            "number": "8499",
                            "aircraft": {
                                "code": "73W"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT1H15M",
                            "id": "20",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "19",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "20",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "69",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT21H1M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "7",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T18:40:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T20:00:00"
                            },
                            "carrierCode": "AF",
                            "number": "1141",
                            "aircraft": {
                                "code": "318"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H20M",
                            "id": "8",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "7",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "8",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "70",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-13",
            "lastTicketingDateTime": "2023-07-13",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT23H6M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T23:59:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T07:15:00"
                            },
                            "carrierCode": "AF",
                            "number": "5191",
                            "aircraft": {
                                "code": "781"
                            },
                            "operating": {
                                "carrierCode": "KL"
                            },
                            "duration": "PT8H16M",
                            "id": "23",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-17T20:35:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-17T22:05:00"
                            },
                            "carrierCode": "AF",
                            "number": "1441",
                            "aircraft": {
                                "code": "320"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H30M",
                            "id": "24",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "796.53",
                "base": "601.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "796.53",
                "additionalServices": [
                    {
                        "amount": "70.00",
                        "type": "CHECKED_BAGS"
                    }
                ]
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "AF"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "796.53",
                        "base": "601.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "23",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "24",
                            "cabin": "ECONOMY",
                            "fareBasis": "QL52BARP",
                            "brandedFare": "LIGHTBAG",
                            "class": "L",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "71",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT13H55M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "terminal": "1A",
                                "at": "2023-07-16T09:10:00"
                            },
                            "arrival": {
                                "iataCode": "AMS",
                                "at": "2023-07-16T16:40:00"
                            },
                            "carrierCode": "KQ",
                            "number": "116",
                            "aircraft": {
                                "code": "788"
                            },
                            "operating": {
                                "carrierCode": "KQ"
                            },
                            "duration": "PT8H30M",
                            "id": "135",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "AMS",
                                "at": "2023-07-16T20:35:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2F",
                                "at": "2023-07-16T22:05:00"
                            },
                            "carrierCode": "AF",
                            "number": "1441",
                            "aircraft": {
                                "code": "320"
                            },
                            "operating": {
                                "carrierCode": "AF"
                            },
                            "duration": "PT1H30M",
                            "id": "136",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "822.95",
                "base": "570.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "822.95"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "KQ"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "822.95",
                        "base": "570.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "135",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "136",
                            "cabin": "ECONOMY",
                            "fareBasis": "QLSRWKE",
                            "class": "Q",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "72",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT12H30M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "60",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T08:45:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "at": "2023-07-17T09:55:00"
                            },
                            "carrierCode": "6X",
                            "number": "1100",
                            "aircraft": {
                                "code": "319"
                            },
                            "operating": {
                                "carrierCode": "6X"
                            },
                            "duration": "PT1H10M",
                            "id": "61",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "2764.10",
                "base": "2610.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "2764.10"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "6X"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "2764.10",
                        "base": "2610.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "60",
                            "cabin": "ECONOMY",
                            "fareBasis": "YFF77WW",
                            "brandedFare": "ECOFLEXA",
                            "class": "Y",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        },
                        {
                            "segmentId": "61",
                            "cabin": "ECONOMY",
                            "fareBasis": "YFF77WW",
                            "brandedFare": "ECOFLEXA",
                            "class": "M",
                            "includedCheckedBags": {
                                "quantity": 2
                            }
                        }
                    ]
                }
            ]
        },
        {
            "type": "flight-offer",
            "id": "73",
            "source": "GDS",
            "instantTicketingRequired": false,
            "nonHomogeneous": false,
            "oneWay": false,
            "lastTicketingDate": "2023-07-16",
            "lastTicketingDateTime": "2023-07-16",
            "numberOfBookableSeats": 9,
            "itineraries": [
                {
                    "duration": "PT11H10M",
                    "segments": [
                        {
                            "departure": {
                                "iataCode": "NBO",
                                "at": "2023-07-16T22:25:00"
                            },
                            "arrival": {
                                "iataCode": "FRA",
                                "terminal": "1",
                                "at": "2023-07-17T05:40:00"
                            },
                            "carrierCode": "LH",
                            "number": "591",
                            "aircraft": {
                                "code": "333"
                            },
                            "operating": {
                                "carrierCode": "LH"
                            },
                            "duration": "PT8H15M",
                            "id": "25",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        },
                        {
                            "departure": {
                                "iataCode": "FRA",
                                "terminal": "2",
                                "at": "2023-07-17T07:05:00"
                            },
                            "arrival": {
                                "iataCode": "CDG",
                                "terminal": "2G",
                                "at": "2023-07-17T08:35:00"
                            },
                            "carrierCode": "AF",
                            "number": "1019",
                            "aircraft": {
                                "code": "E70"
                            },
                            "operating": {
                                "carrierCode": "A5"
                            },
                            "duration": "PT1H30M",
                            "id": "26",
                            "numberOfStops": 0,
                            "blacklistedInEU": false
                        }
                    ]
                }
            ],
            "price": {
                "currency": "EUR",
                "total": "4127.57",
                "base": "3894.00",
                "fees": [
                    {
                        "amount": "0.00",
                        "type": "SUPPLIER"
                    },
                    {
                        "amount": "0.00",
                        "type": "TICKETING"
                    }
                ],
                "grandTotal": "4127.57"
            },
            "pricingOptions": {
                "fareType": [
                    "PUBLISHED"
                ],
                "includedCheckedBagsOnly": true
            },
            "validatingAirlineCodes": [
                "LH"
            ],
            "travelerPricings": [
                {
                    "travelerId": "1",
                    "fareOption": "STANDARD",
                    "travelerType": "ADULT",
                    "price": {
                        "currency": "EUR",
                        "total": "4127.57",
                        "base": "3894.00"
                    },
                    "fareDetailsBySegment": [
                        {
                            "segmentId": "25",
                            "cabin": "ECONOMY",
                            "fareBasis": "YFF77WW",
                            "class": "Y",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        },
                        {
                            "segmentId": "26",
                            "cabin": "ECONOMY",
                            "fareBasis": "YS40BENN",
                            "class": "Y",
                            "includedCheckedBags": {
                                "quantity": 1
                            }
                        }
                    ]
                }
            ]
        }
    ],
    "dictionaries": {
        "locations": {
            "ADD": {
                "cityCode": "ADD",
                "countryCode": "ET"
            },
            "FRA": {
                "cityCode": "FRA",
                "countryCode": "DE"
            },
            "CDG": {
                "cityCode": "PAR",
                "countryCode": "FR"
            },
            "AMS": {
                "cityCode": "AMS",
                "countryCode": "NL"
            },
            "SAW": {
                "cityCode": "IST",
                "countryCode": "TR"
            },
            "CAI": {
                "cityCode": "CAI",
                "countryCode": "EG"
            },
            "NBO": {
                "cityCode": "NBO",
                "countryCode": "KE"
            },
            "IST": {
                "cityCode": "IST",
                "countryCode": "TR"
            },
            "DOH": {
                "cityCode": "DOH",
                "countryCode": "QA"
            },
            "DXB": {
                "cityCode": "DXB",
                "countryCode": "AE"
            }
        },
        "aircraft": {
            "7M8": "BOEING 737 MAX 8",
            "32A": "AIRBUS A320 (SHARKLETS)",
            "74H": "BOEING 747-8",
            "350": "AIRBUS INDUSTRIE A350",
            "32N": "AIRBUS A320NEO",
            "351": "AIRBUS A350-1000",
            "332": "AIRBUS A330-200",
            "32Q": "AIRBUS A321NEO",
            "333": "AIRBUS A330-300",
            "318": "AIRBUS A318",
            "319": "AIRBUS A319",
            "737": "BOEING 737 ALL SERIES PASSENGER",
            "738": "BOEING 737-800",
            "E70": "EMBRAER 170",
            "73H": "BOEING 737-800 (WINGLETS)",
            "73J": "BOEING 737-900",
            "781": "BOEING 787-10",
            "320": "AIRBUS A320",
            "321": "AIRBUS A321",
            "388": "AIRBUS A380-800",
            "77W": "BOEING 777-300ER",
            "744": "BOEING 747-400",
            "788": "BOEING 787-8",
            "789": "BOEING 787-9",
            "73W": "BOEING 737-700 (WINGLETS)"
        },
        "currencies": {
            "EUR": "EURO"
        },
        "carriers": {
            "QR": "QATAR AIRWAYS",
            "KL": "KLM ROYAL DUTCH AIRLINES",
            "6X": "AMADEUS SIX",
            "A5": "HOP",
            "AF": "AIR FRANCE",
            "MS": "EGYPTAIR",
            "EK": "EMIRATES",
            "KQ": "KENYA AIRWAYS",
            "TK": "TURKISH AIRLINES",
            "LH": "LUFTHANSA",
            "ET": "ETHIOPIAN AIRLINES"
        }
    }
}*/
