<?php

namespace Ylvan\Controller;
// namespace Ylvan\Model;
// namespace Anax\Controller;


/**
 * A class to handle IP
 */
class WeatherHandler
{
    /**
     * get pressent weather data
     */
    public function getWeather($lat, $long) : array
    {
        // return $this->checkhistoryParams($city, $lat, $long);
        // $querrieformat = $this->checkParams($city, $lat, $long);
        $searchParam = '?lat=' . $lat . '&lon=' . $long;
        return $this->getResponse($searchParam);
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


    // /**
    //  * get args, return correct format of api querrie
    //  */
    // private function checkParams($city, $lat, $long) : string
    // {
    //     if ($city != null) {
    //         $searchParam = '?q=' . $city;
    //         return $searchParam;
    //     }
    //     else {
    //         $searchParam = '?lat=' . $lat . '&lon=' . $long;
    //         return $searchParam;
    //     }
    // }



    /**
     * get weather data in chosen position from API
     */
    private function getResponse($searchParam) : array
    {
        $access_key = '31e4a45c184fb9ee516a7e276edafb79';
        $url = 'http://api.openweathermap.org/data/2.5/weather';
        
        try {
            $response = file_get_contents($url . $searchParam . '&appid=' . $access_key . '&units=metric');

            $api_result = json_decode($response, true);

            return $api_result;
        } catch (\Throwable $th) {
            return ["could connect to openweathermap"];
        }

    }



    /**
     * get weather for one month back
     */
    private function getForecastResponse($lat, $long) : array
    {
        // api.openweathermap.org/data/2.5/forecast/daily?lat={lat}&lon={lon}&cnt={cnt}&appid={API key}        // city name search:
        $numberOfDays = 5;
        $access_key = '31e4a45c184fb9ee516a7e276edafb79';
        $url = 'api.openweathermap.org/data/2.5/forecast/daily';

        try {
            // $response = callAPI('GET', 'https://api.example.com/get_url/'.$user['User']['customer_id'], false);
            // $response = file_get_contents($url . '?lat=' . $lat . '&lon=' . $long . '&cnt=' . $numberOfDays . '&appid=' . $access_key);
            // $api_result = json_decode($response, true);
            // Initialize CURL:
            $ch = curl_init($url . '?lat=' . $lat . '&lon=' . $long . '&cnt=5' . '&appid=' . $access_key);
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


    private function getHistoricalResponse($lat, $long) : array
    {
        $access_key = '31e4a45c184fb9ee516a7e276edafb79';
        $maptype = 'TA2';
        $zoom = '1';
        // $url = 'http://api.openweathermap.org/data/2.5/aggregated/month';
        // $url = 'http://maps.openweathermap.org/maps/2.0/weather/{op}/{z}/{x}/{y}&appid={API key}';
        $url = 'http://api.openweathermap.org/data/2.5/onecall/timemachine';
        $url = 'http://maps.openweathermap.org/maps/2.0/weather/';
        // $url = 'http://history.openweathermap.org/data/2.5/history/city';
        // '?lat={lat}&lon={lon}&type=hour&start={start}&end={end}&appid={API key}';
        // $url = 'http://history.openweathermap.org/data/2.5/history/city?lat={lat}&lon={lon}&type=hour&start={start}&end={end}&appid={API key}';
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        $days = [];

        $start = mktime(strtotime("Today"));
        $end = date_sub($start, date_interval_create_from_date_string("5 days"));;
        // $end = time() - (5);
        // $start = date("Y/m/d");
        // $start = mktime(month, day, year);
        // $start = date("F d, Y h:i:s A", $timestamp);
        // $start = strtotime("Today");
        // $end = strtotime("-5 days", $start);
        
        // $days[] = $start;

        while ($start > $end) {
            // try {
            //     $response = file_get_contents($url . '?lat=' . $lat . '&lon=' . $long . '&type=day' . '&date=' . $start . '&appid=' . $access_key . '&units=metric');

            //     $api_result = json_decode($response, true);

            //     return $api_result;
            // } catch (\Throwable $th) {
            //     return "could not fetch data";
            // }
            $start = date_sub($start, date_interval_create_from_date_string("1 day"));
            // $start = strtotime("-1 day", $start);
            $days[] = $start;
        }


        // // Add all curl handlers and remember them
        // // Initiate the multi curl handler
        $mh = curl_multi_init();
        $chAll = [];
        foreach ($days as $date) {
            // $ch = curl_init("$url . $maptype . '/' . $zoom . '/' . $lat . '/' . $long . '&type=day' . '&dt=' . $date . '&appid=' . $access_key . '&units=metric'");
            $ch = curl_init("$url . '?lat=' . $lat . '&lon=' . $long . '&dt=' . $date . '&appid=' . $access_key . '&units=metric'");
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

        // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }

        return $response;
    }
}