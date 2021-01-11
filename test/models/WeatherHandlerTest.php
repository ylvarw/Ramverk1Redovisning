<?php

namespace Ylvan\Models;

// require 'helpers/IpHandler.php';

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the helprt class IpHandler.
 */
class WeatherHandlerTest extends TestCase
{

    /**
     * Test get weather for lat, long
     */
    public function testGetWeather()
    {
        $weather = new WeatherHandler();
        $lat = '55';
        $lon = '12';
        $res = $weather->getWeather($lat, $lon);
        $this->assertIsArray($res);
    }

    /**
     * Test get weather for lat, long
     */
    public function testGetForecastWeather()
    {
        $weather = new WeatherHandler();
        $lat = '55';
        $lon = '12';
        $res = $weather->getForecastWeather($lat, $lon);
        $this->assertIsArray($res);
    }
   
   
    /**
     * Test get weather for lat, long
     */
    public function testGetHistoryWeather()
    {
        $weather = new WeatherHandler();
        $lat = '55';
        $lon = '12';
        $res = $weather->getHistoryWeather($lat, $lon);
        $this->assertIsArray($res);
    }
   
   
    /**
     * Test get Map for lat, long
     */
    public function testGetWeatherMap()
    {
        $weather = new WeatherHandler();
        $lat = '55';
        $lon = '12';
        $res = $weather->getWeatherMap($lat, $lon);
        $this->assertIsArray($res);
    }
}
