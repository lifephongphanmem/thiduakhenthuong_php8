@if (chkPhanQuyen('quanlyvanban', 'phanquyen'))
    <li class="menu-section">
        <h4 class="menu-text">Quản lý Văn bản pháp lý, tài liệu</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <i class="fas fa-folder"></i>
            </span>
            <span class="menu-text font-weight-bold">{{ chkGiaoDien('quanlyvanban', 'tenchucnang') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                @if (chkPhanQuyen('vanbanphaply', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/QuanLyVanBan/VanBanPhapLy/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('vanbanphaply', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif

                @if (chkPhanQuyen('quyetdinhkhenthuong', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/QuanLyVanBan/KhenThuong/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('quyetdinhkhenthuong', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </li>
@endif
