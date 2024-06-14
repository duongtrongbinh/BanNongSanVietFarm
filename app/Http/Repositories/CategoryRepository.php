<?php

namespace App\Http\Repositories;

use App\Models\Category;

class CategoryRepository extends Repository
{
    public function getModel()
    {
        return Category::class;
    }

    public function getLatestAll()
    {
        return $this->model->query()->latest('id')->get();
    }
}
