<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Http\Pipelines\Contracts\PipelineStage;

class SortByPriceHighToLow implements PipelineStage
{
    public function handle($products, \Closure $next)
    {
        $products = $products->orderBy('price_sale', 'desc');
        
        return $next($products);
    }
}

