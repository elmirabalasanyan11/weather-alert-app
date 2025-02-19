<?php

namespace App\Services;

use App\Enums\WeatherAlertType;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function sendMessage(string $message, WeatherAlertType $alertType): void
    {
        $alertIcon = match ($alertType) {
            WeatherAlertType::HIGH_PRECIPITATION => '🌧️',
            WeatherAlertType::HIGH_UV_INDEX => '☀️',
        };

        Http::post(
            "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage",
            ['chat_id' => env('TELEGRAM_CHAT_ID'), 'text' => "$alertIcon $message"]
        );
    }
}

