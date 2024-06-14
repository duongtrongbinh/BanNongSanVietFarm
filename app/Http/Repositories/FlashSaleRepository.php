<?php

namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInteface;
use App\Models\FlashSale;

class FlashSaleRepository extends Repository implements RepositoryInteface
{
    public function getModel()
    {
        return FlashSale::class;
    }



}
