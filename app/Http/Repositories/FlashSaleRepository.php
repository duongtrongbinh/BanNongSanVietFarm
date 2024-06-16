<?php

namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInterface;
use App\Models\FlashSale;

class FlashSaleRepository extends Repository implements RepositoryInterface
{
    public function getModel()
    {
        return FlashSale::class;
    }



}
