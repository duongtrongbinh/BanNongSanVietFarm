<?php
namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInteface;
use App\Models\Order;

class OrderRepository extends Repository implements RepositoryInteface
{
    public function getModel()
    {
        return Order::class;
    }
}

