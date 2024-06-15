<?php

namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel(): void
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function getPaginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();
        if (isset($params['keyword'])) {
            $query->where('name', 'like', '%' . $params['keyword'] . '%');
        }
        if (isset($params['trashed'])) {
            $query->onlyTrashed();
        }
        return $query->paginate();
    }

    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }


    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): Model
    {
        $model = $this->model->find($id);
        $model->update($attributes);
        return $model;
    }

    public function delete(int|array $id): int
    {
        return $this->model->delete($id);
    }

    public function destroy(int|array $id): int
    {
        return $this->model->destroy($id);
    }

    public function restore(int|array $id): bool
    {
        return $this->model->onlyTrashed()->whereIn('id', is_array($id) ? $id : [$id])->restore();
    }

    public function getAllWithRelations($relations  = []): Collection
    {
        return $this->model->with($relations)->get();
    }

    public function getWithRelationId($id, $relations  = []): Collection
    {
        return $this->model->with($relations)->find($id);
    }

    public function createWithRelations(array $data, array $relations = []): Model
    {
        // Extract related data from the main data array
        $relatedData = [];
        foreach ($relations as $relation) {
            if (isset($data[$relation])) {
                $relatedData[$relation] = $data[$relation];
                unset($data[$relation]);
            }
        }

        // Create the main model
        $model = $this->model->create($data);

        // Attach related models if there are any
        foreach ($relatedData as $relation => $items) {
            $model->$relation()->attach($items);
        }

        return $model->load($relations); // Load the relations to return the full object with relationships
    }


    public function updateWithRelations($id, array $data, array $relations = []): Model
    {
        // Tìm model chính
        $model = $this->model->findOrFail($id);

        // Trích xuất dữ liệu liên quan từ mảng dữ liệu chính
        $relatedData = [];
        foreach ($relations as $relation) {
            if (isset($data[$relation])) {
                $relatedData[$relation] = $data[$relation];
                unset($data[$relation]);
            }
        }

        // Cập nhật model chính
        $model->update($data);

        // Cập nhật các model liên quan nếu có
        foreach ($relatedData as $relation => $items) {
            // Đảm bảo phương thức liên quan được định nghĩa
            if (method_exists($model, $relation)) {
                // Lấy tất cả các bản ghi liên quan hiện tại và xóa chúng
                $model->$relation()->delete();

                // Tạo các bản ghi liên quan mới
                $model->$relation()->createMany($items);
            }
        }

        return $model->load($relations); // Tải các mối quan hệ để trả về đối tượng đầy đủ với các mối quan hệ
    }

    // Tạo một bài viết mới với các thẻ
    // $postData = [
    //     'title' => 'Bài viết mới',
    //     'content' => 'Nội dung bài viết',
    //     'tags' => [1, 2, 3] // ID của các thẻ
    // ];

    // $post = $postRepository->createWithRelations($postData, ['tags']);

    // Cập nhật một bài viết hiện có với các thẻ mới
    // $updateData = [
    //     'title' => 'Tiêu đề bài viết đã cập nhật',
    //     'tags' => [2, 3, 4] // ID của các thẻ mới
    // ];

    // $updatedPost = $postRepository->updateWithRelations($postId, $updateData, ['tags']);


}
