<?php

namespace App\Http\Controllers;

use App\Services\RestClientInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WeatherController extends Controller
{

    private $restClient;

    private const KELVIN = 273.15;
    private const MMHG = 0.750; // millimetre(s) of mercury 1 mm high

    public function __construct(RestClientInterface $restClient)
    {
        /**
         * Dependency Injection of RestClient by pointing to its
         * interface RestClientInterface
         */
        $this->restClient = $restClient;
    }

    public function getWeather($city)
    {
        $weather = $this->restClient->get('https://api.openweathermap.org/data/2.5/weather?q='.$city
                                    . ',ua'
                                .'&appid=89b6cfb60594b134774a7dd015413aff');

        $currentTemp = $weather['main']['temp'] - self::KELVIN;
        $humidity = $weather['main']['humidity'];
        $pressure = $weather['main']['pressure'] * self::MMHG;
        $wind = $weather['wind']['speed'];

        $result = [
            'temperature' => $currentTemp,
            'humidity' => $humidity,
            'pressure' => $pressure,
            'wind_speed' =>$wind
        ];
        return response()->json($result);
    }



    /* example how api works as server

     * private $citiesWeather = [
       'dnipro' => [
            'temp' => 23,
            'humidity' => 56,
            'wind' => 3
       ],
        'kiev' => [
            'temp' => 20,
            'humidity' => 52,
            'wind' => 1
       ]
    ];

    public function getWeather($city)
    {
        if ( ! isset($this->citiesWeather[$city]) ) {
            return response()->json(
                ['error' => [
                    'message' => 'City not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }
        return response()->json($this->citiesWeather[$city]);
    }

    public function saveWeather(Request $request)
    {
        $contentType = $request->header('content-type');
        if($contentType == 'application/json'){
            return response()->json('asdfasdf');
        }elseif ($contentType === 'application/xml') {
            return response('<message>error</message>', 200, ['Content-type' => 'application/xml'] );
        }
        $city = $request->get('city');
        if ( isset($this->citiesWeather[$city]) ) {
            return response()->json(
                ['error' => [
                    'message' => 'City already exist'
                ]], Response::HTTP_CONFLICT
            );
        }
        $data = $request->all();

        return response(null, Response::HTTP_CREATED, [
            'Location' => '/' . $city
        ]);
    }

    public function deleteCity($city)
    {
        if ( ! isset($this->citiesWeather[$city]) ) {
            return response()->json(
                ['error' => [
                    'message' => 'City not found',
                    'error_code' => '100102'
                ]], Response::HTTP_NOT_FOUND
            );
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }*/


}
