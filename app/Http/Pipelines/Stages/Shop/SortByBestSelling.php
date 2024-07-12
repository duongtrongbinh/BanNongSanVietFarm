<?php

namespace App\Http\Pipelines\Stages\Shop;

use App\Http\Pipelines\Contracts\PipelineStage;
use Illuminate\Support\Facades\DB;

class SortByBestSelling implements PipelineStage
{
    public function handle($products, \Closure $next)
    {
        $products = $products->withCount(['orderDetails' => function($query) {
            $query->select(DB::raw('count(order_details.id)'));
        }])->orderBy('order_details_count', 'desc');

        return $next($products);
    }
}
