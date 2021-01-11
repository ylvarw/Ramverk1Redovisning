<?php

namespace Ylvan\Models;

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
        $ipNumber = $ipClass->getUserIp();
        
        $geo = new IpPosition();
        $res = $geo->getPosition($ipNumber);
        $this->assertNotNull($res);
    }
}
