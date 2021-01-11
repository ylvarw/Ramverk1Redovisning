<?php

namespace Ylvan\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class GeotagControllerTest extends TestCase
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
        $this->controller = new GeotagController();
        $this->controller->setDI($this->di);
        //$this->controller->initialize();
    }


    /**
     * Test the route "index".
     */
    public function testIndexActionType()
    {
        $res = $this->controller->indexAction();
        // $this->assertInstanceOf("\Anax\Response\Response", $res);

        // $body = $res->getBody();
        // $exp = "Validera IP</title>";
        $this->assertIsObject($res);
    }

    /**
     * Test the route "index".
     */
    public function testIndexActioncontent()
    {
        $res = $this->controller->indexAction();
        // $this->assertInstanceOf("\Anax\Response\Response", $res);

        // $body = $res->getBody();
        // $exp = "Validera IP</title>";
        $this->assertNotNull($res);
    }
}
