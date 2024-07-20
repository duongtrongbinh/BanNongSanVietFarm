<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Models\Brand;
use Closure;

class FilterByBrand
{
    protected $brandSlugs;

    public function __construct($brandSlugs)
    {
        $this->brandSlugs = $brandSlugs;
    }

    public function handle($products, Closure $next)
    {
        if (!empty($this->brandSlugs)) {
            $brandIds = Brand::whereIn('slug', $this->brandSlugs)->pluck('id');
            $products->whereIn('brand_id', $brandIds);
        }

        return $next($products);
    }

}
