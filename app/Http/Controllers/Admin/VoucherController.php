<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use  App\Http\Requests\VoucherRequest;
use App\Http\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Log;


class VoucherController extends Controller
{
    public $voucherRepository;

    const PATH = 'admin.voucher.';

    public function __construct(VoucherRepository $voucherRepository)
    {
         $this->voucherRepository = $voucherRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $params = [];

        $vouchers = $this->voucherRepository->getPaginate($params);

        return view(self::PATH.'index',compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VoucherRequest $request)
    {
       $this->voucherRepository->create($request->validated());

       return redirect()->route('vouchers.index')->with('created', 'Thêm mới mã giảm giá thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $voucher = $this->voucherRepository->findOrFail($id);
        return view(self::PATH.'show',compact('voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $voucher = $this->voucherRepository->findOrFail($id);
        return view(self::PATH.'edit',compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VoucherRequest $request, string $id)
    {
        $this->voucherRepository->update($id,$request->validated());
        return redirect()->route('vouchers.index')->with('updated','Sửa mã giảm giá thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
       $voucherDeleted =  $voucher->delete();
        try {
            return response()->json($voucherDeleted, 200);
        } catch (\Exception $exception) {
            Log::error("message: " . $exception->getMessage());
            return response()->json(false, 500);
        }
    }

    public function deleted()
    {
       $vouchers = $this->voucherRepository->listDeletedSoft();
       return view(self::PATH.'deleted',compact('vouchers'));
    }

    public function restore(int $id)
    {
        $voucherRestore =  $this->voucherRepository->restore($id);
        try {
            return response()->json($voucherRestore, 200);
        } catch (\Exception $exception) {
            Log::error("message: " . $exception->getMessage());
            return response()->json(false, 500);
        }
    }


}
