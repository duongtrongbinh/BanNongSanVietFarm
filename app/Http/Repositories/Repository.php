<?php

namespace App\Http\Repositories;

use App\Http\Repositories\RepositoryInteface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInteface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel(): void
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function getPaginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();
        if (isset($params['keyword'])) {
            $query->where('name', 'like', '%' . $params['keyword'] . '%');
        }
        if (isset($params['trashed'])) {
            $query->onlyTrashed();
        }
        return $query->paginate();
    }

    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): Model
    {
        $model = $this->model->find($id);
        $model->update($attributes);
        return $model;
    }

    public function destroy(int|array $id): int
    {
        return $this->model->destroy($id);
    }

    public function restore(int|array $id): bool
    {
        return $this->model->onlyTrashed()->whereIn('id', is_array($id) ? $id : [$id])->restore();
    }
}
