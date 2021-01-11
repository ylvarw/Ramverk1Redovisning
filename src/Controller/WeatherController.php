<?php

namespace Ylvan\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller to show weather by IP position
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction() : object
    {
        // get handler classes from Di
        $ipNumber = $this->di->get("ipHandler");
        $geo = $this->di->get("ipPosition");
        $weather = $this->di->get("weatherHandler");
        $page = $this->di->get("page");
        $request = $this->di->get("request");

        $searchIP = $request->getPOST("SearchIP", null);
        $searchHistoryIP = $request->getPOST("SearchHistoryIP", null);
        $forecast = $request->getPOST("forecast", null);
        $useip = $request->getPOST("ip", null);
       
        // users ip information
        $userIp = $ipNumber->getUserIp();
        $contentText = "Välj Ip och väder att visa";
        $userposition = $geo->getPosition($userIp);
        $placeholderCity = $userposition['city'];

        if ($searchIP || $forecast || $searchHistoryIP) {
            if ($ipNumber->ipIsValid($useip)) {
                $ipPosition = $geo->getPosition($useip);
                $latitude = $ipPosition['latitude'];
                $longitude = $ipPosition['longitude'];
                $city = $ipPosition['city'];
                $coordinates = 'Latitude: '.$latitude . ' ' . 'Longitude: ' . $longitude;

                if ($searchIP) {     
                    $contentText = "Dagens väder";
                    $weatherdata = $weather->getWeather($latitude, $longitude);
                    $selectedWeather = $weatherdata['weather'];
                    $descriptionWeather = $weatherdata['weather'][0]['description'];
                    $selectedtemp = $weatherdata['main'];
                    $selectedtwind = $weatherdata['wind'];
                    $locationMap = $weather->getWeatherMap($latitude, $longitude);
                }

                if ($forecast) {
                    $contentText = "kommande 7 dagarnas väder";
                    $forecastData = $weather->getForecastWeather($latitude, $longitude);
                    $locationMap = $weather->getWeatherMap($latitude, $longitude);
                }

                if ($searchHistoryIP) {
                    $contentText = "Senaste dagarnas väder";
                    $weatherHistorydata = $weather->getHistoryWeather($latitude, $longitude);
                    $locationMap = $weather->getWeatherMap($latitude, $longitude);
                }
            } else {
                $noData = "Could not find weather data, not a valid IP";
            }
        }

        $page->add("weather/weather", [
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
