<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherAlertService;

class CheckWeather extends Command
{
    protected $signature = 'weather:check';
    protected $description = 'Check weather alerts for users and send notifications';

    public function __construct(private readonly WeatherAlertService $weatherAlertService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->weatherAlertService->checkWeatherForUsers();
        $this->info('Weather check completed.');
    }
}
