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
     * weather data
     */
    public function getWeather($city, $lat, $long) : array
    {
        // return $this->checkhistoryParams($city, $lat, $long);
        $querrieformat = $this->checkParams($city, $lat, $long);
        return $this->getResponse($querrieformat);
    }
    
    // /**
    //  * get historicak data for one month back
    //  */
    // public function getHistoryWeather($city, $lat, $long) : array
    // {

    //     $querrieformat = $this->checkParams($city, $lat, $long);
    //     return $this->getHistoricalResponse($querrieformat);
    // }


    /**
     * get args, return correct format of api querrie
     */
    private function checkParams($city, $lat, $long) : string
    {
        if ($city != null) {
            $searchParam = '?q=' . $city;
            return $searchParam;
        }
        else {
            $searchParam = '?lat=' . $lat . '&lon=' . $long;
            return $searchParam;
        }
    }




    /**
     * get weather data in chosen position from API
     */
    private function getResponse($searchParam) : array
    {
        $access_key = '31e4a45c184fb9ee516a7e276edafb79';
        $url = 'http://api.openweathermap.org/data/2.5/weather';
        
        try {
            $response = file_get_contents($url . $searchParam . '&appid=' . $access_key);

            $api_result = json_decode($response, true);

            return $api_result;
        } catch (\Throwable $th) {
            return "could not fetch data";
        }
        // $access_key = '31e4a45c184fb9ee516a7e276edafb79';
        // $url = 'http://api.openweathermap.org/data/2.5/weather';
        // $response = file_get_contents($url . $searchParam . '&appid=' . $access_key);

        // $api_result = json_decode($response, true);

        // return $api_result;
    }



    /**
     * get weather for one month back
     */
    // private function getHistoricalResponse($searchParam) : array
    // {
    //     // coordinates search:
    //     // http://history.openweathermap.org/data/2.5/history/city?lat=41.85&lon=-87.65&appid={API key}History Bulk
    //     // city name search:
    //     // http://history.openweathermap.org/data/2.5/history/city?id=2885679&type=hour&appid={API key}
    //     // http://history.openweathermap.org/data/2.5/history/city?q={city ID},{country code}&type=hour&start={start}&end={end}&appid={API key}
        
    //     $access_key = '31e4a45c184fb9ee516a7e276edafb79';
    //     $url = 'http://history.openweathermap.org/data/2.5/history/';
    //     $response = file_get_contents($url . $searchParam . '&type=day' . '&appid=' . $access_key);

    //     $api_result = json_decode($response, true);

    //     return $api_result;
    // }

    // private function getHistoricalResponse(array $searchParam) : array
    // {
    //     $url = "https://rem.dbwebb.se/api/users";

    //     $options = [
    //         CURLOPT_RETURNTRANSFER => true,
    //     ];

    //     // Add all curl handlers and remember them
    //     // Initiate the multi curl handler
    //     $mh = curl_multi_init();
    //     $chAll = [];
    //     foreach ($userIds as $id) {
    //         $ch = curl_init("$url/$id");
    //         curl_setopt_array($ch, $options);
    //         curl_multi_add_handle($mh, $ch);
    //         $chAll[] = $ch;
    //     }

    //     // Execute all queries simultaneously,
    //     // and continue when all are complete
    //     $running = null;
    //     do {
    //         curl_multi_exec($mh, $running);
    //     } while ($running);

    //     // Close the handles
    //     foreach ($chAll as $ch) {
    //         curl_multi_remove_handle($mh, $ch);
    //     }
    //     curl_multi_close($mh);

    //     // All of our requests are done, we can now access the results
    //     $response = [];
    //     foreach ($chAll as $ch) {
    //         $data = curl_multi_getcontent($ch);
    //         $response[] = json_decode($data, true);
    //     }

    //     return $response;
    // }
}