<?php

namespace Ylvan\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the helprt class IpHandler.
 */
class IpPositionTest extends TestCase
{

    /**
     * Test get position of IP
     */
    public function testGetposition()
    {
        // get testData
        $ipClass = new IpHandler();
        $ip = $ipClass->getUserIp();
        
        $geo = new IpPosition();
        $res = $geo->getPosition($ip);
        $this->assertNotNull($res);
    }
}