<?php
namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInterface;
use App\Models\OrderHistory;

class OrderHistoryRepository extends Repository implements RepositoryInterface
{
    public function getModel()
    {
        return OrderHistory::class;
    }
    
    public function getLatestAllWithRelations($relations  = [])
    {
        return $this->model->with($relations)->latest('id')->get();
    }

    public function getLatestAllWithRelationsPaginate($perPage, $relations  = [])
    {
        return $this->model->with($relations)->latest('id')->paginate($perPage);
    }
}

