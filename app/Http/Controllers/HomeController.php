<?php

namespace App\Http\Controllers;

use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\TagRepository;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    public function home()
    {
        $products = $this->productRepository->getHomeLatestAllWithRelationsPaginate(['brand', 'category'], 8);
        $brands = $this->brandRepository->getLatestAll();
        $categories = $this->categoryRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('products', 'brands', 'categories'));
    }

    public function product($id)
    {   
        $product = Product::with(['brand', 'category', 'tags', 'product_images'])->find($id);
        $products = $this->productRepository->getHomeLatestAllWithRelations(['brand', 'category']);
        $categories = $this->categoryRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('product',  'products', 'categories'));
    }

    public function category($id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        $products = Product::where('category_id', $category->id)->where('is_home', 1)->where('is_active', 1)->latest('id')->paginate(12);

        $categories = $this->categoryRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'products'));
    }

}


