<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\TagRepository;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    const PATH_VIEW = 'client.';
    protected $productRepository;
    protected $brandRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $productImageRepository;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository, ProductImageRepository $productImageRepository)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->productImageRepository = $productImageRepository;
    }

    public function shop()
    {
        $products = $this->productRepository->getHomeLatestAllWithRelationsPaginate(12, ['brand', 'category']);
        $brands = $this->brandRepository->getLatestAll();
        $categories = $this->categoryRepository->getAllWithRelations('products');

        return view(self::PATH_VIEW . __FUNCTION__, compact('products', 'brands', 'categories'));
    }
}
