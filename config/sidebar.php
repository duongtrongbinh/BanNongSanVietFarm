<?php
return [
    // [
    //     'title' => '',
    //     'subtitle' => [
    //         [
    //             'title' => 'Vouchers',
    //             'icon' => 'ri-coupon-line',
    //             'route' => 'vouchers.index',
    //         ],
    //     ],
    // ],
    [
        'title' => 'Quản lý sản phẩm',
        'icon' => 'bi bi-box-seam',
        'subtitle' => [
            [
                'title' => 'Danh sách sản phẩm',
                'icon' => 'bi bi-card-list',
                'route' => 'products.index',
            ],
            [
                'title' => 'Thương hiệu',
                'icon' => 'bi bi-award',
                'route' => 'brands.index',
            ],
            [
                'title' => 'Danh mục',
                'icon' => 'bi bi-list-task',
                'route' => 'categories.index',
            ],
            [
                'title' => 'Đánh giá',
                'icon' => 'bi bi-chat-dots',
                'route' => 'comment.index',
            ],
            [
                'title' => 'Tag',
                'icon' => 'bi bi-tag',
                'route' => 'tags.index',
            ],
        ],
    ],
    [
        'title' => 'Quản lý bài viết',
        'icon' => 'bi bi-stickies',
        'subtitle' => [
            [
                'title' => 'Danh sách bài viết',
                'icon' => 'bi bi-file-earmark',
                'route' => 'post.index',
            ],
            [
                'title' => 'Bình luận',
                'icon' => 'bi bi-chat-dots',
                'route' => 'rate.index',
            ],
        ],
    ],
    [
        'title' => 'Quản lý khách hàng',
        'icon' => 'bi bi-person',
        'subtitle' => [
            [
                'title' => 'Danh sách khách hàng',
                'icon' => 'bi bi-people',
                'route' => 'user.index',
            ],
            [
                'title' => 'Thêm khách hàng',
                'icon' => 'bi bi-person-add',
                'route' => 'user.create',
            ],
        ],
    ],
    [
        'title' => 'Quản lý nhập hàng',
        'icon' => 'bi bi-house-up',
        'subtitle' => [
            [
                'title' => 'Nhà cung cấp',
                'icon' => 'bi bi-house-add',
                'route' => 'supplier.index',
            ],
            [
                'title' => 'Phiếu nhập hàng',
                'icon' => 'bi bi-receipt',
                'route' => 'purchase_receipt.index',
            ],
        ],
    ],
    [
        'title' => 'Quản lý đơn hàng',
        'icon' => 'bi bi-box-seam',
        'subtitle' => [
            [
                'title' => 'Danh sách đơn hàng',
                'icon' => 'bi bi-inboxes',
                'route' => 'orders.index',
            ],
        ],
    ],
    [
        'title' => 'Flash Sale',
        'icon' => 'ri-flashlight-line',
        'subtitle' => [
            [
                'title' => 'Danh sách Flash Sale',
                'icon' => 'bi bi-activity',
                'route' => 'flash-sales.index',
            ],
        ],
    ],
];
