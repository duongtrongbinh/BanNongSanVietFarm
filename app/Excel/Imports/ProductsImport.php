<?php

namespace App\Excel\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProductsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    protected $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Product::create([
                'name' => $row['ten_san_pham'],
                'image' => $row['anh'],
                'category_id' => $row['id_danh_muc'],
                'brand_id' => $row['id_thuong_hieu'],
                'price_regular' => $row['gia_goc'],
                'price_sale' => $row['gia_giam'],
                'quantity' => $row['so_luong'],
                'length' => $row['chieu_dai'],
                'width' => $row['chieu_rong'],
                'height' => $row['chieu_cao'],
                'weight' => $row['trong_luong'],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'ten_san_pham' => 'required|unique:products,name|max:255',
            'anh' => 'required',
            'id_thuong_hieu' => 'required|exists:brands,id',
            'id_danh_muc' => 'required|exists:categories,id',
            'gia_goc' => 'required|numeric',
            'gia_giam' => 'required|numeric',
            'so_luong' => 'required',
            'chieu_dai' => 'integer|required|max:200',
            'chieu_rong' => 'integer|required|max:200',
            'chieu_cao' => 'integer|required|max:200',
            'trong_luong' => 'integer|required|max:1600000',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ten_san_pham.required' => 'Tên sản phẩm là bắt buộc.',
            'ten_san_pham.unique' => 'Tên sản phẩm đã tồn tại.',
            'ten_san_pham.max' => 'Tên sản phẩm không được vượt quá :max ký tự.',
            'anh.required' => 'Ảnh là bắt buộc.',
            'id_thuong_hieu.required' => 'Thương hiệu là bắt buộc.',
            'id_thuong_hieu.exists' => 'Thương hiệu không tồn tại.',
            'id_danh_muc.required' => 'Danh mục là bắt buộc.',
            'id_danh_muc.exists' => 'Danh mục không tồn tại.',
            'gia_goc.required' => 'Giá gốc là bắt buộc.',
            'gia_giam.required' => 'Giá giảm là bắt buộc.',
            'so_luong.required' => 'Số lượng là bắt buộc.',
            'chieu_dai.integer' => 'Chiều dài phải là số nguyên.',
            'chieu_dai.required' => 'Chiều dài là bắt buộc.',
            'chieu_dai.max' => 'Chiều dài không được vượt quá :max.',
            'chieu_rong.integer' => 'Chiều rộng phải là số nguyên.',
            'chieu_rong.required' => 'Chiều rộng là bắt buộc.',
            'chieu_rong.max' => 'Chiều rộng không được vượt quá :max.',
            'chieu_cao.integer' => 'Chiều cao phải là số nguyên.',
            'chieu_cao.required' => 'Chiều cao là bắt buộc.',
            'chieu_cao.max' => 'Chiều cao không được vượt quá :max.',
            'trong_luong.integer' => 'Trọng lượng phải là số nguyên.',
            'trong_luong.required' => 'Trọng lượng là bắt buộc.',
            'trong_luong.max' => 'Trọng lượng không được vượt quá :max.',
        ];
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