<?php

namespace App\Excel\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('admin.products.products', [
            'products' => Product::latest('id')->get()
        ]);
    }
}
