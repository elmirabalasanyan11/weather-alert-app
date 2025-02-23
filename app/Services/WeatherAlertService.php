<?php

namespace App\Services;

use App\Enums\WeatherAlertType;
use App\Models\User;
use App\Services\Notifications\EmailService;
use App\Services\Notifications\NotificationContext;
use App\Services\Notifications\SMSService;
use App\Services\Notifications\TelegramService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\NoReturn;

class WeatherAlertService
{
    public function __construct(
        private readonly WeatherService $weatherService,
    )
    {
    }

    public function checkWeatherForUsers(): void
    {
        $users = User::with('userCities.city')->get();

        $users->each(fn($user) => $user->userCities->each(fn($userCity) => $this->processWeather($user, $userCity->city)));
    }

    #[NoReturn] private function processWeather($user, $city): void
    {
        if (!$city) {
            return;
        }

        $cacheKey = "weather_forecast_{$city->id}";

        $weatherData = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($city) {
            Log::info("Fetching weather data for {$city->name} from API.");
            return $this->weatherService->getWeather($city);
        });


        if (!$weatherData || !isset($weatherData['weather'])) {
            Log::warning("No weather data available for {$city->name}.");
            return;
        }

        $weather = $weatherData['weather'];
        $uvIndex = $weatherData['uv_index'] ?? 0;

        $rainVolume = $weather['rain']['1h'] ?? 0;

        if ($rainVolume > 10) {
            $this->sendWeatherAlert($user, $city, "Heavy rain expected ({$rainVolume}mm) in the next hour!", WeatherAlertType::HIGH_PRECIPITATION);
        }

        if ($uvIndex > 8) {
            $this->sendWeatherAlert($user, $city, "High UV Index ({$uvIndex}) expected!", WeatherAlertType::HIGH_UV_INDEX);
        }
    }


    private function sendWeatherAlert($user, $city, string $message, WeatherAlertType $type): void
    {
        $methods = $user->notification_methods ?? ['email']; // Default to email if empty

        $data = [
            'message' => $message,
            'city' => $city,
            'type' => $type
        ];

        foreach ($methods as $method) {
            $strategy = match ($method) {
                'sms' => new SMSService(),
                'telegram' => new TelegramService(),
                default => new EmailService(),
            };

            $context = new NotificationContext($strategy);
            $context->notify($user, $data);
        }
    }
}
