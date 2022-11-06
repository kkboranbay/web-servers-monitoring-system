<?php

namespace App\Services\Webserver;

use App\DTO\WebserverRequestDTO;
use App\Enums\WebserverStatus;
use App\Jobs\SendAlertEmail;
use App\Models\Webserver;
use App\Models\WebserverRequestHistory;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Carbon;

class Updater
{
    const HEALTHY_CASE   = 5;
    const UNHEALTHY_CASE = 3;

    private Webserver $webserver;
    private WebserverRequestDTO $requestDTO;

    public function __construct(Webserver $webserver, WebserverRequestDTO $requestDTO)
    {
        $this->webserver  = $webserver;
        $this->requestDTO = $requestDTO;
    }

    public function handle()
    {
        $this->recordRequestHistory();
        $this->updateWebserverStatus();
    }

    private function recordRequestHistory()
    {
        WebserverRequestHistory::create([
            'webserver_id' => $this->webserver->id,
            'status'       => $this->requestDTO->getStatus(),
            'response_at'  => Carbon::createFromFormat('U', $this->requestDTO->getResponseAt())
        ]);
    }

    private function updateWebserverStatus()
    {
        $requests = WebserverRequestHistory::where('webserver_id', $this->webserver->id)
            ->orderBy('response_at', 'desc')
            ->take(self::HEALTHY_CASE)
            ->get();

        $statusesCount = $requests->countBy('status');

        if (!empty($statusesCount[WebserverStatus::labels()[WebserverStatus::HEALTHY]])
            && $statusesCount[WebserverStatus::labels()[WebserverStatus::HEALTHY]] === self::HEALTHY_CASE) {

            $this->webserver->update([
                'status' => WebserverStatus::HEALTHY
            ]);

            return;
        }

        $requests = WebserverRequestHistory::where('webserver_id', $this->webserver->id)
            ->orderBy('response_at', 'desc')
            ->take(self::UNHEALTHY_CASE)
            ->get();

        $statusesCount = $requests->countBy('status');

        if (!empty($statusesCount[WebserverStatus::labels()[WebserverStatus::UNHEALTHY]])
            && $statusesCount[WebserverStatus::labels()[WebserverStatus::UNHEALTHY]] === self::UNHEALTHY_CASE) {

            $this->webserver->update([
                'status' => WebserverStatus::UNHEALTHY
            ]);

            SendAlertEmail::dispatch($this->webserver);
        }
    }
}
