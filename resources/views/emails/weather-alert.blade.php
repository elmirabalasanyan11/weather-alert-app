<h2>Weather Alert for {{ $city->name }}</h2>
<p>Precipitation: {{ $weather['rain']['1h'] ?? '0' }} mm</p>
<p>UV Index: {{ $weather['uvi'] ?? 'N/A' }}</p>
