<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\TagRepository;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Models\Product;
use App\Models\Post;

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
        $products = $this->productRepository->getHomeLatestAllWithRelationsPaginate(8, ['brand', 'category']);
        $categories = $this->categoryRepository->getLatestAllWithRelations(['products']);

        return view(self::PATH_VIEW . __FUNCTION__, compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::with(['brand', 'category', 'tags', 'product_images', 'comments', 'product_related'])
                    ->where('slug', $slug)
                    ->first();
        $relatedProduct = $product->product_related;

        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'relatedProduct'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
                        ->first();
        $products = Product::where('category_id', $category->id)
                        ->where('is_active', 1)
                        ->latest('id')
                        ->paginate(12);
        $categories = $this->categoryRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('category', 'categories', 'products'));
    }

    public function post()
    {
        $posts = Post::query()->get();

        return view('client.post', compact('posts'));
    }
    
    public function store(StorePostRequest $request)
    {
        $data = $request->except('image');
        $data['image'] = $request->input('image');
        $post = Post::create($data);
        
        return redirect()->route('post');
    }
}