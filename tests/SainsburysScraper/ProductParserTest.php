<?php

namespace SainsburysScraper\Tests;

use SainsburysScraper\ProductParser;
use \Mockery as m;

class ProductParserTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldGetListingDetails()
    {
        $expected = array(
            'title' => 'product title',
            'link' => 'http://www.producturl.com',
            'unit_price' => '£12'
        );

        $mockNode = m::mock('Symfony\Component\Domcrawler\Crawler');
        $mockNode->shouldReceive('filter')->with('.productInfo a')
            ->once()->andReturn(m::self())->getmock()
            ->shouldReceive('extract')->with(array('_text', 'href'))
            ->andReturn(
                array(
                    array(
                        'product title',
                        'http://www.producturl.com'
                    )
                )
            );

        $mockNode->shouldReceive('filter')->with('.pricePerUnit')
            ->once()->andReturn(m::self())->getMock()
            ->shouldReceive('first->text')
            ->andReturn('£12/unit');

        $parser = new ProductParser();
        $result = $parser->getListingDetails($mockNode);
        $this->assertEquals($expected, $result);
    }

    public function testShouldGetPageDetailsWherePageSizeHasDecimals()
    {
        $expected = array(
            'description' => "Paragraph 1\n\nParagraph 2",
            'size' => '9.36kb'
        );

        $mockNode = m::mock('Symfony\Component\DomCrawler\Crawler');
        $mockNode->shouldReceive('filter')->with('.productText')
            ->once()->andReturn(m::self())->getMock()
            ->shouldReceive('first')
            ->once()->andReturn(m::self())->getMock()
            ->shouldReceive('filter')->with('p')
            ->once()->andReturn(m::self())->getMock()
            ->shouldReceive("each")
            ->with(
                m::on(
                    function ($value) {
                        $paragraphs = array('Paragraph 1', 'Paragraph 2');
                        foreach ($paragraphs as $paragraph) {
                            $mockParagraph = m::mock('Symfony\Component\DomCrawler\Crawler');
                            $mockParagraph->shouldReceive('text')->andReturn($paragraph);
                            $value($mockParagraph);
                        }
                        return is_callable($value);
                    }
                )
            );

        $parser = new ProductParser();
        $result = $parser->getPageDetails($mockNode, 9360);
        $this->assertEquals($expected, $result);
    }

    public function testShouldGetPageDetails()
    {
        $expected = array(
            'description' => "Paragraph 1\n\nParagraph 2",
            'size' => '9kb'
        );

        $mockNode = m::mock('Symfony\Component\DomCrawler\Crawler');
        $mockNode->shouldReceive('filter')->with('.productText')
            ->once()->andReturn(m::self())->getMock()
            ->shouldReceive('first')
            ->once()->andReturn(m::self())->getMock()
            ->shouldReceive('filter')->with('p')
            ->once()->andReturn(m::self())->getMock()
            ->shouldReceive("each")
            ->with(
                m::on(
                    function ($value) {
                        $paragraphs = array('Paragraph 1', 'Paragraph 2');
                        foreach ($paragraphs as $paragraph) {
                            $mockParagraph = m::mock('Symfony\Component\DomCrawler\Crawler');
                            $mockParagraph->shouldReceive('text')->andReturn($paragraph);
                            $value($mockParagraph);
                        }
                        return is_callable($value);
                    }
                )
            );

        $parser = new ProductParser();
        $result = $parser->getPageDetails($mockNode, 9000);
        $this->assertEquals($expected, $result);
    }
}
