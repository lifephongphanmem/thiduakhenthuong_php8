@if (chkPhanQuyen('quantrihethong', 'phanquyen'))
    <li class="menu-section">
        <h4 class="menu-text">Hệ thống</h4>
        <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
    </li>
    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
        <a href="javascript:;" class="menu-link menu-toggle">
            <span class="svg-icon menu-icon">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                            d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                            fill="#000000" opacity="0.3" />
                        <path
                            d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                            fill="#000000" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
            <span class="menu-text font-weight-bold">{{ chkGiaoDien('quantrihethong', 'tenchucnang') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="menu-submenu">
            <i class="menu-arrow"></i>
            <ul class="menu-subnav">
                <li class="menu-item menu-item-parent" aria-haspopup="true">
                    <span class="menu-link">
                        <span
                            class="menu-text font-weight-bold">{{ chkGiaoDien('quantrihethong', 'tenchucnang') }}</span>
                    </span>
                </li>
                @if (chkPhanQuyen('quantridanhmuc', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('quantridanhmuc', 'tenchucnang') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dmphongtraothidua', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/PLPhongTraoThiDua/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmphongtraothidua', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dmhinhthucthidua', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/HinhThucThiDua/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmhinhthucthidua', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dmloaihinhkhenthuong', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/LoaiHinhKhenThuong/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmloaihinhkhenthuong', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dmdanhhieuthidua', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/DanhHieuThiDua/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmdanhhieuthidua', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dmhinhthuckhenthuong', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/HinhThucKhenThuong/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmhinhthuckhenthuong', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('duthaoquyetdinh', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/DuThaoQD/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('duthaoquyetdinh', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dmdetaisangkien', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/DeTaiSangKien/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmdetaisangkien', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dmcoquandonvi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/CoQuanDonVi/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmcoquandonvi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif


                                @if (chkPhanQuyen('dmnhomphanloai', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/DMPhanLoai/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dmnhomphanloai', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('quantrihethongchung', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text font-weight-bold">Hệ thống chung</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('dsdiaban', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/DiaBan/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dsdiaban', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('dsdonvi', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/DonVi/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dsdonvi', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('dstaikhoan', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/TaiKhoan/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dstaikhoan', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (chkPhanQuyen('dsnhomtaikhoan', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/NhomChucNang/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dsnhomtaikhoan', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('hethongchung_chucnang', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/ChucNang/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('hethongchung_chucnang', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('dsvanphonghotro', 'phanquyen'))
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('/VanPhongHoTro/ThongTin') }}" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('dsvanphonghotro', 'tenchucnang') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                @if (chkPhanQuyen('quantrihethongapi', 'phanquyen'))
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text font-weight-bold">Hệ thống API</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                @if (chkPhanQuyen('apithongtinchung', 'phanquyen'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('apithongtinchung', 'tenchucnang') }}</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                {{-- @if (chkPhanQuyen('apicanhan', 'phanquyen'))
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="/HeThongAPI/CaNhan" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot">
                                                            <span></span>
                                                        </i>
                                                        <span
                                                            class="menu-text">{{ chkGiaoDien('apicanhan', 'tenchucnang') }}</span>
                                                    </a>
                                                </li>
                                            @endif                                             --}}
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('apixuatdulieu', 'phanquyen'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('apixuatdulieu', 'tenchucnang') }}</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                @if (chkPhanQuyen('apixuatcanhan', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/HeThongAPI/XuatDuLieu/CaNhan" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apixuatcanhan', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (chkPhanQuyen('apixuattapthe', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/HeThongAPI/XuatDuLieu/TapThe" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apixuattapthe', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (chkPhanQuyen('apixuatphongtrao', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/HeThongAPI/XuatDuLieu/PhongTrao" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apixuatphongtrao', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('apinhandulieu', 'phanquyen'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('apinhandulieu', 'tenchucnang') }}</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                @if (chkPhanQuyen('apinhancanhan', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/HeThongAPI/NhanDuLieu/CaNhan" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apinhancanhan', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (chkPhanQuyen('apinhantapthe', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/HeThongAPI/NhanDuLieu/TapThe" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apinhantapthe', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (chkPhanQuyen('apinhanphongtrao', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="/HeThongAPI/NhanDuLieu/PhongTrao" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apinhanphongtrao', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                    data-menu-toggle="hover">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-dot">
                                            <span></span>
                                        </i>
                                        <span class="menu-text font-weight-bold">Quản lý kết nối</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu">
                                        <i class="menu-arrow"></i>
                                        <ul class="menu-subnav">
                                            <li class="menu-item" aria-haspopup="true">
                                                <a href="/HeThongAPI/KetNoi/QuanLyVanBan" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Quản lý văn bản điều hành</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="menu-subnav">
                                            <li class="menu-item" aria-haspopup="true">
                                                <a href="/HeThongAPI/KetNoi/QuanLyCanBo" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Quản lý cán bộ</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="menu-subnav">
                                            <li class="menu-item" aria-haspopup="true">
                                                <a href="/HeThongAPI/KetNoi/QuanLyLuuTru" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Quản lý tài liệu lưu trữ</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="menu-subnav">
                                            <li class="menu-item" aria-haspopup="true">
                                                <a href="/HeThongAPI/KetNoi/QuanLyTDKT" class="menu-link">
                                                    <i class="menu-bullet menu-bullet-dot">
                                                        <span></span>
                                                    </i>
                                                    <span class="menu-text">Thi đua khen thưởng của Bộ Nội vụ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                @if (chkPhanQuyen('hethongapiquanlyvanban', 'phanquyen'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('hethongapiquanlyvanban', 'tenchucnang') }}</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                @if (chkPhanQuyen('apiquanlyvanbantruyenhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/QuanLyVanBan/TruyenHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apiquanlyvanbantruyenhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if (chkPhanQuyen('apiquanlyvanbannhanhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/QuanLyVanBan/NhanHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apiquanlyvanbannhanhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('hethongapiquanlycanbo', 'phanquyen'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('hethongapiquanlycanbo', 'tenchucnang') }}</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                @if (chkPhanQuyen('apiquanlycanbotruyenhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/QuanLyCanBo/TruyenHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apiquanlycanbotruyenhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if (chkPhanQuyen('apiquanlycanbonhanhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/QuanLyCanBo/NhanHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apiquanlycanbonhanhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('hethongapihethongsohoa', 'phanquyen'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('hethongapihethongsohoa', 'tenchucnang') }}</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                @if (chkPhanQuyen('apihethongsohoatruyenhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/HeThongSoHoa/TruyenHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apihethongsohoatruyenhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if (chkPhanQuyen('apihethongsohoanhanhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/HeThongSoHoa/NhanHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apihethongsohoanhanhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                                @if (chkPhanQuyen('hethongapitdktbnv', 'phanquyen'))
                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"
                                        data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text font-weight-bold">{{ chkGiaoDien('hethongapitdktbnv', 'tenchucnang') }}</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                @if (chkPhanQuyen('apitdktbnvtruyenhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/HeThongSoHoa/TruyenHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apitdktbnvtruyenhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if (chkPhanQuyen('apitdktbnvnhanhoso', 'phanquyen'))
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ url('/HeThongAPI/HeThongSoHoa/NhanHoSo') }}"
                                                            class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot">
                                                                <span></span>
                                                            </i>
                                                            <span
                                                                class="menu-text">{{ chkGiaoDien('apitdktbnvnhanhoso', 'tenchucnang') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                @endif

                <li class="menu-item" aria-haspopup="true">
                    <a href="{{ url('/ThongTinDonVi') }}" class="menu-link">
                        <i class="menu-bullet menu-bullet-dot">
                            <span></span>
                        </i>
                        <span class="menu-text font-weight-bold">Thông tin đơn vị</span>
                    </a>
                </li>


                @if (chkPhanQuyen('hethongchung', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/HeThongChung/ThongTin') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span
                                class="menu-text font-weight-bold">{{ chkGiaoDien('hethongchung', 'tenchucnang') }}</span>
                        </a>
                    </li>
                @endif
                <!-- Chưa xây dựng -->
                @if (chkPhanQuyen('nhatkyhethong', 'phanquyen'))
                    <li class="menu-item" aria-haspopup="true">
                        <a href="{{ url('/NhatKyHeThong') }}" class="menu-link">
                            <i class="menu-bullet menu-bullet-dot">
                                <span></span>
                            </i>
                            <span class="menu-text font-weight-bold">Nhật ký hệ thống</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </li>
@endif
