<?php
/**
 * Copyright (c) 2017 Alexander V. Basyrov, basyrov.av@gmail.com
 * Date: 04.10.17
 * Time: 2:28
 */
declare(strict_types=1);


namespace Basyrov\Moex;


class Stock
{
    private $title;
    private $stockData;

    public function __construct(string $title, MarketData $marketData)
    {
        $this->title = $title;
        $this->stockData = $marketData->getByTitle($title);
    }


    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Bid is the price selected by a buyer to purchase a stock.
     *
     * @return float $price can be zero when not trading time
     */
    public function getBidPrice(): float
    {
        return (float)$this->stockData['BID'];
    }


    /**
     * Offer is the price at which the seller is offering to sell the stock.
     *
     * @return float $price can be zero when not trading time
     */
    public function getOfferPrice(): float
    {
        return (float)$this->stockData['OFFER'];
    }


    public function getLastPrice(): float
    {
        return (float)$this->stockData['LAST'];
    }
}
