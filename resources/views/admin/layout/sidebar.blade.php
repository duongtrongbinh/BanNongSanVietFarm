  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
            </a>
        </li>
        @foreach (config('sidebar') as $key => $item)
            @php $isActive = false; @endphp
            <li class="nav-item">
                @foreach ($item['subtitle'] as $value)
                    @if (auth()->user()->hasAnyRole($value['roles']))
                        @php if (str_contains(url()->current(), $value['name'])) $isActive = true; @endphp
                    @endif
                @endforeach
                @if (auth()->user()->hasAnyRole(array_merge(array_column($item['subtitle'], 'roles'))))
                    <a class="nav-link collapsed" data-bs-target="#{{ 'attribute' . $key }}" data-bs-toggle="collapse" href="#">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="{{ 'attribute' . $key }}" class="nav-content collapse {{ $isActive ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                        @foreach($item['subtitle'] as $value)
                            @if (auth()->user()->hasAnyRole($value['roles']))
                                <li>
                                    <a href="{{ route($value['route']) }}" class="{{ str_contains(url()->current(), $value['name']) ? 'active' : '' }}">
                                        <i class="{{ $value['icon'] }}" style="font-size: 15px;"></i>
                                        <span>{{ $value['title'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
      </ul>
  </aside>
  <!-- End Sidebar-->

