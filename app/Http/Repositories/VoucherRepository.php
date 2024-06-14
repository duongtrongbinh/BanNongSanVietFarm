<?php
namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInteface;
use App\Models\Voucher;

class VoucherRepository extends Repository implements RepositoryInteface
{
    public function getModel()
    {
        return Voucher::class;
    }

    public function getVoucherActive()
    {
        return Voucher::select('title','id')->where('is_active','=',1)
            ->get();
    }

    public function listDeletedSoft()
    {
        return Voucher::onlyTrashed()->get();
    }


}
