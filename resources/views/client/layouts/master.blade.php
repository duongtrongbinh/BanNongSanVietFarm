<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('client/assets/img/logo.jpg') }}" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('client/assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('client/assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('client/assets/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('client/assets/css/style.css') }}" rel="stylesheet">

        @yield('styles')
    </head>
    <body>
        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->

        @include('client.layouts.header')

        @yield('content')

        @include('client.layouts.footer')

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   
        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('client/assets/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('client/assets/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('client/assets/lib/lightbox/js/lightbox.min.js') }}"></script>
        <script src="{{ asset('client/assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('client/assets/js/main.js') }}"></script>
        <script>
            $(document).ready(function() {
                function formatNumber(number) {
                    // // Chuyển đổi số thành chuỗi và loại bỏ các chữ số thập phân không cần thiết
                    let formattedNumber = Math.floor(number);

                    // // Định dạng chuỗi số thành số có dấu phân cách hàng nghìn
                    return Number(formattedNumber).toLocaleString('en-US');
                }

                function addToCart(product, url) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            product: product,
                            quantity: 1,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);
                            $('.cart-count').text(Object.keys(response.cart).length);
                        }
                    });
                }

                function renderCart(url) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            let totalPrice = 0;
                            let total = 0;
                            let subtotal = 0;
                            const cartDrop = document.querySelector('.dropdown-menu-cart');
                            cartDrop.innerHTML = '';
                            if (response.cart == null || response.cart.length === 0) {
                                let cartEmpty = document.createElement('div');
                                cartEmpty.classList.add('text-center', 'empty-cart');
                                cartEmpty.id = 'empty-cart';
                                cartEmpty.innerHTML = `
                                    <div class="avatar-md mx-auto my-3">
                                        <div class="avatar-title bg-info-subtle text-info fs-36 rounded-circle">
                                            <i class='bx bx-cart'></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-3">Your Cart is Empty!</h5>
                                    <a href="{{ route('shop') }}" class="btn btn-success w-md mb-3">Shop Now</a>
                                `;
                                cartDrop.appendChild(cartEmpty);
                            }else {
                                cartDrop.innerHTML = `
                                    <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold">Giỏ hàng</h6>
                                            </div>
                                            <div class="col-auto">
                                                <span class="badge bg-warning-subtle text-warning fs-13">
                                                    <span class="cartitem-badge cart-count">{{ session()->exists('cart') ? count(session()->get('cart')) : 0 }}</span>
                                                    sản phẩm
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-simplebar style="max-height: 100%;" class="div-cart">
                                        <div class="p-2 cart-items">

                                        </div>
                                    </div>
                                    <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border" id="checkout-elem">
                                        <div class="d-flex justify-content-between align-items-center pb-3">
                                            <h5 class="m-0 text-muted">Tổng: </h5>
                                            <div class="px-2">
                                                <h5 class="m-0" id="cart-item-total"> VNĐ</h5>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ route('cart.index') }}" class="btn btn-secondary text-center w-100 m-1">Giỏ hàng</a>
                                            <a href="{{ route('checkout') }}" class="btn btn-success text-center w-100 m-1">Checkout</a>
                                        </div>
                                    </div>
                                `;
                                
                                const cartItems = document.querySelector('.cart-items');
                                cartItems.innerHTML = '';
                                
                                // Lấy danh sách các khóa từ đối tượng cart
                                let keys = Object.keys(response.cart);
                                // Chuyển đổi đối tượng thành mảng các sản phẩm
                                let cartArray = keys.map(key => response.cart[key]);
                                cartArray.forEach(function(product) {
                                    total = (product.price * product.quantity);
                                    const cartList = document.createElement('div');
                                    cartList.classList.add('d-block', 'dropdown-item', 'dropdown-item-cart', 'text-wrap', 'px-3', 'py-2');
                                    cartList.innerHTML = `
                                        <div class="d-block text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                <img src="${product.image}" class="me-3 rounded-circle" style="width: 4.5rem; height: 4.5rem" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <p class="text-reset">${product.name}</p>
                                                    </h6>
                                                    <p class="mb-0 fs-12 text-muted">
                                                        SL: <span>${product.quantity} x ${formatNumber(product.price)} VNĐ</span>
                                                    </p>
                                                </div>
                                                <div class="px-2">
                                                    <h5 class="m-0" style="font-size: 1rem">${formatNumber(total)}<span class="cart-item-price"> VNĐ</span></h5>
                                                </div>
                                                <div class="ps-2">
                                                    <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-cart" data-id="${product.id}" data-url="{{ route('cart.remove') }}">
                                                        <i class="fa fa-times text-danger"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    cartItems.appendChild(cartList);
                                    totalPrice += total;
                                    subtotal = formatNumber(totalPrice);

                                });

                                $('#cart-item-total').text(subtotal + ' VNĐ');
                            }
                        }
                    });
                }

                function updateToCart(url, id, quantity) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: {
                            id: id,
                            quantity: quantity,
                        },
                        success: function(response) {
                            // Lấy danh sách các khóa từ đối tượng cart
                            let keys = Object.keys(response.cart);

                            // Chuyển đổi đối tượng thành mảng các sản phẩm
                            let cartArray = keys.map(key => response.cart[key]);
                            let totalPrice = 0;
                            cartArray.forEach(function(cart) {
                                let total = (cart.price * cart.quantity);
                                totalPrice += total;
                            });
                            
                            const subtotal = formatNumber(totalPrice);
                            $('#subtotal').text(subtotal + 'đ');
                        }
                    });
                }

                function removeItemFromCart(url, id) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            let totalPrice = 0;
                            alert(response.message);
                            $('.cart-count').text(Object.keys(response.cart).length);


                            let keys = Object.keys(response.cart);
                            let cartArray = keys.map(key => response.cart[key]);
                            cartArray.forEach(function(product) {
                                let total = (product.price * product.quantity);
                                totalPrice += total;
                            });

                            let subtotal = formatNumber(totalPrice);
                            $('#subtotal').text(subtotal + 'đ');
                        }
                    });
                }

                $(".add-to-cart").on("click", function() {
                    let url = $(this).data("url");

                    var ele = $(this);
                    var id = ele.data("id");
                    var product = {
                        id: id,
                    };

                    setTimeout(function() {
                        addToCart(product, url);
                    }, 100);
                });

                $(".cart-button").on("click", function() {
                    let url = $(this).data("url");

                    renderCart(url);
                });

                $('.cart-quantity').on('change', function() {
                    let url = $(this).data("url");
                    let id = $(this).data("id");
                    let quantity = $(this).val();
                    let price = $(this).data("price");
                    var $tr = $(this).closest('tr');
                    var totalPrice = quantity * price;
                    var total = formatNumber(totalPrice);
                    $tr.find('.total').text(total + 'đ');

                    updateToCart(url, id, quantity);
                });

                $(".remove-cart").on("click", function() {
                    let url = $(this).data("url");
                    let id = $(this).data("id");
                    $(this).closest('tr').remove();
                    
                    if(confirm("Bạn có chắc muốn xóa không?")) {
                        removeItemFromCart(url, id);
                    }
                });
            });
        </script>
        @yield('scripts')
    </body>
</html>