<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CurrentCity;
use App\Services\WeatherStackService;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    /**
     *
     * @var WeatherStackService
     */
    protected $weather_service;

    public function __construct(WeatherStackService $weather_service)
    {
        $this->weather_service = $weather_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /** city */
        $city = Str::slug($request->query('query'));
        
        /* current city slug */
        $city_slug = Str::slug($request->query('query'));
        
        /** date time */
        $date_time = date('Y-m-d H:i:s');

        $city_on_cache = Cache::get($city_slug);

        // veridy city on cache and proccess
        if( !$city_on_cache ){

            // get from service
            $weather = $this->weather_service->getData($city);            

            if(isset($weather['success']) && $weather['success'] == false){
                $error = [
                    'success' => $weather['success'],
                    'error' => $weather['error']
                ];

                return response()->json($error, 404);
            }

            // search in database
            $current_city = CurrentCity::where('city', $city_slug)->first();

            // update or save if exist current city
            if($current_city){
                $current_city->last_query = $date_time;
                $current_city->response = json_encode($weather);
                $current_city->save();
            }else{
                // create a new city
                CurrentCity::create([
                    'city' => $city_slug, 
                    'last_query' => $date_time,
                    'response' => json_encode($weather)
                ]);
            }
            
            // save on cache to quick response           
            $data = [
                'city' => $city_slug,
                'date' => $date_time,
                'response' => $weather
            ];

            Cache::put($city_slug, $data, now()->addMinutes(60));

            $response = [
                'success' => 'success',
                'data' => $weather

            ];

            return response()->json($response, 200);

        }else{
            // response from cached data
            $response = [
                'success' => 'success',
                'data' => Cache::get($city_slug)['response']

            ];
            
            return response()->json($response, 200);
        }
    }

}
