<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Http\Pipelines\Contracts\PipelineStage;

class SortByPriceLowToHigh implements PipelineStage
{
    public function handle($products, \Closure $next)
    {
        $products = $products->orderBy('price_sale', 'asc');
        
        return $next($products);
    }
}
