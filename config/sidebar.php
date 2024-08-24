<?php
use App\Enums\Roles;

return [
    [
        'title' => 'Quản Báo Cáo',
        'icon' => 'bi bi-file-text',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name],
        'subtitles' => [
            [
                'title' => 'Báo Cáo Đơn hàng',
                'icon' => 'bi bi-bag',
                'route' => 'report.orders',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Báo Cáo Khách hàng',
                'icon' => 'bi bi-person-dash-fill',
                'route' => 'report.users',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Báo Cáo Doanh thu',
                'icon' => 'bi-currency-dollar',
                'route' => 'report.revenue',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Báo Cáo Kho Hàng',
                'icon' => 'bi-box-seam',
                'route' => 'report.purchase_receipt',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Báo cáo phiếu giảm giá',
                'icon' => 'bi-box-seam',
                'route' => 'report.vouchers',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Dashboard',
        'icon' => 'bi bi-grid',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name],
        'route' => 'dashboard',
    ],
    [
        'title' => 'Quản lý banners',
        'icon' => 'bi bi-image-fill',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name],
        'subtitles' => [
            [
                'title' => 'Danh sách banners',
                'icon' => 'bi bi-list-nested',
                'route' => 'banners.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Thêm banners',
                'icon' => 'bi bi-building-add',
                'route' => 'banners.create',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý sản phẩm',
        'icon' => 'bi bi-box-seam',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::PRODUCT_MANAGE->name],
        'subtitles' => [
            [
                'title' => 'Danh sách sản phẩm',
                'icon' => 'bi bi-card-list',
                'route' => 'products.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Nhóm sản phẩm',
                'icon' => 'bi bi-collection',
                'route' => 'groups.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Thương hiệu',
                'icon' => 'bi bi-award',
                'route' => 'brands.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Danh mục',
                'icon' => 'bi bi-list-task',
                'route' => 'categories.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Đánh giá',
                'icon' => 'bi bi-chat-dots',
                'route' => 'rate.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Tag',
                'icon' => 'bi bi-tag',
                'route' => 'tags.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý bài viết',
        'icon' => 'bi bi-stickies',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name],
        'subtitles' => [
            [
                'title' => 'Danh sách bài viết',
                'icon' => 'bi bi-file-earmark',
                'route' => 'post.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
            [
                'title' => 'Tạo bài viết',
                'icon' => 'bi bi-building-add',
                'route' => 'post.create',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
            [
                'title' => 'Bình luận',
                'icon' => 'bi bi-chat-dots',
                'route' => 'comment.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý khách hàng',
        'icon' => 'bi bi-person',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::CUSTOMER_SERVICE_REPRESENTATIVE->name],
        'subtitles' => [
            [
                'title' => 'Danh sách khách hàng',
                'icon' => 'bi bi-people',
                'route' => 'user.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::CUSTOMER_SERVICE_REPRESENTATIVE->name]
            ],
            [
                'title' => 'Thêm khách hàng',
                'icon' => 'bi bi-person-add',
                'route' => 'user.create',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::CUSTOMER_SERVICE_REPRESENTATIVE->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý nhập hàng',
        'icon' => 'bi bi-house-up',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::WAREHOUSE_STAFF->name],
        'subtitles' => [
            [
                'title' => 'Nhà cung cấp',
                'icon' => 'bi bi-house-add',
                'route' => 'supplier.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::WAREHOUSE_STAFF->name]
            ],
            [
                'title' => 'Phiếu nhập hàng',
                'icon' => 'bi bi-receipt',
                'route' => 'purchase_receipt.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::WAREHOUSE_STAFF->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý đơn hàng',
        'icon' => 'bi bi-box-seam',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::ORDER_MANAGE->name],
        'route' => 'orders.index',
    ],
    [
        'title' => 'Phiếu giảm giá',
        'icon' => 'ri-flashlight-line',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name],
        'subtitles' => [
            [
                'title' => 'Danh sách phiếu giảm giá',
                'icon' => 'bi bi-activity',
                'route' => 'vouchers.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý nhân sự',
        'icon' => 'bi bi-person',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name],
        'subtitles' => [
            [
                'title' => 'Phân quyền',
                'icon' => 'bi bi-person',
                'route' => 'permission.index',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name]
            ],
          ],
    ],

];
