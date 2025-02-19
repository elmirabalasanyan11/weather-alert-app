<?php

namespace App\Services;

use App\Enums\WeatherAlertType;
use App\Mail\WeatherAlert;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class WeatherAlertService
{
    public function __construct(
        private WeatherService  $weatherService,
        private TelegramService $telegramService
    ) {
    }

    public function checkWeatherForUsers(): void
    {
        $users = User::with('userCities.city')->get();

        $users->each(fn($user) =>
        $user->userCities->each(fn($userCity) =>
        $this->processWeather($user, $userCity->city))
        );
    }

    private function processWeather($user, $city): void
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
        Mail::to($user->email)->send(new WeatherAlert($city, ['message' => $message]));
        $this->telegramService->sendMessage($message, $type);
    }
}
