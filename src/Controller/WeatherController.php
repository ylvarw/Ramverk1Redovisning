<?php

namespace Ylvan\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
// use Ylvan\Model;


/**
 * A controller show position of IP
 */
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction() : object
    {
        $geo = new IpPosition();
        $weather = new WeatherHandler();

        // get ipHandler from Di
        $ip = $this->di->get("ipHandler");
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $SearchIP = $request->getPOST("SearchIP", null);
        $SearchHistoryIP = $request->getPOST("SearchHistoryIP", null);
        $forecast = $request->getPOST("forecast", null);

        $useip = $request->getPOST("ip", null);
        $userIp = $ip->getUserIp();


        if ($SearchIP) {            
            // $weatherdata = $weather->getWeather($city, $latitude, $longitude);
            if ($ip->ipIsValid($useip)) {
                $ipPosition = $geo->getPosition($useip);
                $latitude = $ipPosition['latitude'];
                $longitude = $ipPosition['longitude'];
                $city = $ipPosition['city'];
                $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
                
                $weatherdata = $weather->getWeather($latitude, $longitude);
                $selectedWeather = $weatherdata['weather'];
                $descriptionWeather = $weatherdata['weather'][0]['description'];
                $selectedtemp = $weatherdata['main'];
                $selectedtwind = $weatherdata['wind'];
            } else {
                $noData = "Could not find weather data, not a valid IP";
            }
        }


        if ($forecast) {
            //make check for valid Ip
            if ($ip->ipIsValid($useip)) {
                $ipPosition = $geo->getPosition($useip);
                $latitude = $ipPosition['latitude'];
                $longitude = $ipPosition['longitude'];
                $city = $ipPosition['city'];
                $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
                
                $forecastData = $weather->getForecastWeather($latitude, $longitude);
            } else {
                $noData = "Could not find weather data, not a valid IP";
            }
        }


        if ($SearchHistoryIP) {

            if ($ip->ipIsValid($useip)) {
                $ipPosition = $geo->getPosition($useip);
                $latitude = $ipPosition['latitude'];
                $longitude = $ipPosition['longitude'];
                $city = $ipPosition['city'];
                $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
                
                $weatherHistorydata = $weather->getHistoryWeather($latitude, $longitude);
                // $weatherHistorydata = json_encode($weatherData, JSON_PRETTY_PRINT);
                // $weatherHistorydata = json_encode($weatherData);
            } else {
                $noData = "Could not find weather data, not a valid IP";
            }
        }


        $page->add("weather/weather", [
            // "content" => "kolla väder med ip-address eller ortnamn",
            "content" => "Kolla väder med ip-address",
            "ipPosition" => $coordinates ?? null,
            "latitude" => $latitude ?? null,
            "longitude" => $longitude ?? null,
            "city" => $city ?? null,
            "coordinates" => $coordinates ?? null,
            "placeholderCity" => $placeholderCity ?? null,
            "ipAddress" => $useip ?? $userIp,
            "descriptionWeather" => $descriptionWeather ?? null,
            "selectedWeather" => $selectedWeather ?? null,
            "selectedtemp" => $selectedtemp ?? null,
            "selectedtwind" => $selectedtwind ?? null,
            "weatherdata" => $weatherdata ?? null,
            "noData" => $noData ?? null,
            "weatherHistorydata" => $weatherHistorydata ?? null,
            "forecastData" => $forecastData ?? null
        ]);

        $title = "Sök väder";
        return $page->render([
            "title" => $title,
        ]);
    }

}