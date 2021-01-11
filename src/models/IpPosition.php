<?php

namespace Ylvan\Models;

/**
 * A class to handle requests for geolocation
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
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
        return $result;
    }



    /**
     * make API call, return result for IP
     */
    private function connectApi($ip)
    {
        $accessKey = '5d3399b227dff07cac9f896eaa07ea71';
        $url = 'http://api.ipstack.com/';
        $response = file_get_contents($url . $ip . '?access_key=' . $accessKey . '&format=1');
        $apiResult = json_decode($response, true);

        return $apiResult;
    }
}
