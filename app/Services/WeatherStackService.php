<?php

namespace App\Services;

use App\Http\Helpers\ParseHelper;
use GuzzleHttp\Client as GuzzleClient;

class WeatherStackService
{
    /**
     * @var
     */
    private $weather_stack_api;
    
    /**
     * @var
     */
    private $weather_stack_token;

    /**
     * @var GuzzleClient
     */
    private $client;


    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
        $this->weather_stack_api = env('WEATHER_STACK_API');
        $this->weather_stack_token = env('WEATHER_STACK_TOKEN');

    }

    /**
     * @return array
     */
    public function getData(string $city)
    {
        $url = $this->weather_stack_api . '?access_key=' . $this->weather_stack_token . '&query=' . $city;
        
        $request = $this->client->request('GET', $url);
        
        $response = json_decode($request->getBody()->getContents(), true);
        // $response = $request->getBody()->getContents();

        return $response;
    }


}
