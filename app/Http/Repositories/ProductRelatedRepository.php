<?php

namespace App\Http\Repositories;

use App\Models\ProductRelated;

class ProductRelatedRepository extends Repository
{
    public function getModel()
    {
        return ProductRelated::class;
    }

    public function getLatestAll()
    {
        return $this->model->query()->latest('id')->get();
    }
    
    public function getLatestAllWithRelations($relations  = [])
    {
        return $this->model->with($relations)->latest('id')->get();
    }
}
