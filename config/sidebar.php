<?php
use App\Enums\Roles;

return [
    [
        'title' => 'Quản Báo Cáo',
        'icon' => 'bi bi-image-fill',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name],
        'subtitle' => [
            [
                'title' => 'Báo Cáo Đơn hàng',
                'icon' => 'bi bi-bag',
                'route' => 'report.orders',
                'name' => 'report',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Báo Cáo Khách hàng',
                'icon' => 'bi bi-person-dash-fill',
                'route' => 'report.users',
                'name' => 'report',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Báo Cáo Doanh thu',
                'icon' => 'bi-currency-dollar',
                'route' => 'report.revenue',
                'name' => 'report',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Báo Cáo Kho Hàng',
                'icon' => 'bi-box-seam',
                'route' => 'report.purchase_receipt',
                'name' => 'report',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý banners',
        'icon' => 'bi bi-image-fill',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name],
        'subtitle' => [
            [
                'title' => 'Danh sách banners',
                'icon' => 'bi bi-list-nested',
                'route' => 'banners.index',
                'name' => 'banners',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
            [
                'title' => 'Thêm banners',
                'icon' => 'bi bi-building-add',
                'route' => 'banners.create',
                'name' => 'banners',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý sản phẩm',
        'icon' => 'bi bi-box-seam',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::PRODUCT_MANAGE->name],
        'subtitle' => [
            [
                'title' => 'Danh sách sản phẩm',
                'icon' => 'bi bi-card-list',
                'route' => 'products.index',
                'name' => 'products',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Nhóm sản phẩm',
                'icon' => 'bi bi-collection',
                'route' => 'groups.index',
                'name' => 'groups',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Thương hiệu',
                'icon' => 'bi bi-award',
                'route' => 'brands.index',
                'name' => 'brands',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Danh mục',
                'icon' => 'bi bi-list-task',
                'route' => 'categories.index',
                'name' => 'categories',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Đánh giá',
                'icon' => 'bi bi-chat-dots',
                'route' => 'rate.index',
                'name' => 'rate',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
            [
                'title' => 'Tag',
                'icon' => 'bi bi-tag',
                'route' => 'tags.index',
                'name' => 'tags',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::PRODUCT_MANAGE->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý bài viết',
        'icon' => 'bi bi-stickies',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name,Roles::MARKETING->name],
        'subtitle' => [
            [
                'title' => 'Danh sách bài viết',
                'icon' => 'bi bi-file-earmark',
                'route' => 'post.index',
                'name' => 'post',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
            [
                'title' => 'Tạo bài viết',
                'icon' => 'bi bi-building-add',
                'route' => 'post.create',
                'name' => 'post',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
            [
                'title' => 'Bình luận',
                'icon' => 'bi bi-chat-dots',
                'route' => 'comment.index',
                'name' => 'comment',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý khách hàng',
        'icon' => 'bi bi-person',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::CUSTOMER_SERVICE_REPRESENTATIVE->name],
        'subtitle' => [
            [
                'title' => 'Danh sách khách hàng',
                'icon' => 'bi bi-people',
                'route' => 'user.index',
                'name' => 'user',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::CUSTOMER_SERVICE_REPRESENTATIVE->name]
            ],
            [
                'title' => 'Thêm khách hàng',
                'icon' => 'bi bi-person-add',
                'route' => 'user.create',
                'name' => 'user',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::CUSTOMER_SERVICE_REPRESENTATIVE->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý nhập hàng',
        'icon' => 'bi bi-house-up',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::WAREHOUSE_STAFF->name],
        'subtitle' => [
            [
                'title' => 'Nhà cung cấp',
                'icon' => 'bi bi-house-add',
                'route' => 'supplier.index',
                'name' => 'supplier',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::WAREHOUSE_STAFF->name]
            ],
            [
                'title' => 'Phiếu nhập hàng',
                'icon' => 'bi bi-receipt',
                'route' => 'purchase_receipt.index',
                'name' => 'purchase_receipt',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::WAREHOUSE_STAFF->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý đơn hàng',
        'icon' => 'bi bi-box-seam',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::ORDER_MANAGE->name],
        'subtitle' => [
            [
                'title' => 'Danh sách đơn hàng',
                'icon' => 'bi bi-inboxes',
                'route' => 'orders.index',
                'name' => 'orders',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::ORDER_MANAGE->name]
            ],
        ],
    ],
    [
        'title' => 'Phiếu giảm giá',
        'icon' => 'ri-flashlight-line',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name],
        'subtitle' => [
            [
                'title' => 'Danh sách phiếu giảm giá',
                'icon' => 'bi bi-activity',
                'route' => 'vouchers.index',
                'name' => 'vouchers',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name, Roles::MARKETING->name]
            ],
        ],
    ],
    [
        'title' => 'Quản lý nhân sự',
        'icon' => 'bi bi-person',
        'roles' => [Roles::SYSTEM_ADMINISTRATOR->name],
        'subtitle' => [
            [
                'title' => 'Phân quyền',
                'icon' => 'bi bi-person',
                'route' => 'permission.index',
                'name' => 'permission',
                'roles' => [Roles::SYSTEM_ADMINISTRATOR->name]
            ],
          ],
    ],

];
