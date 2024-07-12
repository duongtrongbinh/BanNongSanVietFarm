<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Http\Pipelines\Contracts\PipelineStage;

class SortByNewest implements PipelineStage
{
    public function handle($products, \Closure $next)
    {
        $products = $products->orderBy('created_at', 'desc');
        
        return $next($products);
    }
}
