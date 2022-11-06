<?php

namespace App\Console\Commands;

use App\Services\Webserver\Monitor;
use Illuminate\Console\Command;

class WebserverMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webserver:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Health monitoring of webservers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Monitor $service)
    {
        $service->handle();
        return Command::SUCCESS;
    }
}
