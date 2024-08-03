<?php

namespace App\Excel\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Str;

class ProductsImport extends DefaultValueBinder implements ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    protected $errors = [];
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    private function saveImage($drawing, $product_name)
    {
        $image_name = Str::slug($product_name);
        $drawing_path = $drawing->getPath();
        $extension = $drawing->getExtension();

        $img_url = "/storage/photos/1/products/{$image_name}.{$extension}";
        $img_path = public_path($img_url);

        if (file_exists($img_path)) {
            unlink($img_path);
        }

        // Đảm bảo thư mục tồn tại trước khi lưu ảnh
        if (!file_exists(dirname($img_path))) {
            mkdir(dirname($img_path), 0777, true);
        }

        $contents = file_get_contents($drawing_path);
        file_put_contents($img_path, $contents);

        $envUrl = env('APP_URL');
        $image = "{$envUrl}{$img_url}";

        return $image;
    }

    private function getImagesFromSpreadsheet($spreadsheet, $product_names)
    {
        $sheet = $spreadsheet->getActiveSheet();
        $drawings = $sheet->getDrawingCollection();
        $images = [];

        foreach ($drawings as $index => $drawing) {
            if ($drawing instanceof Drawing) {
                $product_name = $product_names[$index] ?? 'image_' . $index;
                $images[] = $this->saveImage($drawing, $product_name);
            }
        }

        return $images;
    }

    private function syncTags(array $tags)
    {
        $tagIds = [];

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }


    public function collection(Collection $rows)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($this->file);

        $product_names = $rows->pluck('ten_san_pham')->toArray();
        // Lấy tất cả các hình ảnh từ bảng tính
        $images = $this->getImagesFromSpreadsheet($spreadsheet, $product_names);

        DB::beginTransaction();
        $this->errors = [];

        try {
            foreach ($rows as $index => $row) {
                $imageValue = isset($images[$index]) ? $images[$index] : null;

                $productName = trim($row['ten_san_pham']);
                $categoryName = trim($row['ten_danh_muc']);
                $brandName = trim($row['ten_thuong_hieu']);
                $tags = array_map('trim', explode(',', trim($row['ten_nhan'])));
                $content = trim($row['noi_dung']); 
                // Chuyển đổi các dòng xuống dòng thành thẻ HTML <br>
                $content = nl2br($content); // hoặc tùy chọn khác nếu cần

                // Tra cứu category_id và brand_id từ tên
                $category = Category::where('name', $categoryName)->first();
                $brand = Brand::where('name', $brandName)->first();

                $productData = [
                    'name' => $productName,
                    'image' => $imageValue,
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'price_regular' => trim($row['gia_goc_vnd']),
                    'price_sale' => trim($row['gia_giam_vnd']),
                    'quantity' => trim($row['so_luong']),
                    'length' => trim($row['chieu_dai_cm']),
                    'width' => trim($row['chieu_rong_cm']),
                    'height' => trim($row['chieu_cao_cm']),
                    'weight' => trim($row['trong_luong_gam']),
                    'description' => trim($row['mo_ta']),
                    'content' => $content,
                ];

                // Kiểm tra sản phẩm hiện có
                $existingProduct = Product::where('name', $productName)->first();

                if ($existingProduct) {
                    // Cập nhật sản phẩm hiện có
                    $existingProduct->update($productData);
                    $existingProduct->tags()->sync($this->syncTags($tags));
                } else {
                    // Tạo sản phẩm mới
                    $product = Product::create($productData);
                    $product->tags()->attach($this->syncTags($tags));
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Xử lý lỗi hoặc ghi log lỗi ở đây
            throw $e;
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'ten_san_pham' => 'required|max:255',
            'ten_danh_muc' => 'required|exists:categories,name',
            'ten_thuong_hieu' => 'required|exists:brands,name',
            'gia_goc_vnd' => 'required|numeric',
            'gia_giam_vnd' => 'required|numeric',
            'so_luong' => 'required',
            'chieu_dai_cm' => 'integer|required|max:200',
            'chieu_rong_cm' => 'integer|required|max:200',
            'chieu_cao_cm' => 'integer|required|max:200',
            'trong_luong_gam' => 'integer|required|max:1600000',
            'ten_nhan.*' => 'exists:tags,name',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ten_san_pham.required' => 'Tên sản phẩm không được để trống.',
            'ten_san_pham.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'ten_danh_muc.required' => 'Danh mục không được để trống.',
            'ten_danh_muc.exists' => 'Danh mục không tồn tại.',
            'ten_thuong_hieu.required' => 'Thương hiệu không được để trống.',
            'ten_thuong_hieu.exists' => 'Thương hiệu không tồn tại.',
            'gia_goc_vnd.required' => 'Giá gốc không được để trống.',
            'gia_goc_vnd.numeric' => 'Giá gốc là số.',
            'gia_giam_vnd.required' => 'Giá giảm không được để trống.',
            'gia_giam.numeric' => 'Giá giảm là số.',
            'so_luong.required' => 'Số lượng không được để trống.',
            'chieu_dai_cm.integer' => 'Chiều dài phải là số nguyên.',
            'chieu_dai_cm.required' => 'Chiều dài không được để trống.',
            'chieu_dai_cm.max' => 'Chiều dài không được vượt quá 200 cm.',
            'chieu_rong_cm.integer' => 'Chiều rộng phải là số nguyên.',
            'chieu_rong_cm.required' => 'Chiều rộng không được để trống.',
            'chieu_rong_cm.max' => 'Chiều rộng không được vượt quá 200 cm.',
            'chieu_cao_cm.integer' => 'Chiều cao phải là số nguyên.',
            'chieu_cao_cm.required' => 'Chiều cao không được để trống.',
            'chieu_cao_cm.max' => 'Chiều cao không được vượt quá 200 cm.',
            'trong_luong_gam.integer' => 'Trọng lượng phải là số nguyên.',
            'trong_luong_gam.required' => 'Trọng lượng không được để trống.',
            'trong_luong_gam.max' => 'Trọng lượng không được vượt quá 1600000 gam.',
            'ten_nhan.*.exists' => 'Nhãn không tồn tại.',
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }
}