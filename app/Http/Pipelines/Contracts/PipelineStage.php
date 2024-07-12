<?php

namespace App\Http\Pipelines\Contracts;

interface PipelineStage
{
    public function handle($products, \Closure $next);
}
