<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Select Cities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- City Selection Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Select up to 5 cities</h3>

                    <form action="{{ route('cities.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="cities" class="block font-medium text-gray-700">Cities</label>
                            <select id="cities" name="cities[]" multiple class="w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($allCities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">You can select up to 5 cities</p>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg">
                            Submit
                        </button>
                    </form>
                </div>
            </div>

            {{-- List of Selected Cities --}}
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Your Selected Cities</h3>

                    @if ($userCities->isEmpty())
                        <p class="text-gray-500">You haven't added any cities yet.</p>
                    @else
                        <ul>
                            @foreach ($userCities as $userCity)
                                <li class="flex justify-between items-center py-2 border-b">
                                    <span>{{ $userCity->city->name }}</span>
                                    <form action="{{ route('cities.destroy', $userCity->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this city?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Choices.js for multi-select --}}
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#cities', {
                removeItemButton: true,
                maxItemCount: 5,
                placeholderValue: "Select cities...",
                searchEnabled: true,
            });
        });
    </script>
</x-app-layout>
