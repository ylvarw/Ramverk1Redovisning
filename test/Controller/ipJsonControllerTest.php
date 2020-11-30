<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpJsonControllerTest extends TestCase
{
    // Create the di container.
    protected $di;
    protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new IpJsonController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }


    //  /**
    //  * Test the route "index".
    //  */
    // public function testIndexActionGet()
    // {
    //     $res = $this->controller->indexActionGet();
    //     $this->assertInternalType("array", $res);

    //     $json = $res[0];
    //     $exp = "db is active";
    //     $this->assertContains($exp, $json["message"]);
    // }

    // /**
    //  * Test the route "index".
    //  */
    // public function testIndexActionPostType()
    // {
    //     $res = $this->controller->indexActionPost();
    //     // $this->assertInstanceOf("\Anax\Response\Response", $res);

    //     // $body = $res->getBody();
    //     // $exp = "Validera IP</title>";
    //     $this->assertIsArray($res);
    // }


    // /**
    //  * Test the route "index".
    //  */
    // public function testIndexActionGetType()
    // {
    //     $controller = new IpJsonController();
    //     $res = $controller->indexActionGet();
    //     // $this->assertInstanceOf("\Anax\Response\Response", $res);

    //     // $body = $res->getBody();
    //     // $exp = "Validera IP</title>";
    //     $this->assertIsObject($res);
    // }


    // /**
    //  * Test the route "index".
    //  */
    // public function testIndexActionType()
    // {
    //     $res = $this->controller->indexAction();
    //     // $this->assertInstanceOf("\Anax\Response\Response", $res);

    //     // $body = $res->getBody();
    //     // $exp = "Validera IP</title>";
    //     $this->assertIsObject($res);
    // }

    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Invalid()
    {
        $controller = new IpJsonController();
        // $controller->ipv4();
        $res = $controller->ipv4("invalid");
        $this->assertContains("Validerar ej", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Valid()
    {
        $controller = new IpJsonController();
        // $controller->ipv4();
        $res = $controller->ipv4("8.8.8.8");
        $this->assertContains("Validerar", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testIpv4Type()
    {
        $controller = new ValidateIpController();
        // $controller->ipv4();
        $res = $controller->ipv4("8.8.8.8");
        $this->assertIsString($res);
    }



    /**
     * Test the ipv6 validation method.
     */
    public function testIpv6Invalid()
    {
        $controller = new IpJsonController();
        // $controller->ipv6();
        $res = $controller->ipv6("invalid");
        $this->assertContains("Validerar ej", $res);
    }



    /**
     * Test the ipv6 validation method.
     */
    public function testIpv6Valid()
    {
        $controller = new IpJsonController();
        // $controller->ipv6();
        $res = $controller->ipv6("2001:4860:4860::8888");
        $this->assertContains("Validerar", $res);
    }

    /**
     * Test the ipv4 validation method.
     */
    public function testIpv6Type()
    {
        $controller = new ValidateIpController();
        // $controller->ipv4();
        $res = $controller->ipv6("2001:4860:4860::8888");
        $this->assertIsString($res);
    }


    /**
     * Test the domain name checker method.
     */
    public function testDomainNameInvalid()
    {
        $controller = new IpJsonController();
        // $controller->domainName();
        $res = $controller->domainName("invalid");
        $this->assertContains("ip ej validerad", $res);
    }


    /**
     * Test the domain name checker method.
     */
    public function testDomainNameValid()
    {
        $controller = new IpJsonController();
        // $controller->domainName();
        $res = $controller->domainName("8.8.8.8");
        $this->assertContains("dns.google", $res);
    }


    /**
     * Test the ipv4 validation method.
     */
    public function testDomainNameType()
    {
        $controller = new ValidateIpController();
        // $controller->ipv4();
        $res = $controller->domainName("2001:4860:4860::8888");
        $this->assertIsString($res);
    }
}
