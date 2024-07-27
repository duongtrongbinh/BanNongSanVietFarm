<?php

namespace App\Http\Controllers\Admin;

use App\Excel\Exports\ProductsExport;
use App\Excel\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\ProductRelatedRepository;
use App\Http\Repositories\TagRepository;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductsImportRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductRelated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';
    protected $productRepository;
    protected $brandRepository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $productImageRepository;
    protected $productRelatedRepository;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository, ProductImageRepository $productImageRepository, ProductRelatedRepository $productRelatedRepository)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->productImageRepository = $productImageRepository;
        $this->productRelatedRepository = $productRelatedRepository;
    }

    public function index()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function getData()
    {
        $products = $this->productRepository->getLatestAllWithRelations(['brand', 'category', 'tags']);

        $stt = 1;

        return DataTables::of($products)
        ->addColumn('stt', function ($product) use (&$stt) {
            return $stt++;
        })
        ->addColumn('image', function($product) {
            return '<img src="'. asset($product->image) .'" width="100px"/>';
        })
        ->addColumn('brand', function($product) {
            return $product->brand ? $product->brand->name : 'N/A';
        })
        ->addColumn('category', function($product) {
            return $product->category ? $product->category->name : 'N/A';
        })
        ->addColumn('tags', function($product) {
            return $product->tags->pluck('name')->implode('<br>');
        })
        ->addColumn('price_regular', function($product) {
            return number_format($product->price_regular) . ' VNĐ';
        })
        ->addColumn('price_sale', function($product) {
            return number_format($product->price_sale) . ' VNĐ';
        })
        ->addColumn('is_home', function($product) {
            return $product->is_home ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>';
        })
        ->addColumn('is_active', function($product) {
            return $product->is_active ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>';
        })
        ->addColumn('action', function($product) {
            return '<ul class="list-inline hstack gap-2 mb-0">
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                            <a href="'.route('products.edit', $product->id).'" class="text-primary d-inline-block">
                                <i class="ri-pencil-fill fs-16"></i>
                            </a>
                        </li>
                    </ul>';
        })
        ->rawColumns(['image', 'tags', 'is_active', 'is_home', 'action'])
        ->make(true);
    }

    public function getProduct(Request $request)
    {
        $products = Product::with(['brand', 'category', 'tags'])->find($request->id);

        return response()->json($products);
    }

    public function create()
    {
        $products = $this->productRepository->getAll();
        $brands = $this->brandRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $tags = $this->tagRepository->getAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('products', 'brands', 'categories', 'tags'));
    }

    public function getProductsByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        // Lấy sản phẩm theo category_id
        $products = Product::where('category_id', $categoryId)->get(['id', 'name', 'image', 'price_sale']);

        return response()->json($products);
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

        $product_ids = $request->input('products', []);
        if (!empty($product_ids)) {
            foreach ($product_ids as $product_related_id) {
                $request['product_id'] = $product->id;
                $request['product_related_id'] = $product_related_id;
                $this->productRelatedRepository->createWithRelations($request->all(), ['product']);
            }
        }
        
        return redirect()
            ->route('products.index')
            ->with('created', 'Thêm mới sản phẩm thành công!');
    }

    public function show(Product $product)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('product'));
    }

    public function edit(Product $product)
    {
        $product = Product::with(['brand', 'category', 'tags', 'product_related.products'])->find($product->id);
        $relatedProduct = $product->product_related;
        $products = $this->productRepository->getAll();
        $brands = $this->brandRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $tags = $this->tagRepository->getAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'relatedProduct', 'products', 'brands', 'categories', 'tags'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $request['is_active'] = $request->has('is_active');
        $request['is_home'] = $request->has('is_home');
        $image_ids = explode(',', $request->input('image')[0]);
        $image = array_shift($image_ids);
        $request['image'] = $image;
        $product = $this->productRepository->updateWithRelations($product->id, $request->all(), ['brand', 'category']);

        $product_images = ProductImage::with(['product'])->where('product_id', $product->id)->get();
        if ($product_images != Null) {
            foreach ($product_images as $product_image) {
                $this->productImageRepository->destroy($product_image->id);
            }
        }

        $newImages = $image_ids;
        if (!empty($newImages)) {
            foreach ($newImages as $newImage) {
                $request['product_id'] = $product->id;
                $request['image'] = $newImage;
                $this->productImageRepository->createWithRelations($request->all(), ['product']);
            }
        }

        $tag_ids = $request->input('tags', []);
        $product->tags()->sync($tag_ids);

        $product_relateds = ProductRelated::with(['products'])->where('product_id', $product->id)->get();
        if ($product_relateds != Null) {
            foreach ($product_relateds as $product_related) {
                $product_related->forceDelete();
            }
        }

        $product_ids = $request->input('products', []);
        if (!empty($product_ids)) {
            foreach ($product_ids as $product_related_id) {
                $request['product_id'] = $product->id;
                $request['product_related_id'] = $product_related_id;
                $this->productRelatedRepository->createWithRelations($request->all(), ['product']);
            }
        }

        return redirect()
            ->back()
            ->with('updated', 'Cập nhật sản phẩm thành công!');
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

    public function export(Request $request) 
    {   
        $paginate = $request->input('paginate', 10);

        $export = new ProductsExport($paginate);

        return Excel::download($export, 'products.xlsx');
    }

    public function import(ProductsImportRequest $request) 
    {
        $file = $request->file('product_file');
        $import = new ProductsImport($file);

        Excel::import($import, $file);
            
        return redirect()->back()->with('created', 'Thêm mới sản phẩm thành công!');
    }
}