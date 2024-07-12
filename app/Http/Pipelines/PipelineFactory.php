<?php 

namespace App\Http\Pipelines;

use App\Http\Pipelines\Stages\Shop\FilterByBrand;
use App\Http\Pipelines\Stages\Shop\FilterByCategory;
use App\Http\Pipelines\Stages\Shop\FilterByPrice;
use App\Http\Pipelines\Stages\Shop\SearchByName;
use App\Http\Pipelines\Stages\Shop\SortByBestSelling;
use App\Http\Pipelines\Stages\Shop\SortByNewest;
use App\Http\Pipelines\Stages\Shop\SortByPriceHighToLow;
use App\Http\Pipelines\Stages\Shop\SortByPriceLowToHigh;

class PipelineFactory
{
    protected $availableStages = [
        'newest' => SortByNewest::class,
        'price_high_low' => SortByPriceHighToLow::class,
        'price_low_high' => SortByPriceLowToHigh::class,
        'best_selling' => SortByBestSelling::class,
    ];

    public function make($searchTerm = null, $brandSlugs = [], $categorySlugs = [], $minPrice = null, $maxPrice = null, $sortOptions = [])
    {
        $stages = [];

        if ($searchTerm) {
            $stages[] = new SearchByName($searchTerm);
        }

        if (!empty($brandSlugs)) {
            $stages[] = new FilterByBrand((array) $brandSlugs);
        }
        
        if (!empty($categorySlugs)) {
            $stages[] = new FilterByCategory((array) $categorySlugs);
        }

        if ($minPrice !== null && $maxPrice !== null) {
            $stages[] = new FilterByPrice($minPrice, $maxPrice);
        }

        foreach ($sortOptions as $option) {
            if (isset($this->availableStages[$option])) {
                $stages[] = app($this->availableStages[$option]);
            }
        }
        
        return $stages;
    }
}
