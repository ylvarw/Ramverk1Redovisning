<?php

namespace Ylvan\Controller;

// require 'helpers/IpHandler.php';

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the helprt class IpHandler.
 */
class IpHandlerTest extends TestCase
{
    // Create the di container.
    // protected $ipClass;
    // // protected $controller;



    // /**
    //  * Prepare before each test.
    //  */
    // protected function setUp()
    // {
    //     global $ipClass;

    //     // Setup di
    //     // $this->di = new DIFactoryConfig();
    //     // $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

    //     // // Use a different cache dir for unit test
    //     // $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

    //     // // View helpers uses the global $di so it needs its value
    //     // $di = $this->di;

    //     // Setup the controller
    //     $this->ipClass = new IpHandler();
    //     // $this->controller->setDI($this->di);
    //     // $this->controller->initialize();
    // }


    /**
     * Test get user IP
     */
    public function testGetUserIpContent()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv4();
        $res = $ipClass->getUserIp();
        $this->assertNotNull($res);
    }


    /**
     * Test get user IP
     */
    public function testGetUserIp()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv4();
        $res = $ipClass->getUserIp();
        $this->assertIsString($res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Invalid()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv4();
        $res = $ipClass->ipv4("invalid");
        $this->assertContains("Validerar ej", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Valid()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv4();
        $res = $ipClass->ipv4("8.8.8.8");
        $this->assertContains("Validerar", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Type()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv4();
        $res = $ipClass->ipv4("8.8.8.8");
        $this->assertIsString($res);
    }


    /**
     * Test the ipv6 validation method.
     */
    public function testIpv6Invalid()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv6();
        $res = $ipClass->ipv6("invalid");
        $this->assertContains("Validerar ej", $res);
    }



    /**
     * Test the ipv6 validation method.
     */
    public function testIpv6Valid()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv6();
        $res = $ipClass->ipv6("2001:4860:4860::8888");
        $this->assertContains("Validerar", $res);
    }


    /**
     * Test the ipv6 validation method.
     */
    public function testIpv6Type()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv6();
        $res = $ipClass->ipv6("2001:4860:4860::8888");
        $this->assertIsString($res);
    }


    /**
     * Test the domain name checker method.
     */
    public function testDomainNameInvalid()
    {
        $ipClass = new IpHandler();
        // $ipClass->domainName();
        $res = $ipClass->domainName("invalid");
        $this->assertContains("ip ej validerad", $res);
    }


    /**
     * Test the domain name checker method.
     */
    public function testDomainNameValid()
    {
        $ipClass = new IpHandler();
        // $ipClass->domainName();
        $res = $ipClass->domainName("8.8.8.8");
        $this->assertContains("dns.google", $res);
    }


    /**
     * Test the domain name checker method.
     */
    public function testDomainNameType()
    {
        $ipClass = new IpHandler();
        // $ipClass->domainName();
        $res = $ipClass->domainName("8.8.8.8");
        $this->assertIsString($res);
    }

}