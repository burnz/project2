<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\ExchangeRate;

/**
*  @author GiangDT
*/
class ExchangeRateAPI
{

    const DEFAULT_BTC_EXCHANGE_URL = 'https://www.bitstamp.net/api/v2/ticker/';

    const DEFAULT_CAR_EXCHANGE_URL = 'https://btc-alpha.com/api/charts/CARS_BTC/1/chart/';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getCLPUSDRate()
    {
        $clpUSDRate = self::getCLPBTCRate() * self::getBTCUSDRate();
        
        return round($clpUSDRate, 2);
    }

    public function getBTCUSDRate() 
    {
        $url = config('app.link_ty_gia') ?  config('app.link_ty_gia') : self::DEFAULT_BTC_EXCHANGE_URL;
        $path = rtrim($url, '/') . '/btcusd';

        $response = $this->client->request('GET', $path);

        $result =json_decode($response->getBody(), true);
        
        return $result['last'];
    }

    public function getCLPBTCRate()
    {
        $clpBTCRate = ExchangeRate::where('from_currency', '=', 'clp')->where('to_currency', '=', 'btc')->first();
        
        return $clpBTCRate->exchrate;
    }
}
