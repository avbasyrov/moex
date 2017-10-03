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

    public function getQuotes($title)
    {
        $info = $this->api->getMarketData([$title]);

        return $info->getByTitle($title);
    }
}
