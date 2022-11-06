<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebserverRequest;
use App\Repositories\Webserver\WebserverRepository;

class WebserverController extends Controller
{
    protected WebserverRepository $repository;

    public function __construct(WebserverRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function store(WebserverRequest $request)
    {
        return $this->repository->create($request->validated());
    }

    public function show(int $id)
    {
        return $this->repository->getWithRequestHistory($id);
    }

    public function update(int $id, WebserverRequest $request)
    {
        return $this->repository->update($id, $request->validated());
    }

    public function destroy(int $id)
    {
        return $this->repository->destroy($id);
    }
}
