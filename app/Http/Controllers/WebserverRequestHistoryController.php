<?php

namespace App\Http\Controllers;

use App\Repositories\Webserver\RequestHistoryRepository;

class WebserverRequestHistoryController extends Controller
{
    protected RequestHistoryRepository $repository;

    public function __construct(RequestHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function requestHistory(int $webSocketId)
    {
        return $this->repository->getRequestHistoryBy($webSocketId);
    }
}
