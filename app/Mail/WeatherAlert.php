<?php

namespace App\Mail;

use App\Models\City;
use Illuminate\Mail\Mailable;

class WeatherAlert extends Mailable
{
    public function __construct(
        public readonly City  $city,
        public readonly array $weather
    )
    {
    }

    public function build(): self
    {
        return $this->subject('Weather Alert for ' . $this->city->name)
            ->view('emails.weather-alert');
    }
}
