<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TypeUnitEnum;
use App\Excel\Imports\PurchaseReceiptImport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseReceipt;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseReceiptController extends Controller
{
    public function create()
    {
        $suppliers = Supplier::all();
        $product = Product::get();
        return view('admin.purchase_receipt.create', compact('product', 'suppliers'));
    }

    public function store(Request $request)
    {
        // Lấy thông tin từ request
        $supplierId = $request->input('supplier');
        $referenceCode = $request->input('reference_code');
        $productData = json_decode($request->input('productData'), true);

        // Lấy đối tượng Supplier
        $supplier = Supplier::find($supplierId);

        // Lặp qua dữ liệu sản phẩm và thêm vào bảng trung gian
        foreach ($productData as $data) {
            $productId = $data['product_id'];
            $quantity = $data['quantity'];
            $typeUnit = TypeUnitEnum::CHAI;
            $end_date = $data['end_date'];

            // Sử dụng attach để thêm dữ liệu vào bảng trung gian
            $supplier->products()->attach($productId, [
                'reference_code' => $referenceCode,
                'quantity' => $quantity,
                'type_unit' => $typeUnit,
                'end_date' =>  $end_date,
                'start_date' => now(),
                'order_code' => str()->uuid(),
                'cost' => 10000,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
        }
            return redirect()->route('purchase_receipt.index');
    }

    public function index()
    {
         $purchaseReceipts = PurchaseReceipt::with('supplier')
            ->select('reference_code', 'supplier_id', DB::raw('COUNT(DISTINCT product_id) as product_count'), DB::raw('SUM(quantity * cost) as total'))
            ->whereNotNull('reference_code')
            ->groupBy('reference_code', 'supplier_id')
            ->paginate(10);

        return view('admin.purchase_receipt.index', compact('purchaseReceipts'));
    }

    public function import(Request $request)
    {
        Excel::import(new PurchaseReceiptImport, $request->file('purchase_file'));

        return redirect()->back()->with('success', 'Purchases imported successfully.');
    }

}
