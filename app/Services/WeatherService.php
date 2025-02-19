<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    public function getWeather($city): ?array
    {
        $apiKey = config('services.openweather.key');
        $weatherUrl = config('services.openweather.base_url');
        $geoUrl = config('services.openweather.geo_url');
        $uvUrl = config('services.openweather.uv_url');

        if (empty($city)) {
            throw new \InvalidArgumentException("City name cannot be empty.");
        }
        $cityName = urlencode($city->name);


        // 1. getting city coordinates
        $geoResponse = Http::get("{$geoUrl}?q={$cityName}&limit=1&appid={$apiKey}");

        if ($geoResponse->failed()) {
            Log::error("Failed to fetch geo coordinates for city: {$cityName}", [
                'url' => "{$geoUrl}?q={$cityName}&limit=1&appid={$apiKey}",
                'status' => $geoResponse->status(),
                'response' => $geoResponse->body(),
            ]);
            return null;
        }

        $geoData = $geoResponse->json();

        if (empty($geoData[0]) || !isset($geoData[0]['lat'], $geoData[0]['lon'])) {
            Log::warning("No coordinates found for city: {$cityName}");
            return null;
        }

        $lat = $geoData[0]['lat'];
        $lon = $geoData[0]['lon'];

        // 2. getting weather
        $weatherResponse = Http::get("{$weatherUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric");

        if ($weatherResponse->failed()) {
            Log::error("Failed to fetch weather for coordinates: {$lat}, {$lon}", [
                'url' => "{$weatherUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric",
                'status' => $weatherResponse->status(),
                'response' => $weatherResponse->body(),
            ]);
            return null;
        }

        $weatherData = $weatherResponse->json();

//         3.getting uv index
        $uvResponse = Http::get("{$uvUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}");


        if ($uvResponse->failed()) {
            Log::error("Failed to fetch UV index for coordinates: {$lat}, {$lon}", [
                'url' => "{$uvUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}",
                'status' => $uvResponse->status(),
                'response' => $uvResponse->body(),
            ]);
            return null;
        }

        $uvData = $uvResponse->json();

        return [
            'weather' => $weatherData,
            'uv_index' => $uvData['current']['uvi'] ?? null,
        ];
    }
}
