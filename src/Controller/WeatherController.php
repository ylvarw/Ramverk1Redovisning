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
        $map = new Map();

        // get ipHandler from Di
        $ip = $this->di->get("ipHandler");
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $SearchIP = $request->getPOST("SearchIP", null);
        $SearchHistoryIP = $request->getPOST("SearchHistoryIP", null);
        $forecast = $request->getPOST("forecast", null);

        $useip = $request->getPOST("ip", null);
        $userIp = $ip->getUserIp();

        $contentText = "Välj Ip och väder att visa";


        if ($SearchIP) {     
            $contentText = "Dagens väder";
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
                $locationMap = $map->getMap($latitude, $longitude);
            } else {
                $noData = "Could not find weather data, not a valid IP";
            }
        }


        if ($forecast) {
            $contentText = "kommande 7 dagarnas väder";

            //make check for valid Ip
            if ($ip->ipIsValid($useip)) {
                $ipPosition = $geo->getPosition($useip);
                $latitude = $ipPosition['latitude'];
                $longitude = $ipPosition['longitude'];
                $city = $ipPosition['city'];
                $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
                
                $forecastData = $weather->getForecastWeather($latitude, $longitude);
                $locationMap = $map->getMap($latitude, $longitude);
            } else {
                $noData = "Could not find weather data, not a valid IP";
            }
        }


        if ($SearchHistoryIP) {
            $contentText = "Senaste dagarnas väder";

            if ($ip->ipIsValid($useip)) {
                $ipPosition = $geo->getPosition($useip);
                $latitude = $ipPosition['latitude'];
                $longitude = $ipPosition['longitude'];
                $city = $ipPosition['city'];
                $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
                
                $weatherHistorydata = $weather->getHistoryWeather($latitude, $longitude);
                $locationMap = $map->getMap($latitude, $longitude);
            } else {
                $noData = "Could not find weather data, not a valid IP";
            }
        }


        $page->add("weather/weather", [
            // "content" => "kolla väder med ip-address eller ortnamn",
            "content" => $contentText,
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
            "forecastData" => $forecastData ?? null,
            "map" => $locationMap ?? null
        ]);

        $title = "Sök väder";
        return $page->render([
            "title" => $title,
        ]);
    }

}