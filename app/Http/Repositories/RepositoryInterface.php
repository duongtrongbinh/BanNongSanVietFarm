<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function getAll(): Collection;
    public function getPaginate(array $params): LengthAwarePaginator;
    public function findOrFail(int $id): Model;
    public function create(array $array): Model;
    public function update(int $id, array $array): Model;
    public function destroy(int|array $id): int;
    public function restore(int|array $id): bool;
    public function getAllWithRelations(array $relations): Collection;
    public function getWithRelationId(int $id, $relations  = []);
    public function updateWithRelations($id, array $data, array $relations = []): Model;
    public function createWithRelations(array $data, array $relations = []): Model;
    
}