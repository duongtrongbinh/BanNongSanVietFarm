  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
            </a>
        </li>
        @foreach (config('sidebar') as $key =>  $item)
            @php $isActive = false; @endphp
            <li class="nav-item">
                @foreach ($item['subtitle'] as $value)
                    @php if (str_contains(url()->current(), $value['name'])) $isActive = true; @endphp
                @endforeach
                <a class="nav-link collapsed" data-bs-target="#{{ 'atttribute' . $key }}" data-bs-toggle="collapse" href="#">
                  <i class="{{ $item['icon'] }}"></i>
                  <span>{{ $item['title'] }}</span>
                  <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="{{ 'atttribute' . $key }}" class="nav-content collapse {{ $isActive ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    @foreach ($item['subtitle'] as $value)
                        <li>
                            <a href="{{ route($value['route']) }}" class="{{ str_contains(url()->current(), $value['name']) ? 'active' : '' }}">
                                <i class="{{ $value['icon'] }}" style="font-size: 15px; "></i>
                                <span>{{ $value['title'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
      </ul>
  </aside>
  <!-- End Sidebar-->
 
