<?php
/**
 * Copyright (c) 2017 Alexander V. Basyrov, basyrov.av@gmail.com
 * Date: 04.10.17
 * Time: 0:29
 */
declare(strict_types=1);

namespace Basyrov\Moex;


use Basyrov\Moex\Exception\InvalidArgumentException;
use Basyrov\Moex\Exception\ServerException;

final class Api
{
    const URL = 'https://iss.moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities/%s.json?iss.meta=off&iss.only=marketdata&lang=en';

    public function getMarketData(array $titles): MarketData
    {
        if (!self::checkTitles($titles)) {
            throw new InvalidArgumentException('Wrong titles given');
        }

        array_map('trim', $titles);

        $url = sprintf(self::URL, implode($titles));
        $rawReply = $this->request($url);

        if (empty($rawReply)) {
            throw new ServerException('Failed to retrieve data from ' . $url);
        }

        $reply = json_decode($rawReply, true);

        if (!is_array($reply) || !isset($reply['marketdata']['columns'])) {
            throw new ServerException('Unexpected data in reply: ' . $rawReply);
        }

        return new MarketData($titles, $reply['marketdata']['columns'], $reply['marketdata']['data']);
    }


    private function request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $reply = curl_exec($ch);
        curl_close($ch);

        return $reply;
    }


    private static function checkTitles(array $titles): bool
    {
        if (empty($titles)) {
            return false;
        }

        foreach ($titles as $title) {
            if (empty($title) ||
                !is_string($title) ||
                strpos($title, ',') !== false
            ) {
                return false;
            }
        }

        return true;
    }
}
