<?php
namespace App\Http\Repositories;
use App\Http\Repositories\RepositoryInterface;
use App\Models\Voucher;

class VoucherRepository extends Repository implements RepositoryInterface
{
    public function getModel()
    {
        return Voucher::class;
    }

    public function applicableLimitVoucher($total)
    {
        return Voucher::query()->where('is_active','=',1)
            ->where('applicable_limit', '<=', $total)
            ->get();
    }

    public function listDeletedSoft()
    {
        return Voucher::onlyTrashed()->get();
    }


}
