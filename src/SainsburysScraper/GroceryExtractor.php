<?php

namespace SainsburysScraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class GroceryExtractor
{
    /** @var Goutte\Client */
    protected $client;

    /** @var ProductParser */
    protected $productParser;

    /**
     * @param Goutte\Client $client
     * @param ProductParser $parser
     */
    public function __construct(Client $client, ProductParser $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    /**
     * Accepts a URL to scrape, returns an array of the results
     *
     * @param string $url
     * @return array
     */
    public function scrape($url)
    {
        $crawler = $this->client->request('GET', $url);
        $results = array();
        $total = 0;
        $crawler->filter('.productLister .product')
            ->each($this->parserClosure($results));

        foreach ($results as $result) {
            $total += (int) str_replace('£', '', $result['unit_price']);
        }

        return array(
            'results' => $results,
            'total' => number_format($total, 2)
        );
    }

    /**
     * Parses each product listing node and its product page and returns the result as an array
     *
     * @param array $results
     * @return callable
     */
    protected function parserClosure(&$results) {
        $parser = $this->parser;
        $client = $this->client;

        // Returns a closure used by the DOM crawler's each() function
        return function ($node) use ($parser, $client, &$results) {
            $productDetails = $parser->getListingDetails($node);
            if (!empty($productDetails['link'])) {
                // Use the client to fetch the product page
                $productPage = $client->request('GET', $productDetails['link']);
                // Determine the page size from the length of its body
                $pageSize = strlen($itemPage->html());
                // Parse the parse to get the description and size
                $pageDetails = $parser->getPageDetails($productPage, $pageSize);
                // Assemble the product details and array them to the results
                $details = array_merge($productDetails, $pageDetails);
                unset($details['link']);
                $results[] = $details;
            }
        };
    }
}
