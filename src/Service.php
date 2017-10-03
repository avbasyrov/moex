<?php
/**
 * Copyright (c) 2017 Alexander V. Basyrov, basyrov.av@gmail.com
 * Date: 04.10.17
 * Time: 0:27
 */
declare(strict_types=1);

namespace Basyrov\Moex;


class Service
{
    private $api;


    public function __construct()
    {
        $this->api = new Api();
    }

    public function getStock(string $title): Stock
    {
        return new Stock($title, $this->api->getMarketData([$title]));
    }


    public function getStocks(array $titles): array
    {
        $collection = [];
        $marketData = $this->api->getMarketData($titles);

        foreach ($titles as $title) {
            $collection[$title] = new Stock($title, $marketData);
        }

        return $collection;
    }
}
