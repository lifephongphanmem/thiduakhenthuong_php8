@if ($tt->trangthai == 'CXKT')
    @if (session('admin')->opt_duthaoquyetdinh)
        <a title="Tạo dự thảo quyết định khen thưởng" target="_blank"
            href="{{ url('/DungChung/DuThao/QuyetDinhKhenThuong?mahosotdkt=' . $tt->mahosotdkt . '&phanloaihoso=' . $inputs['phanloaihoso']) }}"
            class="btn btn-sm btn-clean btn-icon">
            {{-- class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}"> --}}
            <i class="icon-lg la flaticon-edit-1 text-success"></i>
        </a>
    @endif

    <a title="Phê duyệt hồ sơ khen thưởng" href="{{ url($inputs['url_qd'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
        class="btn btn-sm btn-clean btn-icon">
        <i class="icon-lg la flaticon-interface-10 text-success"></i>
    </a>

    <button title="Trả lại hồ sơ" type="button"
        onclick="confirmTraLai('{{ $tt->mahosotdkt }}', '{{ $inputs['madonvi'] }}', '{{ $inputs['url_qd'] . 'TraLai' }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#modal-tralai" data-toggle="modal">
        <i class="icon-lg la la-reply text-danger"></i>
    </button>

    @if ($tt->chinhsua)
        <button type="button" onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_qd'] . 'Xoa' }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm" data-toggle="modal">
            <i class="icon-lg la fa-trash text-danger"></i>
        </button>
    @endif
@endif

@if ($tt->trangthai == 'DKT')
    <button title="Hủy phê duyệt hồ sơ khen thưởng" type="button" onclick="setHuyPheDuyet('{{ $tt->mahosotdkt }}')"
        class="btn btn-sm btn-clean btn-icon" data-target="#modal-HuyPheDuyet" data-toggle="modal">
        <i class="icon-lg la flaticon-interface-10 text-danger"></i>
    </button>
@endif
