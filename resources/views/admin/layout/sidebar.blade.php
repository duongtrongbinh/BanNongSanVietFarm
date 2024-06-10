  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link " href="{{ route('dashboard') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->

          @foreach (config('sidebar') as $item)
              <li class="nav-heading">{{ $item['title'] }}</li>
              @foreach ($item['subtitle'] as $value)
                  <li class="nav-item">
                      <a class="nav-link collapsed" href="#">
                          <i class="{{ $value['icon'] }}"></i>
                          <span>{{ $value['title'] }}</span>
                      </a>
                  </li><!-- End Profile Page Nav -->
              @endforeach
          @endforeach

      </ul>
  </aside><!-- End Sidebar-->
