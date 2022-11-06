<?php

namespace App\Repositories\Webserver;

use App\Models\WebserverRequestHistory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RequestHistoryRepository extends BaseRepository
{
    protected Model $model;

    public function __construct(WebserverRequestHistory $model)
    {
        $this->model = $model;
    }

    public function getRequestHistoryBy(int $webserverId)
    {
        return $this->getModel()
            ->where('webserver_id', $webserverId)
            ->orderBy('id', 'desc')
            ->get();
    }
}
