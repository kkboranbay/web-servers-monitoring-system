<?php

namespace App\Services\Webserver;

use App\Repositories\Webserver\WebserverRepository;

class Monitor
{
    private WebserverRepository $webserverRepository;

    public function __construct(WebserverRepository $webserverRepository)
    {
        $this->webserverRepository = $webserverRepository;
    }

    public function handle()
    {
        foreach ($this->getProtocols() as $protocol) {
            $webservers = $this->webserverRepository->getByProtocol($protocol);

            try {
                $instance = MonitorFactory::getInstanceByProtocol($protocol);
                $instance->monitor($webservers);
            } catch (\Exception $exception) {
                // log;
                return;
            }
        }
    }

    private function getProtocols(): array
    {
        return [
            'http',
            'ftp'
        ];
    }
}
