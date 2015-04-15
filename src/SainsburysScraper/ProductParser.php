<?php

namespace SainsburysScraper;

use Symfony\Component\DomCrawler\Crawler;

class ProductParser
{
    /**
     * Formats bytes into a kilobytes, adding 2 decimal places if a fraction
     *
     * @param $bytes
     * @return string
     */
    protected function formatToKilobytes($bytes)
    {
        $kb = (int) $bytes / 1000;
        $isFraction = $kb != floor($kb);
        return $isFraction ? number_format($kb, 2) : number_format($kb);
    }

    /**
     * Traverses the paragraphs and formats them into a string
     *
     * @param Crawler $crawler
     * @return string
     */
    protected function formatParagraphs(Crawler $crawler)
    {
        $paragraphs = array();
        $crawler->filter('p')->each(
            function ($node) use (&$paragraphs) {
                $paragraphs[] = trim($node->text());
            }
        );
        return implode("\n\n", $paragraphs);
    }

    /**
     * Generates an array of page details
     *
     * @param Crawler $crawler
     * @param $sizeInBytes
     * @return array
     */
    public function getPageDetails(Crawler $crawler, $sizeInBytes)
    {
        $productTextPagraphs = $crawler->filter('.productText')->first();
        return array(
            'description' => $this->formatParagraphs($productTextPagraphs),
            'size' => $this->formatToKilobytes($sizeInBytes) . 'kb'
        );
    }

    /**
     * Parses an individual product listing and returns an array of their details
     *
     * @param Crawler $node
     * @return array
     */
    public function getListingDetails(Crawler $node)
    {
        $productInfo = $node->filter('.productInfo a')->extract(array('_text', 'href'));
        $price = $node->filter('.pricePerUnit')->first()->text();
        $results = array(
            'title' => trim($productInfo[0][0]),
            'unit_price' => trim(str_replace('/unit', '', $price)),
            'link' => $productInfo[0][1]
        );
        return $results;
    }
}
