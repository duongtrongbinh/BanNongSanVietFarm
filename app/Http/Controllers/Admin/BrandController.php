<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\BrandCreateRequest;
use App\Models\Brand;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    const PATH_VIEW = 'admin.brands.';
    protected $brandRepository;
    protected $productRepository;
    protected $productImageRepository;

    public function __construct(BrandRepository $brandRepository, ProductRepository $productRepository, ProductImageRepository $productImageRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
    }

    public function index(Brand $brand)
    {
        $brands = $this->brandRepository->getAllWithRelations(['products']);

        return view(self::PATH_VIEW . __FUNCTION__, compact('brands'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function store(BrandCreateRequest $request)
    {   
        $request['slug'] = Str::slug($request['name']);
        $this->brandRepository->create($request->all());

        return redirect()
            ->route('brands.index')
            ->with('status', 'Success');
    }

    public function show(Brand $brand)
    {
        $this->brandRepository->findOrFail($brand->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('brand'));
    }

    public function edit(Brand $brand)
    {
        $this->brandRepository->findOrFail($brand->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('brand'));
    }

    public function update(BrandCreateRequest $request, Brand $brand)
    {
        $this->brandRepository->update($brand->id, $request->validated());

        return back()
            ->with('status', 'Success');
    }

    public function delete(Brand $brand)
    {
        $this->brandRepository->delete($brand->id);

        return response()->json(true);
        
    }

    public function destroy(Brand $brand)
    {
        $this->brandRepository->destroy($brand->id);

        return response()->json(true);
    }
}
