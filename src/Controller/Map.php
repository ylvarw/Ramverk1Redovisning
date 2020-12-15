<?php
namespace Ylvan\Controller;

/**
 * a Clas to return a map woth positions based on input coordinates
 */
class Map
{
    private $access_key='31e4a45c184fb9ee516a7e276edafb79';


    // public function getMap($locationName)
    // {
    //     //nomatim owm documentation
    //     // https://nominatim.org/release-docs/develop/api/Overview/
    //     $baseUrl = 'https://nominatim.openstreetmap.org/search?';
    //     // $name = urlencode( 'Addison, TX, US' );
    //     // $data = file_get_contents($baseUrl . '&q=' . $locationName);
    //     // $json = json_decode( $data );
    //     $params = 'format=json' . '&limit=1' . '&q=' . strtolower($locationName);

    //     try {
    //         $data = file_get_contents($baseUrl . $params);
    //         $json = json_decode($data);
    //         return $json;
    //         // $response = file_get_contents($url . '?lat=' . $lat . '&lon=' . $long . '&appid=' . $key . '&units=metric');

    //         // $api_result = json_decode($response, true);

    //         // return $api_result;
    //     } catch (\Throwable $th) {
    //         return ["could not connect to openstreetmap"];
    //     }
    // }
    

    
    /**
     * get pressent weather map
     */
    public function getMap($lat, $long) : array
    {
        // $searchParam = '?lat=' . $lat . '&lon=' . $long;
        return $this->requesrWeatheMap($lat, $long);
    }


    
    /**
     * get weather forecast for one week
     */
    private function requesrWeatheMap($lat, $long) : array
    {
        //openweathermap documentation
        // https://openweathermap.org/api/weathermaps

        $url = 'https://tile.openweathermap.org/map/';
        $key = $this->access_key;

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
            $api_result = json_decode($json, true);

            return $api_result;
        } catch (\Throwable $th) {
            return ["could not connect to openweathermap"];
        }
    }


    // $baseUrl = 'http://nominatim.openstreetmap.org/search?format=json&limit=1';
    // $name = urlencode( 'Addison, TX, US' );
    // $data = file_get_contents( "{$baseUrl}&q={$name}" );
    // $json = json_decode( $data );

    // var_dump( $json[0] );


}
