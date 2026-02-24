# metalpriceapi

metalpriceapi is the official PHP wrapper for MetalpriceAPI.com. This allows you to quickly integrate our metal price API and foreign exchange rate API into your application. Check https://metalpriceapi.com documentation for more information.

## Installation

#### Composer

```
$ composer require metalpriceapi/metalpriceapi-php
```
---
## Usage

```php
use MetalpriceAPI\Client;

$client = new Client('SET_YOUR_API_KEY_HERE');
$result = $client->fetchLive('USD', ['XAU', 'XAG', 'XPD', 'XPT']);
```
---
## Server Regions

MetalpriceAPI provides two regional endpoints. Choose the one closest to your servers for optimal performance.

| Region | Base URL |
|--------|----------|
| United States (default) | `https://api.metalpriceapi.com/v1` |
| Europe | `https://api-eu.metalpriceapi.com/v1` |

```php
use MetalpriceAPI\Client;

// Default (US)
$client = new Client('SET_YOUR_API_KEY_HERE');

// Europe
$client = new Client('SET_YOUR_API_KEY_HERE', Client::BASE_URL_EU);
```

---
## setServer

You can switch server regions at runtime using the `setServer` method:

```php
$client = new Client('SET_YOUR_API_KEY_HERE');

// Switch to EU server
$client->setServer('eu');

// Switch back to US server
$client->setServer('us');
```

---
## Documentation

#### fetchSymbols()
```php
$client->fetchSymbols();
```

[Link](https://metalpriceapi.com/documentation#api_symbol)

---
#### fetchLive($base, $currencies, $unit, $purity, $math)

- `$base` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$currencies` <[array]<[string]>> Optional. Pass in an array of currencies to return values for.
- `$unit` <[string]> Optional. Pass in a unit for metal prices (e.g. `troy_oz`, `gram`, `kilogram`).
- `$purity` <[string]> Optional. Pass in a purity level for metal prices.
- `$math` <[string]> Optional. Pass in a math expression to apply to the rates.

```php
$client->fetchLive('USD', ['XAU', 'XAG', 'XPD', 'XPT'], 'troy_oz', null, null);
```

[Link](https://metalpriceapi.com/documentation#api_realtime)

---
#### fetchHistorical($date, $base, $currencies, $unit)

- `$date` <[string]> Required. Pass in a string with format `YYYY-MM-DD`
- `$base` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$currencies` <[array]<[string]>> Optional. Pass in an array of currencies to return values for.
- `$unit` <[string]> Optional. Pass in a unit for metal prices (e.g. `troy_oz`, `gram`, `kilogram`).

```php
$client->fetchHistorical('2024-02-05', 'USD', ['XAU', 'XAG', 'XPD', 'XPT'], 'troy_oz');
```

[Link](https://metalpriceapi.com/documentation#api_historical)

---
#### hourly($base, $currency, $unit, $startDate, $endDate, $math, $dateType)

- `$base` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$currency` <[string]> Required. Specify currency you would like to get hourly rates for.
- `$unit` <[string]> Optional. Pass in a unit for metal prices (e.g. `troy_oz`, `gram`, `kilogram`).
- `$startDate` <[string]> Required. Specify the start date using the format `YYYY-MM-DD`.
- `$endDate` <[string]> Required. Specify the end date using the format `YYYY-MM-DD`.
- `$math` <[string]> Optional. Pass in a math expression to apply to the rates.
- `$dateType` <[string]> Optional. Pass in a date type, overrides date parameters if passed in.

```php
$client->hourly('USD', 'XAU', 'troy_oz', '2025-11-03', '2025-11-03', null, null);
```

[Link](https://metalpriceapi.com/documentation#api_hourly)

---
#### ohlc($base, $currency, $date, $unit, $dateType)

- `$base` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$currency` <[string]> Required. Specify currency you would like to get OHLC for.
- `$date` <[string]> Required. Specify date to get OHLC for specific date using format `YYYY-MM-DD`.
- `$unit` <[string]> Optional. Pass in a unit, defaults to troy_oz.
- `$dateType` <[string]> Optional. Pass in a date type, overrides date parameter if passed in.

```php
$client->ohlc('USD', 'XAU', '2024-02-06', 'troy_oz', null);
```

[Link](https://metalpriceapi.com/documentation#api_ohlc)

---
#### convert($from, $to, $amount, $date, $unit)

- `$from` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$to` <[string]> Required. Specify currency you would like to convert to.
- `$amount` <[number]> Required. The amount to convert.
- `$date` <[string]> Optional. Specify date to use historical midpoint value for conversion with format `YYYY-MM-DD`. Otherwise, it will use live exchange rate date if value not passed in.
- `$unit` <[string]> Optional. Pass in a unit for metal prices (e.g. `troy_oz`, `gram`, `kilogram`).

```php
$client->convert('USD', 'EUR', 100, '2024-02-05', null);
```

[Link](https://metalpriceapi.com/documentation#api_convert)

---
#### timeframe($startDate, $endDate, $base, $currencies, $unit)

- `$startDate` <[string]> Required. Specify the start date of your timeframe using the format `YYYY-MM-DD`.
- `$endDate` <[string]> Required. Specify the end date of your timeframe using the format `YYYY-MM-DD`.
- `$base` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$currencies` <[array]<[string]>> Optional. Pass in an array of currencies to return values for.
- `$unit` <[string]> Optional. Pass in a unit for metal prices (e.g. `troy_oz`, `gram`, `kilogram`).

```php
$client->timeframe('2024-02-05', '2024-02-06', 'USD', ['XAU', 'XAG', 'XPD', 'XPT'], 'troy_oz');
```

[Link](https://metalpriceapi.com/documentation#api_timeframe)

---
#### change($startDate, $endDate, $base, $currencies, $dateType)

- `$startDate` <[string]> Required. Specify the start date of your timeframe using the format `YYYY-MM-DD`.
- `$endDate` <[string]> Required. Specify the end date of your timeframe using the format `YYYY-MM-DD`.
- `$base` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$currencies` <[array]<[string]>> Optional. Pass in an array of currencies to return values for.
- `$dateType` <[string]> Optional. Pass in a date type, overrides date parameters if passed in.

```php
$client->change('2024-02-05', '2024-02-06', 'USD', ['XAU', 'XAG', 'XPD', 'XPT'], null);
```

[Link](https://metalpriceapi.com/documentation#api_change)

---
#### carat($base, $currency, $date)

- `$base` <[string]> Optional. Pass in a base currency, defaults to USD.
- `$currency` <[string]> Optional. Pass in a metal code to get carat prices for (defaults to XAU).
- `$date` <[string]> Optional. Specify date to get Carat for specific date using format `YYYY-MM-DD`. If not specified, uses live rates.

```php
$client->carat('USD', 'XAU', '2024-02-06');
```

[Link](https://metalpriceapi.com/documentation#api_carat)

---
#### usage()

```php
$client->usage();
```

[Link](https://metalpriceapi.com/documentation#api_usage)

---
**[Official documentation](https://metalpriceapi.com/documentation)**

---
## FAQ

- How do I get an API Key?

    Free API Keys are available [here](https://metalpriceapi.com).

- I want more information

    Checkout our FAQs [here](https://metalpriceapi.com/faq).


## Support

For support, get in touch using [this form](https://metalpriceapi.com/contact).


[array]: https://www.php.net/manual/en/language.types.array.php 'Array'
[number]: https://www.php.net/manual/en/language.types.float.php 'Number'
[string]: https://www.php.net/manual/en/language.types.string.php 'String'
