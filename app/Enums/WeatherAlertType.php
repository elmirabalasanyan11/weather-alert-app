<?php

namespace App\Enums;

enum WeatherAlertType: string
{
    case HIGH_PRECIPITATION = 'high_precipitation';
    case HIGH_UV_INDEX = 'high_uv_index';
}
