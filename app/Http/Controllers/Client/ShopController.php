<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Pipelines\PipelineFactory;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductRepository;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class ShopController extends Controller
{
    const PATH_VIEW = 'client.';
    protected $productRepository;
    protected $brandRepository;
    protected $categoryRepository;

    protected $pipelineFactory;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository, PipelineFactory $pipelineFactory)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;

        $this->pipelineFactory = $pipelineFactory;
    }

    public function shop(Request $request)
    {
        $searchTerm = $request->filled('search') ? $request->input('search') : null;
        $sort = $request->filled('sort') ? $request->input('sort') : 'newest';
        $brandSlugs = $request->filled('brands') ? $request->input('brands') : [];
        $categorySlugs = $request->filled('categories') ? $request->input('categories') : [];
        $minPrice = $request->filled('minPrice') > 0 ? $request->input('minPrice') : 0;
        $maxPrice = $request->filled('maxPrice') > 0 ? $request->input('maxPrice') : 0;

        $productsQuery = $this->productRepository->getQueryRelations(['category']);

        $stages = $this->pipelineFactory->make($searchTerm, $brandSlugs, $categorySlugs, $minPrice, $maxPrice, [$sort]);

        $products = app(Pipeline::class)
            ->send($productsQuery)
            ->through($stages)
            ->thenReturn()
            ->where('is_active', 1)
            ->latest('id')
            ->paginate(12);
        
        $brands = $this->brandRepository->getAllWithRelations('products');
        $categories = $this->categoryRepository->getAllWithRelations('products');

        $priceLimits = Product::where('is_active', 1)
                        ->selectRaw('MIN(price_sale) as min_price, MAX(price_sale) as max_price')
                        ->first();

        return view(self::PATH_VIEW . __FUNCTION__, compact('products', 'brands', 'categories', 'priceLimits'));
    }

    public function brand(Request $request, $slug)
    {
        $searchTerm = $request->filled('search') ? $request->input('search') : null;
        $sort = $request->filled('sort') ? $request->input('sort') : 'newest';
        $brandSlugs = $request->filled('brands') ? $request->input('brands') : [];
        $categorySlugs = $request->filled('categories') ? $request->input('categories') : [];
        $minPrice = $request->filled('minPrice') > 0 ? $request->input('minPrice') : 0;
        $maxPrice = $request->filled('maxPrice') > 0 ? $request->input('maxPrice') : 0;

        $brand = Brand::where('slug', $slug)
                    ->first();

        $productsQuery = Product::query()
                            ->with(['brand', 'category'])
                            ->where('brand_id', $brand->id);

        $stages = $this->pipelineFactory->make($searchTerm, $brandSlugs, $categorySlugs, $minPrice, $maxPrice, [$sort]);

        $products = app(Pipeline::class)
            ->send($productsQuery)
            ->through($stages)
            ->thenReturn()
            ->where('is_active', 1)
            ->latest('id')
            ->paginate(12);

        $brands = $this->brandRepository->getLatestAll();
        $categories = $this->categoryRepository->getAllWithRelations('products');

        $priceLimits = Product::where('is_active', 1)
                        ->selectRaw('MIN(price_sale) as min_price, MAX(price_sale) as max_price')
                        ->first();

        return view(self::PATH_VIEW . __FUNCTION__, compact('brand', 'brands', 'categories', 'products', 'priceLimits'));
    }
}
