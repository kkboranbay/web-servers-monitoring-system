<?php

namespace App\Repositories\Webserver;

use App\Models\Webserver;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WebserverRepository extends BaseRepository
{
    protected Model $model;

    public function __construct(Webserver $model)
    {
        $this->model = $model;
    }

    public function getByProtocol(string $protocol): Collection
    {
        return $this->getModel()->where('protocol', $protocol)->get();
    }

    public function getWithRequestHistory(int $id)
    {
        return $this->getModel()
            ->with(['webserverRequestHistory' => function($query) {
                $query->orderBy('id', 'desc')->take(10);
            }])->findOrFail($id);
    }
}
