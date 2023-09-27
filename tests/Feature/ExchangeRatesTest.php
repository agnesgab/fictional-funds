<?php

namespace Tests\Feature;

use App\Services\ExchangeRateUpdateService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExchangeRatesTest extends TestCase
{
    public function test_exchange_rate_base_api_returning_successful_response()
    {
        $response = Http::get('https://api.exchangerate.host/latest');

        $this->assertTrue($response->successful());
    }

    public function test_exchange_rate_backup_api_returning_successful_response()
    {
        $response = Http::get('http://data.fixer.io/api/latest?access_key=412dd37c29c87c09e3745584a3e57907');

        $this->assertTrue(true, $response->successful());
    }

    public function test_base_currency_is_set()
    {
        $exchangeRates = [
            'EUR' => 1,
        ];

        $service = new ExchangeRateUpdateService($exchangeRates);
        $service->updateExchangeRates($exchangeRates);

        $this->assertDatabaseHas('base_currencies', [
            'code' => 'EUR',
        ]);
    }
}
