<?php

namespace MetalpriceAPI;

class Client
{
    const VERSION = '1.0.0';
    const BASE_URL = 'https://api.metalpriceapi.com/v1';
    const BASE_URL_EU = 'https://api-eu.metalpriceapi.com/v1';
    const CONNECT_TIMEOUT = 10;
    const TIMEOUT = 30;

    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey, $baseUrl = self::BASE_URL)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function setServer($server)
    {
        $this->baseUrl = $server === 'eu' ? self::BASE_URL_EU : self::BASE_URL;
    }

    private function removeEmpty($params)
    {
        return array_filter($params, function ($value) {
            return $value !== null && $value !== '';
        });
    }

    private function request($endpoint, $params = [])
    {
        $params['api_key'] = $this->apiKey;
        $params = $this->removeEmpty($params);

        $url = $this->baseUrl . '/' . $endpoint . '?' . http_build_query($params);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => [
                'User-Agent: metalpriceapi-php/' . self::VERSION . ' PHP/' . PHP_VERSION,
                'Accept: application/json',
            ],
            CURLOPT_CONNECTTIMEOUT => self::CONNECT_TIMEOUT,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            $errno = curl_errno($curl);
            curl_close($curl);
            throw new \RuntimeException(
                "MetalpriceAPI request failed: [$errno] $error"
            );
        }

        curl_close($curl);

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(
                'MetalpriceAPI response is not valid JSON: ' . json_last_error_msg()
            );
        }

        return $decoded;
    }

    public function fetchSymbols()
    {
        return $this->request('symbols');
    }

    public function fetchLive($base = null, $currencies = null, $unit = null, $purity = null, $math = null)
    {
        return $this->request('latest', [
            'base' => $base,
            'currencies' => $currencies ? implode(',', $currencies) : null,
            'unit' => $unit,
            'purity' => $purity,
            'math' => $math,
        ]);
    }

    public function fetchHistorical($date, $base = null, $currencies = null, $unit = null)
    {
        return $this->request($date, [
            'base' => $base,
            'currencies' => $currencies ? implode(',', $currencies) : null,
            'unit' => $unit,
        ]);
    }

    public function hourly($base = null, $currency = null, $unit = null, $startDate = null, $endDate = null, $math = null, $dateType = null)
    {
        return $this->request('hourly', [
            'base' => $base,
            'currency' => $currency,
            'unit' => $unit,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'math' => $math,
            'date_type' => $dateType,
        ]);
    }

    public function ohlc($base = null, $currency = null, $date = null, $unit = null, $dateType = null)
    {
        return $this->request('ohlc', [
            'base' => $base,
            'currency' => $currency,
            'date' => $date,
            'unit' => $unit,
            'date_type' => $dateType,
        ]);
    }

    public function convert($from = null, $to = null, $amount = null, $date = null, $unit = null)
    {
        return $this->request('convert', [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
            'date' => $date,
            'unit' => $unit,
        ]);
    }

    public function timeframe($startDate = null, $endDate = null, $base = null, $currencies = null, $unit = null)
    {
        return $this->request('timeframe', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'base' => $base,
            'currencies' => $currencies ? implode(',', $currencies) : null,
            'unit' => $unit,
        ]);
    }

    public function change($startDate = null, $endDate = null, $base = null, $currencies = null, $dateType = null)
    {
        return $this->request('change', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'base' => $base,
            'currencies' => $currencies ? implode(',', $currencies) : null,
            'date_type' => $dateType,
        ]);
    }

    public function carat($base = null, $currency = null, $date = null)
    {
        return $this->request('carat', [
            'base' => $base,
            'currency' => $currency,
            'date' => $date,
        ]);
    }

    public function usage()
    {
        return $this->request('usage');
    }
}
