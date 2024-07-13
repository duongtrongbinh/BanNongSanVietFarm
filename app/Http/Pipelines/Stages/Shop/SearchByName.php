<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Http\Pipelines\Contracts\PipelineStage;

class SearchByName implements PipelineStage
{
    protected $searchTerm;

    public function __construct($searchTerm)
    {
        $this->searchTerm = $searchTerm;
    }

    public function handle($products, \Closure $next)
    {
        if ($this->searchTerm) {
            $products = $products->where('name', 'like', '%'.$this->searchTerm.'%');
        }

        return $next($products);
    }
}
