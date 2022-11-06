<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Model $model;

    public function getModel()
    {
        return $this->model;
    }

    public function getTable()
    {
        return $this->model->getTable();
    }

    public function getConnection()
    {
        return $this->model->getConnection();
    }

    public function all()
    {
        return $this->getModel()->get();
    }

    public function paginated($paginate = 30)
    {
        return $this
            ->getModel()
            ->paginate($paginate);
    }

    public function getColumns()
    {
        return  $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getModel()->getTable());
    }

    public function prepareData(array $data): array
    {
        $columns = $this->getColumns();
        $columns = array_flip($columns);

        return array_intersect_key($data, $columns);
    }

    public function create(array $input)
    {
        $data = $this->prepareData($input);
        return $this->getModel()->create($data);
    }

    public function find($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    public function destroy($id)
    {
        return $this->find($id)->delete();
    }

    public function update($id, array $input)
    {
        $model = $this->find($id);
        $model->update($input);
        return $model;
    }
}
