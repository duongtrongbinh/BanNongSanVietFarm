  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ route('/dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#category-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Categories</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="category-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          {{-- @can('viewAny', App\Models\CategoriesModel::class) --}}
          <li>
            <a href="{{ route('list_categories')}}">
              <i class="bi bi-circle"></i><span>List Category</span>
            </a>
          </li>
          {{-- @endcan --}}
          {{-- @can('create', App\Models\CategoriesModel::class) --}}
          <li>
            <a href="{{ route('form_add_categories')}}">
              <i class="bi bi-circle"></i><span>Add Category</span>
            </a>
          </li>
          {{-- @endcan --}}
        </ul>
      </li><!-- End category Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#slides-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Slides</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="slides-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('list_slide')}}">
              <i class="bi bi-circle"></i><span>List slide show</span>
            </a>
          </li>
          <li>
            <a href="{{ route('form_add_slide')}}">
              <i class="bi bi-circle"></i><span>Add slide show</span>
            </a>
          </li>
        </ul>
      </li><!-- End slides Nav -->
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#blogs-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Blogs</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="blogs-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('show_list_blog')}}">
              <i class="bi bi-circle"></i><span>List Blog</span>
            </a>
          </li>
          <li>
            <a href="{{ route('form_add_blog')}}">
              <i class="bi bi-circle"></i><span>Add Blog</span>
            </a>
          </li>

        </ul>
      </li><!-- End blogs Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="product-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('show_list_product')}}">
              <i class="bi bi-circle"></i><span>List Product</span>
            </a>
          </li>
          <li>
            <a href="{{ route('form_add_product')}}">
              <i class="bi bi-circle"></i><span>Add product</span>
            </a>
          </li>

        </ul>
      </li><!-- End product Nav -->

      <li class="nav-heading">Configuration</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('profileUser')}}">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('list_setting')}}">
          <i class="bi bi-question-circle"></i>
          <span>Setting</span>
        </a>
      </li><!-- End setting Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li><!-- End Blank Page Nav -->

      <li class="nav-heading">Permissions</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('list_user')}}">
          <i class="ri-file-user-line"></i>
          <span>List User</span>
        </a>
      </li><!-- End Role Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('list_role')}}">
          <i class="ri-remote-control-line"></i>
          <span>Role</span>
        </a>
      </li><!-- End Role Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->
