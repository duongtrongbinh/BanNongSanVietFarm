<?php

namespace App\Http\Controllers\Admin;

use App\Excel\Exports\ProductsExport;
use App\Excel\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductImageRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\RelatedRepository;
use App\Http\Repositories\TagRepository;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductsImportRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
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
    protected $relatedRepository;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository, ProductImageRepository $productImageRepository, RelatedRepository $relatedRepository)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->productImageRepository = $productImageRepository;
        $this->relatedRepository = $relatedRepository;
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
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chi tiết">
                            <a href="'.route('products.show', $product->id).'" class="text-primary d-inline-block">
                                <i class="ri-eye-fill fs-16"></i>
                            </a>
                        </li>
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                            <a href="'.route('products.edit', $product->id).'" class="text-primary d-inline-block">
                                <i class="ri-pencil-fill fs-16"></i>
                            </a>
                        </li>
                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                            <a data-url="'.route('products.delete', $product->id).'" class="text-danger d-inline-block deleteProduct">
                                <i class="ri-delete-bin-5-fill fs-16"></i>
                            </a>
                        </li>
                    </ul>';
        })
        ->rawColumns(['image', 'tags', 'is_active', 'is_home', 'action'])
        ->make(true);
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

        $this->relatedRepository->create(['product_id' => $product->id]);

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

    public function export() 
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function import(ProductsImportRequest $request) 
    {
        $import = new ProductsImport;
        Excel::import($import, $request->file('product_file'));
        
        return redirect()->back()->with('created', 'Thêm mới sản phẩm thành công!');
    }
}