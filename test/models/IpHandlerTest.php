<?php

namespace Ylvan\Models;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the helprt class IpHandler.
 */
class IpHandlerTest extends TestCase
{

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
    // public function testGetUserIp()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->ipv4();
    //     $res = $ipClass->getUserIp();
    //     $this->assertIsString($res);
    // }


    /**
     * Test the general validation method using ipv4.
     */
    public function testIpIsvalidIpv4()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv4();
        $res = $ipClass->ipIsValid("8.8.8.8");
        $this->assertContains("true", $res);
    }


    /**
     * Test the general validation method using ipv6.
     */
    public function testIpIsvalidIpv6()
    {
        $ipClass = new IpHandler();
        // $ipClass->ipv4();
        $res = $ipClass->ipIsValid("2001:4860:4860::8888");
        $this->assertContains("true", $res);
    }


    /**
     * Test the general validation method using ipv6.
     */
    public function testIpIsvalidFail()
    {
        $ipClass = new IpHandler();
        $res = $ipClass->ipIsValid("invalid");
        $this->assertContains("false", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Invalid()
    {
        $ipClass = new IpHandler();
        $res = $ipClass->ipv4("invalid");
        $this->assertContains("Validerar ej", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Valid()
    {
        $ipClass = new IpHandler();
        $res = $ipClass->ipv4("8.8.8.8");
        $this->assertContains("Validerar", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    // public function testIpv4Type()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->ipv4();
    //     $res = $ipClass->ipv4("8.8.8.8");
    //     $this->assertIsString($res);
    // }


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
    // public function testIpv6Type()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->ipv6();
    //     $res = $ipClass->ipv6("2001:4860:4860::8888");
    //     $this->assertIsString($res);
    // }


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
    // public function testDomainNameType()
    // {
    //     $ipClass = new IpHandler();
    //     // $ipClass->domainName();
    //     $res = $ipClass->domainName("8.8.8.8");
    //     $this->assertIsString($res);
    // }
}
