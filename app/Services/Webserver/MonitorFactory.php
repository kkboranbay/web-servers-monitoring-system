<?php

namespace App\Services\Webserver;

class MonitorFactory
{
    public static function getInstanceByProtocol(string $protocol): MonitorInterface
    {
        return match ($protocol) {
            'http'  => new HttpServerMonitor(),
            'ftp'   => new FtpServerMonitor(),
            default => throw new \Exception('Undefined protocol'),
        };
    }
}
