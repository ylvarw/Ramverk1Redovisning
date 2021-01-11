<?php

namespace Ylvan\Models;

/**
 * A class to handle IP
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class WeatherHandler
{
    private $accessKey='31e4a45c184fb9ee516a7e276edafb79';


    /**
     * get pressent weather data
     */
    public function getWeather($lat, $long) : array
    {
        // $searchParam = '?lat=' . $lat . '&lon=' . $long;
        return $this->getResponse($lat, $long);
    }
    
    /**
     * get historical data for one month back
     */
    public function getHistoryWeather($lat, $long) : array
    {
        return $this->getHistoricalResponse($lat, $long);
    }

    
    /**
     * get forecast data for 5 days
     */
    public function getForecastWeather($lat, $long) : array
    {
        return $this->getForecastResponse($lat, $long);
    }


    /**
     * get weather data in chosen position from API
     */
    private function getResponse($lat, $long) : array
    {
        // $accessKey = '31e4a45c184fb9ee516a7e276edafb79';
        $key = $this->accessKey;
        $url = 'http://api.openweathermap.org/data/2.5/weather';
        
        try {
            $response = file_get_contents($url . '?lat=' . $lat . '&lon=' . $long . '&appid=' . $key . '&units=metric');

            $apiResult = json_decode($response, true);

            return $apiResult;
        } catch (\Throwable $th) {
            return ["could not connect to openweathermap"];
        }
    }

    /**
     * get weather forecast for one week
     */
    private function getForecastResponse($lat, $long) : array
    {
        //openweathermap documentation
        // https://openweathermap.org/api/one-call-api

        $url = 'https://api.openweathermap.org/data/2.5/onecall';
        // exclude params: current,minutely,hourly,daily,alerts
        $key = $this->accessKey;

        try {
            // Initialize CURL:
            $ch = curl_init($url . '?lat=' . $lat . '&lon=' . $long . '&exclude=current,minutely,hourly,alerts' . '&appid=' . $key . '&units=metric');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $apiResult = json_decode($json, true);

            return $apiResult;
        } catch (\Throwable $th) {
            return ["could not connect to openweathermap"];
        }
    }

    /**
     * get weather data of the last 5 days with multi-curl
     */
    private function getHistoricalResponse($lat, $long) : array
    {
        //openweathermap documentation
        // https://openweathermap.org/api/one-call-api#history
        $key = $this->accessKey;
        $url = 'http://api.openweathermap.org/data/2.5/onecall/timemachine';
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        $currentTime = time();
        $day1 = ($currentTime - ((24*60*60)*1));
        $day2 = ($currentTime - ((24*60*60)*2));
        $day3 = ($currentTime - ((24*60*60)*3));
        $day4 = ($currentTime - ((24*60*60)*4));
        $day5 = ($currentTime - ((24*60*60)*5));
        $timeList = [$currentTime, $day1, $day2, $day3, $day4, $day5];


        // Add all curl handlers and remember them
        // Initiate the multi curl handler
        $mh = curl_multi_init();
        $chAll = [];
        try {
            foreach ($timeList as $time) {
                $ch = curl_init($url . '?lat=' . $lat . '&lon=' . $long . '&dt=' . $time . '&appid=' . $key . '&units=metric');
                curl_setopt_array($ch, $options);
                curl_multi_add_handle($mh, $ch);
                $chAll[] = $ch;
            }

            // Execute all queries simultaneously,
            // and continue when all are complete
            $running = null;
            do {
                curl_multi_exec($mh, $running);
            } while ($running);

            // Close the handles
            foreach ($chAll as $ch) {
                curl_multi_remove_handle($mh, $ch);
            }
            curl_multi_close($mh);

            // All of our requests are done, access the results
            $response = [];
            foreach ($chAll as $ch) {
                $data = curl_multi_getcontent($ch);
                $response[] = json_decode($data, true);
            }

            return $response;
        } catch (\Throwable $th) {
            return ["could not connect to openweathermap"];
        }
    }


     
    /**
     * get pressent weather map
     */
    public function getWeatherMap($lat, $long) : array
    {
        // $searchParam = '?lat=' . $lat . '&lon=' . $long;
        return $this->requestWeatheMap($lat, $long);
    }


    
    /**
     * get weather forecast for one week
     */
    private function requestWeatheMap($lat, $long) : array
    {
        //openweathermap documentation
        // https://openweathermap.org/api/weathermaps

        $url = 'https://tile.openweathermap.org/map/';
        $key = $this->accessKey;

        // {layer}/{z}/{x}/{y}.png?appid={API key}
        $params = 'clouds_new/3/'.$lat.'/'.$long.'.png?';

        try {
            // Initialize CURL:
            $ch = curl_init($url . $params . '&appid=' . $key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $apiResult = json_decode($json, true);

            return $apiResult;
        } catch (\Throwable $th) {
            return ["could not connect to openweathermap"];
        }
    }
}
