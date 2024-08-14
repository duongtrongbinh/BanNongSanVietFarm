<!-- ======= Header ======= -->
<style>
    .bg-custom-light {
        background-color: #f0f0f0; /* Chọn màu tối hơn */
    }
</style>
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard')}}" class="logo d-flex align-items-center">
            <img src="#" alt="">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown" >
                @php $notifications = \Illuminate\Support\Facades\Auth::user()->notifications @endphp
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number" id="total-notification-new">{{  Auth::user()->notifications()->count() }}</span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="max-height: 400px; overflow-y: auto; width: 50vh" >
                    <li class="dropdown-header">
                        Bạn có <span id="total-notification">{{  Auth::user()->unreadNotifications()->count() }}</span> thông báo mới.
                    </li>

                    <div id="notification">
                    @foreach (Auth::user()->unreadNotifications as $notification)
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                            <a href="{{ route('orders.edit',$notification->data['order_id'])}}?query={{ $notification->id }}">
                                <li class="notification-item bg-custom-light">
                                    <i class="bi bi-bag-check-fill text-success"></i>
                                    <div>
                                        <h4>{{ $notification->data['type'] }}</h4>
                                        <span>{{ $notification->data['message'] }}
                                            <span>{{ $notification->data['customer'] }}</span>
                                        </span>
                                        <p class="mt-2">#{{ $notification->data['order_code'] }}</p>
                                        <p>{{ mb_convert_case($notification->created_at->diffForHumans(), MB_CASE_TITLE, "UTF-8") }}</p>
                                    </div>
                                </li>
                            </a>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @endforeach
                    </div>
{{--                    @foreach (Auth::user()->readNotifications as $notification)--}}
{{--                        <li>--}}
{{--                            <hr class="dropdown-divider">--}}
{{--                        </li>--}}
{{--                        <a href="{{ route('orders.edit',$notification->data['order_id'])}}?query={{ $notification->id }}">--}}
{{--                            <li class="notification-item text-dark">--}}
{{--                                <i class="bi bi-bag-check-fill text-success"></i>--}}
{{--                                <div>--}}
{{--                                    <h4>{{ $notification->data['type'] }}</h4>--}}
{{--                                    <span>{{ $notification->data['message'] }}--}}
{{--                                             <span>{{ $notification->data['customer'] }}</span>--}}
{{--                                     </span>--}}
{{--                                        <p class="mt-2">#{{ $notification->data['order_code'] }}</p>--}}
{{--                                    <p>{{ mb_convert_case($notification->created_at->diffForHumans(), MB_CASE_TITLE, "UTF-8") }}</p>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        </a>--}}
{{--                        <li>--}}
{{--                            <hr class="dropdown-divider">--}}
{{--                        </li>--}}
{{--                    @endforeach--}}

                </ul><!-- End Notification Dropdown Items --><!-- End Notification Dropdown Items -->

            </li>

{{--            <li class="nav-item dropdown pe-3">--}}
{{--                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">--}}
{{--                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle ">--}}
{{--                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>--}}
{{--                </a><!-- End Profile Iamge Icon -->--}}

{{--                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">--}}
{{--                    <li class="dropdown-header">--}}
{{--                        <h6>{{ auth()->user()->name }}</h6>--}}
{{--                        <span>Quản trị viên</span>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile')}}">--}}
{{--                            <i class="bi bi-person"></i>--}}
{{--                            <span>Hồ sơ</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <hr class="dropdown-divider">--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                        <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
{{--                            <i class="bi bi-box-arrow-right"></i>--}}
{{--                            <span>Đăng xuất</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul><!-- End Profile Dropdown Items -->--}}
{{--            </li><!-- End Profile Nav -->--}}
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->
<script>
        document.getElementById('checked-all').addEventListener('click', function() {
            const isChecked = this.checked;
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
</script>

