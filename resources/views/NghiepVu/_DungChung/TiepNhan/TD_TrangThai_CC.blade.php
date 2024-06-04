@if (session('admin')->opt_quytrinhkhenthuong == 'TAIKHOAN')
    @if (in_array($tt->trangthai_hoso, ['CD']) && chkPhanQuyen($inputs['phanquyen'], 'tiepnhan')&&$tt->taikhoantiepnhan)
        <button title="Tiếp nhận hồ sơ" type="button"
            onclick="confirmNhan('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'NhanHoSo' }}','{{ $inputs['madonvi'] }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm" data-toggle="modal">
            <i class="icon-lg flaticon-interface-5 text-success"></i>
        </button>
    @endif
    @if (in_array($tt->trangthai_hoso, ['DTN', 'CD', 'BTLXD', 'KDK', 'BTL','BTLTN']) &&
            chkPhanQuyen($inputs['phanquyen'], 'tiepnhan') && $tt->taikhoantiepnhan) 
        <button title="Huỷ tiếp nhận và trả lại hồ sơ" type="button"
            onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai" data-toggle="modal">
            <i class="icon-lg la la-reply text-danger"></i>
        </button>
    @endif

    @if (in_array($tt->trangthai_hoso, ['DTN']) && $tt->trangthai_chuyenchuyenvien)
        @if (chkPhanQuyen($inputs['phanquyen'], 'xuly'))
            <button title="Chuyển chuyên viên xử lý" type="button"
                onclick="confirmChuyenChuyenVien('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'ChuyenChuyenVien' }}')"
                class="btn btn-sm btn-clean btn-icon" data-target="#modal-chuyenchuyenvien" data-toggle="modal">
                <i class="icon-lg la flaticon-user-ok text-success"></i>
            </button>
        @endif
    @endif

    @if (in_array($tt->trangthai_hoso, ['DCCVXD', 'BTLXD', 'BTL','BTLTN','KDK']) &&
            $tt->thaotac &&
            chkPhanQuyen($inputs['phanquyen'], 'xuly'))
        <button title="Xử lý hồ sơ" type="button"
            onclick="confirmXuLyHoSo('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}','{{ $tt->dieukien_hs == true ? 1 : 0 }}','{{ $tt->trangthai_xl }}', '{{ $inputs['url_xd'] . 'XuLyHoSo' }}','{{ $tt->tendangnhap_xl }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#modal-xulyhoso" data-toggle="modal">
            <i class="icon-lg la flaticon-list text-success"></i>
        </button>
    @endif
    @if (in_array($tt->trangthai, ['BTLXD','BTL','BTLTN']) && $tt->lydo_xd != null)
        <button title="Lý do hồ sơ bị trả lại" type="button"
            onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_hs'] . 'LayLyDo' }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal" data-toggle="modal">
            <i class="icon-lg la flaticon2-information text-info"></i>
        </button>
    @endif

    {{-- @if (in_array($tt->trangthai_hoso, ['DTN', 'BTLXD']))
        @if (chkPhanQuyen('tnhosodenghikhenthuongcongtrang', 'hoanthanh'))
            <button title="Chuyển xét duyệt khen thưởng" type="button"
                onclick="confirmTrinhHS('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
                class="btn btn-sm btn-clean btn-icon" {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
                data-target="#trinhhs-modal" data-toggle="modal">
                <i class="icon-lg la fa-share-square text-success"></i>
            </button>
        @endif
    @endif --}}

    @if (in_array($tt->trangthai_hoso, ['DCCVXD', 'BTLXD', 'DTN','BTL','BTLTN']) &&
            $tt->thaotac &&
            chkPhanQuyen($inputs['phanquyen'], 'hoanthanh'))
        <button title="Chuyển xét duyệt khen thưởng" type="button"
            onclick="confirmTrinhHS('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
            class="btn btn-sm btn-clean btn-icon" {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
            data-target="#trinhhs-modal" data-toggle="modal">
            <i class="icon-lg la fa-share-square text-success"></i>
        </button>
    @endif
    @if (chkPhanQuyen($inputs['phanquyen'], 'xuly'))
        <a title="Xem chi tiết xử lý hồ sơ" target="_blank"
            href="{{ url($inputs['url_xd'] . 'QuaTrinhXuLyHoSo?mahosotdkt=' . $tt->mahosotdkt) }}"
            class="btn btn-sm btn-clean btn-icon">
            <i class="icon-lg la flaticon-list-1 text-dark"></i>
        </a>
    @endif
@else
    @if (chkPhanQuyen($inputs['phanquyen'], 'tiepnhan'))
        @if (in_array($tt->trangthai_hoso, ['CD']))
            <button title="Tiếp nhận hồ sơ" type="button"
                onclick="confirmNhan('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'NhanHoSo' }}','{{ $inputs['madonvi'] }}')"
                class="btn btn-sm btn-clean btn-icon" data-target="#nhan-modal-confirm" data-toggle="modal">
                <i class="icon-lg flaticon-interface-5 text-success"></i>
            </button>
        @endif

        @if (in_array($tt->trangthai_hoso, ['DTN', 'CD', 'BTLXD', 'KDK']))
            {{-- @if ($tt->thaotac_tralai) --}}
            <button title="Huỷ tiếp nhận và trả lại hồ sơ" type="button"
                onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
                class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai" data-toggle="modal">
                <i class="icon-lg la la-reply text-danger"></i>
            </button>
        @endif
    @endif
    {{-- @if (in_array($tt->trangthai_hoso, ['DTN', 'BTLXD', 'BTL']) && $tt->thaotac && chkPhanQuyen($inputs['phanquyen'], 'xuly'))
        <button title="Xử lý hồ sơ" type="button"
            onclick="confirmXuLyHoSo_DiaBan('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}','{{$tt->dieukien_hs == true?1:0}}','{{$tt->trangthai_xl}}', '{{ $inputs['url_xd'] . 'XuLyHoSo' }}','{{ $tt->tendangnhap_xl }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#modal-xulyhoso-diaban" data-toggle="modal">
            <i class="icon-lg la flaticon-list text-success"></i>
        </button>
    @endif --}}
    @if (in_array($tt->trangthai_hoso, ['DTN', 'BTLXD']) && chkPhanQuyen($inputs['phanquyen'], 'hoanthanh'))
        <button title="Chuyển xét duyệt khen thưởng" type="button"
            onclick="confirmTrinhHS('{{ $tt->mahosotdkt }}','{{ $inputs['url_xd'] . 'ChuyenHoSo' }}','{{ $inputs['madonvi'] }}')"
            class="btn btn-sm btn-clean btn-icon" {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}
            data-target="#trinhhs-modal" data-toggle="modal">
            <i class="icon-lg la fa-share-square text-success"></i>
        </button>
    @endif
    @if (chkPhanQuyen($inputs['phanquyen'], 'xuly'))
        <a title="Xem chi tiết xử lý hồ sơ" target="_blank"
            href="{{ url($inputs['url_xd'] . 'QuaTrinhXuLyHoSo?mahosotdkt=' . $tt->mahosotdkt) }}"
            class="btn btn-sm btn-clean btn-icon">
            <i class="icon-lg la flaticon-list-1 text-dark"></i>
        </a>
    @endif
@endif
