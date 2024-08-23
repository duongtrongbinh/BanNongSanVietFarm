<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach (config('sidebar') as $key => $item)
            @php
                $isActive = false;

                // Kiểm tra nếu có subtitles và route
                if (isset($item['subtitles']) && !empty($item['subtitles'])) {
                    foreach ($item['subtitles'] as $subtitle) {
                        if (auth()->user()->hasAnyRole($subtitle['roles']) && request()->routeIs($subtitle['route'])) {
                            $isActive = true;
                            break;
                        }
                    }
                } elseif (isset($item['route']) && request()->routeIs($item['route'])) {
                    $isActive = true;
                }
            @endphp

            @if (auth()->user()->hasAnyRole($item['roles']))
                <li class="nav-item">
                    <a class="nav-link {{ $isActive ? '' : 'collapsed' }}" 
                       data-bs-target="{{ isset($item['subtitles']) ? '#'.'attribute'.$key : '' }}" 
                       data-bs-toggle="{{ isset($item['subtitles']) ? 'collapse' : '' }}" 
                       href="{{ isset($item['route']) ? route($item['route']) : '#' }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                        @if(isset($item['subtitles']))
                            <i class="bi bi-chevron-down ms-auto"></i>
                        @endif
                    </a>

                    @if(isset($item['subtitles']) && !empty($item['subtitles']))
                        <ul id="{{ 'attribute' . $key }}" 
                            class="nav-content collapse {{ $isActive ? 'show' : '' }}" 
                            data-bs-parent="#sidebar-nav">
                            @foreach($item['subtitles'] as $subtitle)
                                @if (auth()->user()->hasAnyRole($subtitle['roles']))
                                    <li>
                                        <a href="{{ route($subtitle['route']) }}" 
                                           class="{{ request()->routeIs($subtitle['route']) ? 'active' : '' }}">
                                            <i class="{{ $subtitle['icon'] }}" style="font-size: 15px;"></i>
                                            <span>{{ $subtitle['title'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</aside>
<!-- End Sidebar-->
