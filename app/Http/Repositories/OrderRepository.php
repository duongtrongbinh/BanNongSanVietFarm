<?php
namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInterface;
use App\Models\Order;

class OrderRepository extends Repository implements RepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }
}

