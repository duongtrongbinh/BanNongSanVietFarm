<?php

namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInteface;
use App\Models\FlashSaleProduct;

class FlashSaleProductRepository extends Repository implements RepositoryInteface
{
    public function getModel()
    {
        return FlashSaleProduct::class;
    }

    public function updateFlashSale($flash_sale_id, $product_id, $data)
    {
        return FlashSaleProduct::where('flash_sale_id', $flash_sale_id)
            ->where('product_id', $product_id)
            ->update($data);
    }

}

