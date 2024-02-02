@if (chkPhanQuyen('tracuutimkiem', 'phanquyen'))
    <li class="menu-section">
        <h4 class="menu-text">Tra cứu, tìm kiếm</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="fas fa-folder"></i>
            </span>
            <span class="menu-text font-weight-bold">{{ chkGiaoDien('tracuutimkiem', 'tenchucnang') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                @if (chkPhanQuyen('timkiemcanhan', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/TraCuu/CaNhan/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('timkiemcanhan', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
                @if (chkPhanQuyen('timkiemtapthe', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/TraCuu/TapThe/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('timkiemtapthe', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
                @if (chkPhanQuyen('timkiemphongtrao', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/TraCuu/PhongTrao/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('timkiemphongtrao', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </li>
@endif
