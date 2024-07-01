<?php

namespace App\Excel\Imports;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class PurchaseReceiptImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $supplier = Supplier::find($row['nha_cung_cap']);
            $supplier->products()->attach($row['san_pham'], [
                'reference_code' => $row['reference'],
                'quantity' => $row['so_luong'],
                'type_unit' => $row['type'],
                'end_date' => $row['ngay_het_han'],
                'start_date' => now(),
                'order_code' => str()->uuid(),
                'cost' => $row['gia'],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $rowIndex = $failure->row();
            $errors = $failure->errors();

            Log::error('Row ' . $rowIndex . ' import failed: ' . json_encode($errors));
            // Lưu lỗi để hiển thị sau này nếu cần thiết
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}