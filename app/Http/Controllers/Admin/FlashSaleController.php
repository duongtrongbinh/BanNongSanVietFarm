<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\FlashSaleProductRepository;
use App\Http\Repositories\FlashSaleRepository;
use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class FlashSaleController extends Controller
{
    public $flashSaleRepository;
    public $flashSaleProductRepository;
    const PATH = 'admin.flash_sale.';

    public function __construct(FlashSaleRepository $flashSaleRepository,FlashSaleProductRepository $flashSaleProductRepository)
    {
         $this->flashSaleRepository = $flashSaleRepository;
         $this->flashSaleProductRepository = $flashSaleProductRepository;
    }
    public function index()
    {
       $flashSale = $this->flashSaleRepository->getAllWithRelations('flashSaleProducts.product');
       return view(self::PATH.'index',compact(['flashSale']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách các sản phẩm đang hoạt động và chưa có trong flash sale
        $products = Product::select('name', 'id', 'price_regular')
            ->where('is_active', 1)
            ->whereDoesntHave('flashSaleProducts')
            ->get();
        return view(self::PATH.'add',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $flash_saleInput = $request->except('product');
        $flash_saleInput['status'] = isset($flash_saleInput['is_active']) ? 1 : 0;
        $products = $request->product;
        try{
            DB::beginTransaction();
            $flash_sale = $this->flashSaleRepository->create($flash_saleInput);
            foreach($products as $key => $value){
                $value['is_active'] = isset($value['is_active']) ? 1 : 0;
                $this->flashSaleProductRepository->create([
                    'flash_sale_id' => $flash_sale->id,
                    'product_id' => $key,
                    'discount' =>  $value['discount'],
                    'quantity' => $value['quantity'],
                    'is_active' => $value['is_active'],
                ]);
            }
            DB::commit();
            return redirect()->back()->withErrors(['success'=> 'create new flash sale success']);
        } catch ( Exception $exception){
            DB::rollBack();
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $flash_sale = $this->flashSaleRepository->findOrFail($id);
        $product_sale =  FlashSaleProduct::with('product')
            ->where('flash_sale_id', $id)
            ->get();
        return view(self::PATH.'show',compact(['flash_sale','product_sale']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $flash_sale = $this->flashSaleRepository->findOrFail($id);
        $product_sale =  FlashSaleProduct::with('product')
            ->where('flash_sale_id', $id)
            ->get();
        $products = Product::select('name', 'id', 'price_regular')
            ->where('is_active', 1)
            ->whereDoesntHave('flashSaleProducts')
            ->get();
        return view(self::PATH.'edit',compact(['products','flash_sale','product_sale']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $flash_saleInput = $request->except('product');
        $flash_saleInput['status'] = isset($flash_saleInput['is_active']) ? 1 : 0;
        $products = $request->product;
        $request_product_id = [];
        $saleData = FlashSaleProduct::with('flashSale')
            ->where('flash_sale_id',$id)
            ->get();

        try{
            DB::beginTransaction();
            $this->flashSaleRepository->update($id,$flash_saleInput);
            foreach ($products as $key => $value) {
                $request_product_id[] = $key;
                $productExists = false;
                foreach ($saleData as $items2) {
                    if ($items2['product_id'] == $key) {
                        $productExists = true;
                        $this->flashSaleProductRepository->updateFlashSale($id, $key, [
                            'discount' => $value['discount'],
                            'quantity' => $value['quantity'],
                            'is_active' => isset($value['is_active']) ? $value['is_active'] : 0,
                        ]);
                        break;
                    }
                }
                if (!$productExists) {
                    $this->flashSaleProductRepository->create([
                        'flash_sale_id' => $id,
                        'product_id' => $key,
                        'discount' => $value['discount'],
                        'quantity' => $value['quantity'],
                        'is_active' => isset($value['is_active']) ? $value['is_active'] : 0,
                    ]);
                }
            }
            // Lấy danh sách các product_id hiện có trong CSDL cho flash_sale_id
            $existingProducts = FlashSaleProduct::where('flash_sale_id', $id)
                ->pluck('product_id')
                ->toArray();
            // Tìm các product_id thừa trong CSDL (có trong CSDL nhưng không có trong request)
            $productsToDelete = array_diff($existingProducts, $request_product_id);
            // Xóa các bản ghi thừa trong CSDL
            if (!empty($productsToDelete)) {
                FlashSaleProduct::where('flash_sale_id',$id)
                    ->whereIn('product_id', $productsToDelete)
                    ->delete();
            }
            DB::commit();
            return redirect()->back()->withErrors(['success'=> 'Update flash sale success']);
        } catch ( Exception $exception){
            DB::rollBack();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
