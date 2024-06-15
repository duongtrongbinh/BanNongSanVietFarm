<?php

namespace App\Http\Repositories;

use App\Models\ProductImage;

class ProductImageRepository extends Repository
{
    public function getModel()
    {
        return ProductImage::class;
    }

    public function getLatestAll()
    {
        return $this->model->query()->latest('id')->get();
    }
}
