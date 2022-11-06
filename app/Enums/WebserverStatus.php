<?php

namespace App\Enums;

class WebserverStatus
{
    const HEALTHY   = 1;
    const UNHEALTHY = 2;

    public static function labels()
    {
        return [
            self::HEALTHY   => 'Healthy',
            self::UNHEALTHY => 'Unhealthy',
        ];
    }
}
