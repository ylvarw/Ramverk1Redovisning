<?php

namespace Ylvan\GeoTag;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Ylvan\Ip\IpHandler;

/**
 * Test the helprt class IpHandler.
 */
class GeoTagTest extends TestCase
{


    /**
     * Test get user IP
     */
    public function testGetposition()
    {
        // get testData
        $ipClass = new IpHandler();
        $ip = $ipClass->getUserIp();
        
        $geo = new GeoTag();
        $res = $geo->getPosition($ip);
        $this->assertNotNull($res);
    }


    // /**
    //  * Test get user IP
    //  */
    // public function testGetpositionTypr()
    // {
    //     // get testData
    //     $ipClass = new IpHandler();
    //     $ip = $ipClass->getUserIp();
        
    //     $geo = new GeoTag();
    //     $res = $geo->getPosition($ip);
    //     $this->assertIsArray($res);
    // }


    // /**
    //  * Test get user IP
    //  */
    // public function testGetUserIp()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->ipv4();
    //     $res = $ipClass->getUserIp();
    //     $this->assertIsString($res);
    // }


    // /**
    //  * Test the ipv4 validation method.
    //  */
    // public function testIpv4Invalid()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->ipv4();
    //     $res = $ipClass->ipv4("invalid");
    //     $this->assertContains("Validerar ej", $res);
    // }


    // /**
    //  * Test the ipv4 validation method.
    //  */
    // public function testIpv4Valid()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->ipv4();
    //     $res = $ipClass->ipv4("8.8.8.8");
    //     $this->assertContains("Validerar", $res);
    // }


    // /**
    //  * Test the ipv4 validation method.
    //  */
    // public function testIpv4Type()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->ipv4();
    //     $res = $ipClass->ipv4("8.8.8.8");
    //     $this->assertIsString($res);
    // }
}