<?php

namespace SainsburysScraper;

use Goutte\Client;
use Pimple\Container;

class DependencyContainer extends Container
{

    public function __construct()
    {
        parent::__construct();

        $this['goutteClient'] = $this->factory(
            function () {
                return new Client();
            }
        );

        $this['productParser'] = new ProductParser();
        $this['groceryExtractor'] = new GroceryExtractor(
            $this['goutteClient'],
            $this['productParser']
        );
    }
}
