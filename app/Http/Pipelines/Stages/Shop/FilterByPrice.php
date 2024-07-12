<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Http\Pipelines\Contracts\PipelineStage;

class FilterByPrice implements PipelineStage
{
    protected $minPrice;
    protected $maxPrice;

    public function __construct($minPrice, $maxPrice)
    {
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function handle($products, \Closure $next)
    {
        if ($this->minPrice && $this->maxPrice) {
            $products = $products->whereBetween('price_sale', [$this->minPrice, $this->maxPrice]);
        } elseif ($this->minPrice) {
            $products = $products->where('price_sale', '>=', $this->minPrice);
        } elseif ($this->maxPrice) {
            $products = $products->where('price_sale', '<=', $this->maxPrice);
        }

        return $next($products);
    }
}
