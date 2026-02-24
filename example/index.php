<?php

require_once __DIR__ . '/../vendor/autoload.php';
// Or if not using Composer: require_once __DIR__ . '/../src/Client.php';

use MetalpriceAPI\Client;

$apiKey = 'REPLACE_ME';

// Default (US server)
$client = new Client($apiKey);

// Or use the EU server for lower latency in Europe:
// $client = new Client($apiKey, Client::BASE_URL_EU);

$result = $client->fetchSymbols();
print_r($result);

$result = $client->fetchLive('USD', ['XAU', 'XAG', 'XPD', 'XPT'], 'troy_oz', null, null);
print_r($result);

$result = $client->fetchHistorical('2024-02-05', 'USD', ['XAU', 'XAG', 'XPD', 'XPT'], 'troy_oz');
print_r($result);

$result = $client->hourly('USD', 'XAU', 'troy_oz', '2025-11-03', '2025-11-03', null, null);
print_r($result);

$result = $client->ohlc('USD', 'XAU', '2024-02-06', 'troy_oz', null);
print_r($result);

$result = $client->convert('USD', 'EUR', 100, '2024-02-05', null);
print_r($result);

$result = $client->timeframe('2024-02-05', '2024-02-06', 'USD', ['XAU', 'XAG', 'XPD', 'XPT'], 'troy_oz');
print_r($result);

$result = $client->change('2024-02-05', '2024-02-06', 'USD', ['XAU', 'XAG', 'XPD', 'XPT'], null);
print_r($result);

$result = $client->carat('USD', 'XAU', '2024-02-06');
print_r($result);

$result = $client->usage();
print_r($result);
