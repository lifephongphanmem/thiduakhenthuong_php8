@if (in_array($tt->trangthai_hoso, ['DD', 'CD', 'CXKT']))
    {{-- @if (session('admin')->opt_quytrinhkhenthuong == 'TAIKHOAN')
        <button title="Trả lại hồ sơ" type="button"
            onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLaiQuyTrinhTaiKhoan' }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai" data-toggle="modal">
            <i class="icon-lg la la-reply text-danger"></i>
        </button>
    @else --}}
        <button title="Trả lại hồ sơ" type="button"
            onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_xd'] . 'TraLai' }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai" data-toggle="modal">
            <i class="icon-lg la la-reply text-danger"></i>
        </button>
    {{-- @endif --}}
@endif

@if (in_array($tt->trangthai_hoso, ['CXKT']))
    @if (session('admin')->opt_duthaototrinh)
        <a title="Tạo dự thảo tờ trình kết quả khen thưởng" target="_blank"
            href="{{ url('/DungChung/DuThao/ToTrinhKetQuaKhenThuong?mahosotdkt=' . $tt->mahosotdkt) }}"
            class="btn btn-sm btn-clean btn-icon">
            {{-- class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}"> --}}
            <i class="icon-lg la flaticon-clipboard text-success"></i>
        </a>
    @endif

    <a title="Tờ trình kết quả khen thưởng"
        href="{{ url($inputs['url_xd'] . 'TrinhKetQua?mahosotdkt=' . $tt->mahosotdkt) }}"
        class="btn btn-sm btn-clean btn-icon">
        <i class="icon-lg la flaticon-list-1 text-success"></i>
    </a>
@endif
