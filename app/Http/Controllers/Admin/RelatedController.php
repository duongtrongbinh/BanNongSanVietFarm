<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\RelatedRepository;
use App\Models\Product;
use Illuminate\Http\Request;

class RelatedController extends Controller
{
    const PATH_VIEW = 'admin.products.related.';
    protected $relatedRepository;
    protected $productRepository;

    public function __construct(RelatedRepository $relatedRepository, ProductRepository $productRepository)
    {
        $this->relatedRepository = $relatedRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Product $product)
    {
        $related = $product->related()->get();

        return view(self::PATH_VIEW . 'index', compact('product', 'related'));
    }
}
