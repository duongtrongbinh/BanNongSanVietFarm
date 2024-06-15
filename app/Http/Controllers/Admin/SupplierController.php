<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierCreateRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Supplier;
use Symfony\Component\HttpFoundation\Response;

class SupplierController extends Controller
{
    protected $supplier;
    
    function __construct(Supplier $supplier){
        $this->supplier = $supplier;
    }
    
    public function index()
    {
        $data = $this->supplier->paginate();
        return view('admin.supplier.index',compact('data'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(SupplierCreateRequest $request)
    {
        $this->supplier->create($request->validated());
        return redirect()->route('supplier.index');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit',compact('supplier'));
    }

    public function update(SupplierUpdateRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());
        return redirect()->route('supplier.index');
    }

    public function destroy(Supplier $supplier)
    {
        try {
                $supplier->delete();
                return $this->responseOk();
            } catch (\Exception $exception) {
                return $this->responseError(Response::HTTP_BAD_REQUEST, $exception->getMessage(), $exception->getLine());
            }
    }
}