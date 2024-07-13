<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Models\Category;
use Closure;

class FilterByCategory
{
    protected $categorySlugs;

    public function __construct($categorySlugs)
    {
        $this->categorySlugs = $categorySlugs;
    }

    public function handle($products, Closure $next)
    {
        if (!empty($this->categorySlugs)) {
            $categoryIds = Category::whereIn('slug', $this->categorySlugs)->pluck('id');
            $products->whereIn('category_id', $categoryIds);
        }

        return $next($products);
    }
}
