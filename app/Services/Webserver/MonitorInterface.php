<?php

namespace App\Services\Webserver;

use Illuminate\Database\Eloquent\Collection;

interface MonitorInterface
{
    public function monitor(Collection $webservers);
}
