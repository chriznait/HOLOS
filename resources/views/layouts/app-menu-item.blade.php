@php
    
@endphp
@if ($item['submenu'] == [])
    <li class="nav-item {{ request()->routeIs($item['routeName']) ? 'active' : '' }}">
        <a class="d-flex align-items-center" href="{{ route($item['routeName']) }}">
            <i data-feather="{{ $item['icon'] }}"></i>
            <span class="menu-title text-truncate">{{ $item['name'] }}</span>
        </a>
    </li>
@else
    <li class="nav-item tiene-hijos">
        <a class="d-flex align-items-center" href="#">
            <i data-feather="{{ $item['icon'] }}"></i>
            <span class="menu-title text-truncate">{{ $item['name'] }}</span>
        </a>
        <ul class="menu-content">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <li class="{{ request()->routeIs($submenu['routeName']) ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route($submenu['routeName']) }}">
                            <i data-feather="{{ $submenu['icon'] }}"></i>
                            <span class="menu-item text-truncate">{{ $submenu['name'] }}</span>
                        </a>
                    </li>
                @else
                    @include('layouts.app-menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach
        </ul>
    </li>

@endif