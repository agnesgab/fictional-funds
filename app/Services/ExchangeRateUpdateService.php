<?php

namespace App\Services;

use App\Models\BaseCurrency;
use App\Models\Currency;

class ExchangeRateUpdateService
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function execute()
    {
        if (isset($this->data['base']) && isset($this->data['rates'])) {
            $this->updateBaseCurrency($this->data['base']);
            $this->updateExchangeRates($this->data['rates']);
        }

        return false;
    }

    public function updateBaseCurrency(string $baseCurrency)
    {
        $currentBaseCurrency = BaseCurrency::first();

        if($currentBaseCurrency) {
            $currentBaseCurrency->update([
                'code' => $baseCurrency,
            ]);
        } else {
            BaseCurrency::create([
                'code' => $baseCurrency,
            ]);
        }
    }

    public function updateExchangeRates(array $exchangeRates)
    {
        foreach ($exchangeRates as $key => $rate) {
            Currency::updateOrCreate(
                ['code' => $key],
                ['code' => $key, 'exchange_rate' => $rate,]
            );
        }
    }
}
