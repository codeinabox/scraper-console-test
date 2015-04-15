<?php

namespace SainsburysScraper\Tests;

use SainsburysScraper\DependencyContainer;

class DependencyContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldReturnGoutteClient()
    {
        $container = new DependencyContainer();
        $this->assertInstanceOf('Goutte\Client', $container['goutteClient']);
    }
}
