<?php

namespace App\DTO;

class WebserverRequestDTO
{
    private int $status;
    private int $response_at;

    public function __construct(
        int $status,
        int $response_at
    )
    {
        $this->status      = $status;
        $this->response_at = $response_at;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getResponseAt(): int
    {
        return $this->response_at;
    }
}
