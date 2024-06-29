<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository extends Repository
{
    public function getModel()
    {
        return Product::class;
    }

    public function getLatestAll()
    {
        return $this->model->query()->latest('id')->paginate(5);
    }

    public function getLatestAllWithRelations($relations  = [])
    {
        return $this->model->with($relations)->latest('id')->get();
    }

    public function getPaginateLatestAllWithRelations($perPage, $relations  = [])
    {
        return $this->model->with($relations)->latest('id')->paginate($perPage);
    }

    public function getHomeLatestAllWithRelationsPaginate($perPage, $relations  = [])
    {
        return $this->model->with($relations)->where('is_home', 1)->where('is_active', 1)->latest('id')->paginate($perPage);
    }

    public function getHomeLatestAllWithRelations($relations  = [])
    {
        return $this->model->with($relations)->where('is_home', 1)->where('is_active', 1)->latest('id')->get();
    }
}


