<?php

namespace Tests\Feature;

use App\Console\Commands\CheckWeather;
use App\Mail\WeatherAlert;
use App\Services\WeatherAlertService;
use App\Services\WeatherService;
use App\Models\UserCity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Models\User;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeatherTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_weather_command()
    {
        $weatherAlertService = \Mockery::spy(WeatherAlertService::class);
        $weatherAlertService->shouldReceive('checkWeatherForUsers')->once();

        $this->app->instance(WeatherAlertService::class, $weatherAlertService);

        $this->artisan('weather:check')->expectsOutput('Weather check completed.');

    }

    public function test_weather_service_fetches_data()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                ['lat' => 40.7128, 'lon' => -74.0060]
            ], 200),
        ]);

        $weatherService = new WeatherService();
        $city = City::factory()->create(['name' => 'New York']);

        $data = $weatherService->getWeather($city);
        $this->assertIsArray($data);
    }

    public function test_weather_alert_service_sends_notifications()
    {
        Mail::fake();
        Log::spy();
        Cache::shouldReceive('remember')->andReturn([
            'weather' => ['rain' => ['1h' => 15]],
            'uv_index' => 9
        ]);

        $user = User::factory()->create();
        $city = City::factory()->create();
        $user->userCities()->create(['city_id' => $city->id]);

        $weatherAlertService = app(WeatherAlertService::class);
        $weatherAlertService->checkWeatherForUsers();

        Mail::assertSent(WeatherAlert::class);
    }

    public function test_city_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('cities.index'));
        $response->assertStatus(200);
    }

    public function test_store_cities()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();

        $response = $this->actingAs($user)->post(route('cities.store'), [
            'cities' => [$city->id],
        ]);

        $response->assertRedirect(route('cities.index'));
        $this->assertDatabaseHas('user_cities', ['user_id' => $user->id, 'city_id' => $city->id]);
    }

    public function test_store_cities_fails_with_invalid_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('cities.store'), [
            'cities' => ['invalid'],
        ]);

        $response->assertSessionHasErrors('cities.*');
    }

    public function test_destroy_city()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $userCity = UserCity::create(['user_id' => $user->id, 'city_id' => $city->id]);

        $response = $this->actingAs($user)->delete(route('cities.destroy', $userCity));
        $response->assertRedirect(route('cities.index'));
        $this->assertDatabaseMissing('user_cities', ['id' => $userCity->id]);
    }
}
