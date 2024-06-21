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
    
    public function getLatestAllWithRelations($relations  = [])
    {
        return $this->model->with($relations)->latest('id')->get();
    }

    public function getLatestAllWithRelationsPaginate($relations  = [], $perPage)
    {
        return $this->model->with($relations)->latest('id')->paginate($perPage);
    }

    
}

