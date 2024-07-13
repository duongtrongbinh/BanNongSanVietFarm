<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\GroupRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    const PATH_VIEW = 'admin.groups.';
    protected $groupRepository;
    protected $productRepository;

    public function __construct(GroupRepository $groupRepository, ProductRepository $productRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $groups = $this->groupRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('groups'));
    }

    public function create()
    {
        $products = $this->productRepository->getLatestAllWithRelations(['brand', 'category', 'tags']);

        return view(self::PATH_VIEW . __FUNCTION__, compact('products'));
    }

    public function getProduct(Request $request)
    {
        $products = Product::with(['brand', 'category', 'tags'])->find($request->id);

        return response()->json($products);
    }

    public function store(GroupCreateRequest $request)
    {
        $group = $this->groupRepository->create($request->all());
        
        $product_ids = $request->input('products', []);
        $group->products()->attach($product_ids);

        return redirect()
            ->route('groups.index')
            ->with('created', 'Thêm mới nhóm sản phẩm thành công!');
    }

    public function edit(Group $group)
    {
        $products = $this->productRepository->getLatestAllWithRelations(['brand', 'category', 'tags']);

        return view(self::PATH_VIEW . __FUNCTION__, compact('group', 'products'));
    }

    public function update(GroupUpdateRequest $request, Group $group)
    {
        $group = $this->groupRepository->update($group->id, $request->all());
        
        $product_ids = $request->input('products', []);
        $group->products()->sync($product_ids);

        return redirect()
            ->back()
            ->with('updated', 'Cập nhật nhóm sản phẩm thành công!');
    }

    public function delete(Group $group)
    {
        $this->groupRepository->delete($group->id);

        return response()->json(true);
    }

    public function destroy(Group $group)
    {
        $this->groupRepository->destroy($group->id);

        return response()->json(true);
    }
}
