<?php

namespace SainsburysScraper\Tests;

use SainsburysScraper\Command;
use \Mockery as m;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldJsonPrettyPrintOutput()
    {
        $expected = <<<'EOD'
{
    "node": "I am pretty printed"
}
EOD;
        $url = "http://www.testscrapeurl.com";

        $mockExtractor = m::mock('SainsburysScraper\GroceryExtractor');
        $mockExtractor->shouldReceive('scrape')->with($url)
            ->once()->andReturn(
                array(
                    'node' => "I am pretty printed"
                )
            );

        $command = new Command($mockExtractor);
        $this->assertEquals($expected, $command->execute($url));
    }
}
