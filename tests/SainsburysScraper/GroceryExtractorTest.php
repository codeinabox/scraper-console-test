<?php

namespace SainsburysScraper\Tests;

use SainsburysScraper\GroceryExtractor;

class GroceryExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldConstruct()
    {
        $mockClient = \Mockery::mock('Goutte\Client');
        $mockParser = \Mockery::mock('SainsburysScraper\ProductParser');
        $groceryExtractor = new GroceryExtractor($mockClient, $mockParser);
    }
}
