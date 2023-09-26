<?php

namespace App\Console\Commands;

use App\Services\ExchangeRateUpdateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateCurrencyExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-currency-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update currency exchange rates from API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $response = Http::get('https://api.exchangerate.host/latest');

            if ($response->successful()) {
                $data = $response->json();

                $service = (new ExchangeRateUpdateService($data));
                $service->execute();

                $this->info('Exchange rates updated successfully.');
            } else {
                $this->backupFetch();
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }

    public function backupFetch()
    {
        $response = Http::get('http://data.fixer.io/api/latest?access_key=412dd37c29c87c09e3745584a3e57907');

        if ($response->successful()) {
            $data = $response->json();

            $service = (new ExchangeRateUpdateService($data));
            $service->execute();

            $this->info('Exchange rates updated successfully. Backup fetch was used.');
        }
    }
}
