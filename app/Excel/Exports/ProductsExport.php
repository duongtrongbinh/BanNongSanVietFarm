<?php

namespace App\Excel\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsExport implements FromCollection, WithStyles, WithEvents, WithHeadings, WithMapping
{
    protected $paginate;

    public function __construct($paginate)
    {
        $this->paginate = $paginate;
    }

    public function styles(Worksheet $sheet)
    {
        // Căn giữa nội dung theo chiều ngang cho hàng đầu tiên
        $sheet->getStyle('1')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Căn giữa nội dung trên và dưới trong toàn bộ bảng tính
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();
        
        $sheet->getStyle("A1:$highestColumn$highestRow")->applyFromArray([
            'alignment' => [
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(130);
        }

        return [
            // Có thể thêm các kiểu dáng khác ở đây nếu cần
        ];
    }

    public function collection()
    {
        if ($this->paginate === 'all') {
            $products = Product::latest('id')->get();
        } else {
            $products = Product::latest('id')->paginate($this->paginate);
        }

        return $products;
    }

    public function headings(): array {
        return [
            'Tên sản phẩm',
            'Ảnh',
            'Tên danh Mục',
            'Tên thương hiệu',
            'Giá gốc (VNĐ)',
            'Giá giảm (VNĐ)',
            'Số lượng',
            'Chiều dài (Cm)',
            'Chiều rộng (Cm)',
            'Chiều cao (Cm)',
            'Trọng lượng (Gam)',
            'Tên nhãn',
            'Mô tả',
            'Nội dung',
        ];
    }

    public function map($products): array {
        return [
           $products->name,
           null,
           $products->category->name,
           $products->brand->name,
           (int) $products->price_regular,
           (int) $products->price_sale,
           $products->quantity,
           $products->length,
           $products->width,
           $products->height,
           $products->weight,
           $products->tags->pluck('name')->implode(', '),
           $products->description,
           $products->content,
        ];
    }

    public function registerEvents(): array
    {
        return [
            // Khi tệp được xuất, điều chỉnh chiều rộng cột
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $products = $this->collection();
                $rowIndex = 2; // Bắt đầu từ hàng 2, vì hàng 1 là tiêu đề

                foreach ($products as $product) {
                    if ($product->image) {
                        $path = parse_url($product->image, PHP_URL_PATH);
                        $path = str_replace('/storage', '', $path);
                        $imagePath = storage_path('app/public' . $path);

                        if (file_exists($imagePath)) {
                            $drawing = new Drawing();
                            $drawing->setName($product->name);
                            $drawing->setPath($imagePath);
                            $drawing->setWidth(200);
                            $drawing->setHeight(150);
                            $drawing->setCoordinates("B$rowIndex");
                            $drawing->setWorksheet($sheet);
                            $drawing->setOffsetX(5);
                            $drawing->setOffsetY(5);
                        }
                    }
                    $rowIndex++;
                }

                // Điều chỉnh chiều rộng cột tự động
                foreach (range('A', $sheet->getHighestColumn()) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $sheet->getColumnDimension('B')->setAutoSize(false);
                $sheet->getColumnDimension('B')->setWidth(30);
            },
        ];
    }
}
