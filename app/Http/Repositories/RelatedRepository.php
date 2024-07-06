<?php

namespace App\Http\Repositories;

use App\Models\Related;

class RelatedRepository extends Repository
{
    public function getModel()
    {
        return Related::class;
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
