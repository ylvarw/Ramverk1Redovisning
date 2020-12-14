<?php

namespace Ylvan\Controller;



/**
 * A class to handle IP
 */
class WeatherHandler
{
    private $access_key='31e4a45c184fb9ee516a7e276edafb79';


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
        // $access_key = '31e4a45c184fb9ee516a7e276edafb79';
        $key = $this->access_key;
        $url = 'http://api.openweathermap.org/data/2.5/weather';
        
        try {
            $response = file_get_contents($url . '?lat=' . $lat . '&lon=' . $long . '&appid=' . $key . '&units=metric');

            $api_result = json_decode($response, true);

            return $api_result;
        } catch (\Throwable $th) {
            return ["could connect to openweathermap"];
        }

    }

    /**
     * get weather forecast for one week
     */
    private function getForecastResponse($lat, $long) : array
    {
        $url = 'https://api.openweathermap.org/data/2.5/onecall';
        // exclude params: current,minutely,hourly,daily,alerts
        $key = $this->access_key;

        try {
            // Initialize CURL:
            $ch = curl_init($url . '?lat=' . $lat . '&lon=' . $long . '&exclude=current,minutely,hourly,alerts' . '&appid=' . $key . '&units=metric');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $api_result = json_decode($json, true);

            return $api_result;
        } catch (\Throwable $th) {
            return ["could connect to openweathermap"];
        }
    }

    /**
     * get weather data of the last 5 days with multi-curl
     */
    private function getHistoricalResponse($lat, $long) : array
    {
        $key = $this->access_key;
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
    }
}