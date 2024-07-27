<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Pipelines\PipelineFactory;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\TagRepository;
use App\Models\Category;
use App\Models\Banner;
use App\Http\Requests\StorePostRequest;
use App\Models\Product;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const PATH_VIEW = 'client.';
    protected $productRepository;
    protected $brandRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $productImageRepository;

    protected $pipelineFactory;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository, ProductImageRepository $productImageRepository, PipelineFactory $pipelineFactory)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->productImageRepository = $productImageRepository;

        $this->pipelineFactory = $pipelineFactory;
    }

    public function home()
    {
        $products = $this->productRepository->getHomeLatestAllWithRelationsPaginate(8, ['category']);

        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', 1)
                ->where('is_home', 1)
                ->orderBy('id', 'desc');
        }])->get();

        $categories->each(function ($category) {
            $category->products = $category->products->take(8);
        });

        $banners = Banner::where('is_home', 1)
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->get(['image']);

        $top10Products = Product::with(['comments', 'orderDetails'])
        ->withCount([
            'orderDetails as sales_count' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            },
            'comments as average_rating' => function ($query) {
                $query->select(DB::raw('AVG(ratting)'));
            }
        ])
        ->orderByDesc('sales_count')
        ->orderByDesc('average_rating')
        ->take(10)
        ->get();

        $top6Products = $top10Products->take(6);
        $next4Products = $top10Products->skip(6)->take(4);

        return view(self::PATH_VIEW . __FUNCTION__, compact('products', 'categories','banners', 'top6Products', 'next4Products'));
    }

    public function product($slug)
    {
        $product = Product::with(['brand', 'category', 'tags', 'product_images', 'comments', 'product_related'])
            ->where('slug', $slug)
            ->first();
        $relatedProduct = $product->product_related;

        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'relatedProduct'));
    }

    public function category(Request $request, $slug)
    {
        $searchTerm = $request->filled('search') ? $request->input('search') : null;
        $sort = $request->filled('sort') ? $request->input('sort') : 'newest';
        $brandSlugs = $request->filled('brands') ? $request->input('brands') : [];
        $minPrice = $request->filled('minPrice') > 0 ? $request->input('minPrice') : 0;
        $maxPrice = $request->filled('maxPrice') > 0 ? $request->input('maxPrice') : 0;

        $category = Category::where('slug', $slug)
            ->first();

        $stages = $this->pipelineFactory->make($searchTerm, $brandSlugs, $slug, $minPrice, $maxPrice, [$sort]);

        $productsQuery = Product::query()
            ->with(['brand', 'category'])
            ->where('category_id', $category->id);

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

        return view(self::PATH_VIEW . __FUNCTION__, compact('category', 'brands', 'categories', 'products', 'priceLimits'));
    }


}
