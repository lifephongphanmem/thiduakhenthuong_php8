@if (chkPhanQuyen('baocaothongke', 'phanquyen'))
    <li class="menu-section">
        <h4 class="menu-text">Thống kê, báo cáo</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="fas fa-folder"></i>
            </span>
            <span class="menu-text font-weight-bold">{{ chkGiaoDien('baocaothongke', 'tenchucnang') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                @if (chkPhanQuyen('baocaodonvi', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/BaoCao/DonVi/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('baocaodonvi', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
                @if (chkPhanQuyen('baocaotapthe', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/BaoCao/TongHop/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('baocaotapthe', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
                @if (chkPhanQuyen('baocaocumkhoi', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/BaoCao/CumKhoi/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('baocaocumkhoi', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </li>
@endif
