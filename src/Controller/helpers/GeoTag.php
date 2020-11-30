<?php

namespace Ylvan\Controller;

// namespace Anax\Controller;
// include './vars.php';
// require 'vars.php';


/**
 * A class to handle requests for geolocation
 */
class IpPosition
{

    /**
     * recieve the IP and return coordinates
     */
    public function getPosition($ip)
    {
        // connect to api and get response
        $result = $this->connectApi($ip);
        // position request
        // $coordinates = $result["latitude", "longit"]
        // $latitude = $result['latitude'];
        // $longitude = $result['longitude'];
        // $coordinates = 'latitude: '.$latitude . ' ' . 'longitude: ' . $longitude;
        // return $coordinates;
        return $result;
    }



    /**
     * make API call, return result for IP
     */
    private function connectApi($ip)
    {
        // require 'vars.php';
        // require './vars.php';
        // set IP address and API access key 
        // $ip = '134.201.250.155';
        // $access_key = 'YOUR_ACCESS_KEY';


        // http://api.ipstack.com/134.201.250.155?access_key=5d3399b227dff07cac9f896eaa07ea71&format=1
        
        
        // // Initialize CURL:
        // $ch = curl_init('https://api.ipstack.com/'.$ip.'?access_key='.$access_key.'&fields=location');
        // // $ch = curl_init('https://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // // Store the data:
        // $json = curl_exec($ch);
        // curl_close($ch);

        // Decode JSON response:
        // $api_result = json_decode($json, true);

        $access_key = '5d3399b227dff07cac9f896eaa07ea71';
        $url = 'http://api.ipstack.com/';
        $response = file_get_contents($url . $ip . '?access_key=' . $access_key . '&format=1');
        $api_result = json_decode($response, true);

        // return $api_result['city']['latitude']['longitude'];
        // $latitude = $api_result['latitude']
        // $longitude = $api_result['longitude']
        // return $api_result['city'];
        return $api_result;

        // return $coordinates;
    }
}
