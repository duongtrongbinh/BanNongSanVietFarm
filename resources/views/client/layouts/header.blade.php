<!-- Navbar start -->
<div class="container-fluid fixed-top">
  <div class="container topbar bg-primary d-none d-lg-block">
      <div class="d-flex justify-content-between">
          <div class="top-info ps-2">
              <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">123 Street, New York</a></small>
              <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
          </div>
          <div class="top-link pe-2">
              <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
              <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
              <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
          </div>
      </div>
  </div>
  <div class="container px-0">
      <nav class="navbar navbar-light bg-white navbar-expand-xl">
          <a href="/" class="navbar-brand"><h1 class="text-primary display-6">Nông Sản Việt</h1></a>
          <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
              <span class="fa fa-bars text-primary"></span>
          </button>
          <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
              <div class="navbar-nav mx-auto">
                  <a href="/" class="nav-item nav-link active">Trang chủ</a>
                  <a href="{{ route('shop') }}" class="nav-item nav-link">Shop</a>
                  <div class="nav-item dropdown">
                      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                      <div class="dropdown-menu m-0 bg-secondary rounded-0">
                          <a href="{{ route('cart.index') }}" class="dropdown-item">Cart</a>
                          <a href="{{ route('checkout') }}" class="dropdown-item">Checkout</a>
                          <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                          <a href="{{route('post')}}" class="dropdown-item">Post</a>
                          <a href="" class="dropdown-item">404 Page</a>
                      </div>
                  </div>
                  <a href="contact.html" class="nav-item nav-link">Contact</a>
              </div>

              <div class="d-flex m-3 me-0">
                  <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                  <a href="#" class="position-relative me-4 my-auto">
                      <i class="fa fa-shopping-bag fa-2x"></i>
                      <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                  </a>
                  <div class="dropdown">
                      <a href="#" class="my-auto dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fas fa-user fa-2x"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                          @if(auth()->check())
                              <!-- Hiển thị thông tin người dùng đã đăng nhập -->
                              <li>
                                  <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      {{ auth()->user()->name }}
                                  </button>
                                  <form action="{{ route('logout') }}" method="POST">
                                      @csrf
                                      <button type="submit" class="dropdown-item">Logout</button>
                                  </form>
                              </li>
                          @else
                              <!-- Hiển thị nút Login -->
                              <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>

                              <!-- Hiển thị nút Register -->
                              <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                          @endif
                      </ul>
                  </div>


              <div class="d-flex align-items-center justify-content-between m-3">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle position-relative my-auto cart-button" data-url="{{ route('cart.getCart') }}" style="outline: none; box-shadow: none; color: #81c408;" id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1 cart-count" style="top: -5px; left: 30px; height: 20px; min-width: 20px;">{{ session()->exists('cart') ? count(session()->get('cart')) : 0 }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" style="min-width: 31.25rem" aria-labelledby="page-header-cart-dropdown">
                            @if (session('cart'))
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
                                        @php $total = 0 @endphp
                                        @foreach((array) session('cart') as $id => $item)
                                            @php $total += $item['price'] * $item['quantity'] @endphp
                                        @endforeach
                                        @foreach (session('cart') as $id => $item)
                                            <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item['image'] }}" class="me-3 rounded-circle image" style="width: 4.5rem; height: 4.5rem" alt="user-pic">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mt-0 mb-1 fs-14">
                                                            <a class="text-reset name">{{ $item['name'] }}</a>
                                                        </h6>
                                                        <p class="mb-0 fs-12 text-muted">
                                                            Số lượng: <span class="quantity">{{ $item['quantity'] }} x {{number_format($item['price']) }}đ</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2">
                                                        <h5 class="m-0 fw-normal total">{{number_format($item['price'] * $item['quantity']) }}<span class="cart-item-price">đ</span></h5>
                                                    </div>
                                                    <div class="ps-2">
                                                        <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary remove-cart" data-id="{{ $id }}" data-url="{{ route('cart.remove', $id) }}">
                                                            <i class="fa fa-times text-danger"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border" id="checkout-elem">
                                    <div class="d-flex justify-content-between align-items-center pb-3">
                                        <h5 class="m-0 text-muted">Tổng: </h5>
                                        <div class="px-2">
                                            <h5 class="m-0" id="cart-item-total">{{ number_format($total) }}đ</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="{{ route('cart.index') }}" class="btn btn-secondary text-center w-100 m-1">Giỏ hàng</a>
                                        <a href="{{ route('checkout') }}" class="btn btn-success text-center w-100 m-1">Checkout</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="dropdown header-item topbar-user">
                        @if (Auth::check())
                            <button type="button" class="btn" style="outline: none; box-shadow: none; color: #81c408;" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user fa-2x"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="min-width: 13rem">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome Anna!</h6>
                                <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Hồ sơ</span></a>
                                <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Đơn hàng</span></a>
                                <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                                <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ Auth::logout() }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Đăng xuất</span></a>
                            </div>
                        @else
                        <button type="button" class="btn" style="outline: none; box-shadow: none; color: #81c408;" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user fa-2x"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="min-width: 13rem">
                            <a class="dropdown-item" href="{{ route('login') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Đăng nhập</span></a>
                            <a class="dropdown-item" href="{{ route('login') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Đăng ký</span></a>
                        @endif
                    </div>

              </div>
          </div>
      </nav>
  </div>
</div>
<!-- Navbar End -->

<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

