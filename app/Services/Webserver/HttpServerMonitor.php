<?php

namespace App\Services\Webserver;

use App\DTO\WebserverRequestDTO;
use App\Enums\WebserverStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class HttpServerMonitor implements MonitorInterface
{
    public const REQUEST_TIMEOUT = 60;

    public function monitor(Collection $webservers)
    {
        $responses = Http::pool(function (Pool $pool) use ($webservers) {
            foreach ($webservers as $webserver) {
                $pool->as($webserver->id)
                    ->timeout(self::REQUEST_TIMEOUT)
                    ->get($webserver->url);
            }
        });

        foreach ($responses as $webserverId => $response) {
            try {
                $status = $response->successful() ? WebserverStatus::HEALTHY : WebserverStatus::UNHEALTHY;
            } catch (\Throwable $exception) {
                $status = WebserverStatus::UNHEALTHY;
            }

            $webserverRequestDTO = new WebserverRequestDTO($status, time());
            $webserver = $webservers->keyBy('id')->get($webserverId);
            (new Updater($webserver, $webserverRequestDTO))->handle();
        }
    }
}
