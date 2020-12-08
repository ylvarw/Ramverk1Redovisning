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
        $ip = new IpHandler();
        $geo = new IpPosition();
        $weather = new WeatherHandler();

        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $SearchIP = $request->getPOST("SearchIP", null);
        $useip = $request->getPOST("ip", null);
        $userIp = $ip->getUserIp();

        // $searchCity = $request->getPOST("searchCity", null);
        // $city = $request->getPOST("city", null);
        // $userIpPosition = $geo->getPosition($userIp);
        // $placeholderCity = $userIpPosition['city'];

        // if ($searchCity) {
        //     $latitude = null;
        //     $longitude = null;

        //     $weatherData = $weather->getWeather($city, $latitude, $longitude);
        //     $selectedWeather = $weatherData['weather'];
        //     $selectedtemp = $weatherData['main'];
        //     $selectedtwind = $weatherData['wind'];
        // }

        if ($SearchIP) {
            $city = null;

            $ipPosition = $geo->getPosition($useip);
            $latitude = $ipPosition['latitude'];
            $longitude = $ipPosition['longitude'];
            $city = $ipPosition['city'];
            $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;
            
            // $weatherdata = $weather->getWeather($city, $latitude, $longitude);
            if ($ip->ipIsValid($ip)) {
                try {
                    $weatherdata = $weather->getWeather($city, $latitude, $longitude);
                    $selectedWeather = $weatherdata['weather'];
                    $selectedtemp = $weatherdata['main'];
                    $selectedtwind = $weatherdata['wind'];
                } catch (\Throwable $th){
                    $NoData = "No weather data, could not connect to api";
                }
            } else {
                $NoData = "Could not find weather data, not a valid IP";
            }
            // try {
            //     $weatherdata = $weather->getWeather($city, $latitude, $longitude);
            //     $selectedWeather = $weatherdata['weather'];
            //     $selectedtemp = $weatherdata['main'];
            //     $selectedtwind = $weatherdata['wind'];
            // } catch (\Throwable $th){
            //     $NoData = "could not find weather data";
            // }
            // $selectedWeather = $weatherdata['weather'];
            // $selectedtemp = $weatherdata['main'];
            // $selectedtwind = $weatherdata['wind'];
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
            "selectedWeather" => $selectedWeather ?? null,
            "selectedtemp" => $selectedtemp ?? null,
            "selectedtwind" => $selectedtwind ?? null,
            "weatherdata" => $weatherdata ?? null,
            "NoData" => $NoData ?? null,
            "weatherHistorydata" => $weatherdata ?? null
        ]);

        $title = "Sök väder";
        return $page->render([
            "title" => $title,
        ]);
    }

}