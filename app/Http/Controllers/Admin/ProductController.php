<?php

namespace App\Http\Controllers\Admin;

use App\Excel\Exports\ProductsExport;
use App\Excel\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\TagRepository;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductsImportRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';
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

    public function index()
    {
        $products = $this->productRepository->getLatestAllWithRelations(['brand', 'category', 'tags']);

        return view(self::PATH_VIEW . 'index', compact('products'));
    }

    public function create()
    {
        $brands = $this->brandRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $tags = $this->tagRepository->getAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('brands', 'categories', 'tags'));
    }

    public function store(ProductCreateRequest $request)
    {
        $image_ids = explode(',', $request->input('image')[0]);
        $image = array_shift($image_ids);
        $request['image'] = $image;
        $product = $this->productRepository->createWithRelations($request->all(), ['brand', 'category']);

        $newImages = $image_ids;
        if (!empty($newImages)) {
            foreach ($newImages as $newImage) {
                $request['product_id'] = $product->id;
                $request['image'] = $newImage;
                $this->productImageRepository->createWithRelations($request->all(), ['product']);
            }
        }

        $tag_ids = $request->input('tags', []);
        $product->tags()->attach($tag_ids);


        return redirect()
            ->route('products.index')
            ->with('status', 'Success');
    }

    public function show(Product $product)
    {
        $this->productRepository->findOrFail($product->id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('product'));
    }

    public function edit(Product $product)
    {
        $product = Product::with(['brand', 'category', 'tags', 'product_images'])->find($product->id);
        $brands = $this->brandRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $tags = $this->tagRepository->getAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'brands', 'categories', 'tags'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $request['is_active'] = $request->has('is_active');
        $request['is_home'] = $request->has('is_home');
        $image_ids = explode(',', $request->input('image')[0]);
        $image = array_shift($image_ids);
        $request['image'] = $image;
        $product = $this->productRepository->updateWithRelations($product->id, $request->all(), ['brand', 'category']);

        $newImages = $image_ids;
        $product_images = ProductImage::with(['product'])->where('product_id', $product->id)->get();
        if ($product_images != Null) {
            foreach ($product_images as $product_image) {
                $this->productImageRepository->destroy($product_image->id);
            }
        }
        if (!empty($newImages)) {
            foreach ($newImages as $newImage) {
                $request['product_id'] = $product->id;
                $request['image'] = $newImage;
                $this->productImageRepository->createWithRelations($request->all(), ['product']);
            }
        }

        $tag_ids = $request->input('tags', []);
        $product->tags()->sync($tag_ids);

        return redirect()->back()->with('status', 'Success');
    }

    public function delete(Product $product)
    {
        $this->brandRepository->delete($product->id);

        return response()->json(true);
    }

    public function destroy(Product $product)
    {
        $product_images = ProductImage::with(['product'])->where('product_id', $product->id)->get();
        if ($product_images != Null) {
            foreach ($product_images as $product_image) {
                $this->productImageRepository->destroy($product_image->id);
            }
        }
        DB::table('product_tags')->where('product_id', $product->id)->delete();
        $this->productRepository->destroy($product->id);
        
        return response()->json(true);
    }

    public function export() 
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function import(ProductsImportRequest $request) 
    {
        Excel::import(new ProductsImport, $request->file('product_file'));
        
        return redirect()->back()->with('success', 'Products imported successfully.');
    }
}
