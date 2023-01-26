<div class="page-content">
    <div class="sidebar sidebar-main sidebar-expand-xl">
        <div class="sidebar-content">
            <div class="sidebar-section">
                <div class="sidebar-section-body d-flex justify-content-center pb-1">
                    <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigasi</h5>
                    <div>
                        <button type="button" class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-xl-inline-flex"><i class="ph-arrows-left-right"></i></button>
                        <button type="button" class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-xl-none"><i class="ph-x"></i></button>
                    </div>
                </div>
            </div>
            <div class="sidebar-section">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    @foreach(config('menu') as $m1)
                        @php
                            $nameAccess = $m1['name'];
                            $checkAccessM1 = Simrs::hasPermission($nameAccess);
                        @endphp

                        @if($m1['sub'] && $checkAccessM1 != false)
                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == $m1['name'] ? 'nav-item-expanded nav-item-open' : '' }}">
                                <a href="{{ url($m1['link']) }}" class="nav-link">
                                    <i class="{{ $m1['icon'] }}"></i>
                                    <span>{{ $m1['menu'] }}</span>
                                </a>
                                <ul class="nav-group-sub collapse {{ Request::segment(1) == $m1['name'] ? 'show' : '' }}">
                                    @foreach($m1['sub'] as $m2)
                                        @php
                                            $nameAccess = $m1['name'] . '.' . $m2['name'];
                                            $checkAccessM2 = Simrs::hasPermission($nameAccess);
                                        @endphp

                                        @if($m2['sub'] && $checkAccessM2 != false)
                                            <li class="nav-item nav-item-submenu {{ Request::segment(1) == $m1['name'] && Request::segment(2) == $m2['name'] ? 'nav-item-expanded nav-item-open' : '' }}">
                                                <a href="{{ url($m2['link']) }}" class="nav-link">{{ $m2['menu'] }}</a>
                                                <ul class="nav-group-sub collapse {{ Request::segment(1) == $m1['name'] && Request::segment(2) == $m2['name'] ? 'show' : '' }}">
                                                    @foreach($m2['sub'] as $m3)
                                                        @php
                                                            $nameAccess = $m1['name'] . '.' . $m2['name'] . '.' . $m3['name'];
                                                            $checkAccessM3 = Simrs::hasPermission($nameAccess);
                                                        @endphp

                                                        @if($checkAccessM3 != false)
                                                            <li class="nav-item">
                                                                <a href="{{ url($m3['link']) }}" class="nav-link {{ Request::segment(1) == $m1['name'] && Request::segment(2) == $m2['name'] && Request::segment(3) == $m3['name'] ? 'active' : '' }}">{{ $m3['menu'] }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            @if($checkAccessM2 != false)
                                                <li class="nav-item">
                                                    <a href="{{ url($m2['link']) }}" class="nav-link {{ Request::segment(1) == $m1['name'] && Request::segment(2) == $m2['name'] ? 'active' : '' }}">{{ $m2['menu'] }}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            @if($checkAccessM1 != false)
                                <li class="nav-item {{ Request::segment(1) == $m1['name'] }}">
                                    <a href="{{ url($m1['link']) }}" class="nav-link">
                                        <i class="{{ $m1['icon'] }}"></i>
                                        <span>{{ $m1['menu'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="content-inner">
