<?php

namespace App\Http\Controllers;

use App\Models\UserCity;
use App\Services\WeatherService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();

        // Cache the list of all cities for 30 minutes to reduce DB queries
        $allCities = Cache::remember('all_cities', now()->addMinutes(30), function () {
            return DB::table('cities')->get();
        });

        // User-specific cities should not be cached globally since they change per user
        $userCities = $user->userCities()->with('city')->get();

        return view('cities.index', compact('userCities', 'allCities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cities' => 'required|array|max:5',
            'cities.*' => 'exists:cities,id',
        ]);

        Cache::forget('all_cities');

        $user = Auth::user();
        $existingCityIds = $user->userCities()->pluck('city_id')->toArray();

        $newCities = array_diff($request->cities, $existingCityIds);

        if (!empty($newCities)) {
            $userCities = array_map(fn($cityId) => [
                'city_id' => $cityId,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ], $newCities);

            UserCity::insert($userCities);
        }

        return redirect()->route('cities.index')->with('success', 'Cities updated.');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(UserCity $userCity)
    {
        $this->authorize('delete', $userCity);
        $userCity->delete();

        return redirect()->route('cities.index')->with('success', 'City removed successfully.');
    }
}
