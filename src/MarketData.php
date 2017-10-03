<?php
/**
 * Copyright (c) 2017 Alexander V. Basyrov, basyrov.av@gmail.com
 * Date: 04.10.17
 * Time: 1:09
 */
declare(strict_types=1);


namespace Basyrov\Moex;


use Basyrov\Moex\Exception\InvalidArgumentException;

class MarketData
{
    private $titles;
    private $columns;
    private $marketData;

    public function __construct(array $titles, array $columns, array $marketData)
    {
        if (count($titles) === 0 ||
            count($columns) === 0 ||
            !isset($marketData[0]) ||
            count($columns) !== count($marketData[0])
        ) {
            throw new InvalidArgumentException();
        }

        $this->titles     = $titles;
        $this->columns    = $columns;
        $this->marketData = $marketData;
    }


    public function getByTitle(string $title): array
    {
        $index = array_search($title, $this->titles, true);

        if ($index === false) {
            throw new InvalidArgumentException('Title ' . $title . ' not found in titles data');
        }

        if (!isset($this->marketData[$index])) {
            throw new InvalidArgumentException('Title ' . $title . ' mismatch loaded market data');
        }

        return $this->marketData[$index];
    }
}
