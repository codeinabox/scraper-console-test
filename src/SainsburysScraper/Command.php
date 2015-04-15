<?php

namespace SainsburysScraper;

class Command
{
    /** @var GroceryExtractor */
    protected $groceryExtractor;

    public function __construct(GroceryExtractor $groceryExtractor = null)
    {
        if (!$groceryExtractor) {
            $dependencies = new DependencyContainer();
            $groceryExtractor = $dependencies['groceryExtractor'];
        }
        $this->groceryExtractor = $groceryExtractor;
    }

    /**
     * Executes the command, returns the results encoded as JSON
     *
     * @param string $url
     * @return string
     */
    public function execute($url)
    {
        $data = $this->groceryExtractor->scrape($url);
        return json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE
        );
    }
}
