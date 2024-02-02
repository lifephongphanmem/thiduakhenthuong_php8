@if (in_array($tt->trangthai, ['CXKT', 'CC', 'BTL', 'CXD']))
    @if (chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'thaydoi'))
        <a href="{{ url($inputs['url_hs'] . 'Sua?mahosotdkt=' . $tt->mahosotdkt) }}"
            class="btn btn-icon btn-clean btn-lg mb-1 position-relative" title="Thông tin hồ sơ khen thưởng">
            <span class="svg-icon svg-icon-xl">
                <i class="icon-lg la flaticon-list text-success"></i>
            </span>
            <span
                class="label label-sm label-light-danger text-dark label-rounded font-weight-bolder position-absolute top-0 right-0">{{ $tt->soluongkhenthuong }}</span>
        </a>

        @if (session('admin')->opt_duthaototrinh)
            <a title="Tạo dự thảo tờ trình"
                href="{{ url($inputs['url_hs'] . 'ToTrinhHoSo?mahosotdkt=' . $tt->mahosotdkt) }}"
                class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                <i class="icon-lg la flaticon-edit-1 text-success"></i>
            </a>
        @endif

        @if ($inputs['trangthai'] == 'DKT' && session('admin')->opt_duthaoquyetdinh)
            <a title="Tạo dự thảo quyết định khen thưởng"
                href="{{ url($inputs['url_hs'] . 'QuyetDinh?mahosotdkt=' . $tt->mahosotdkt) }}"
                class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                <i class="icon-lg la flaticon-edit-1 text-success"></i>
            </a>
        @endif

        @if ($tt->trangthai == 'BTL')
            <button title="Trình hồ sơ đăng ký" type="button"
                onclick="confirmChuyen('{{ $tt->mahosotdkt }}','{{ $inputs['url_hs'] . 'ChuyenHoSo' }}', '{{ $tt->phanloai }}','{{ $tt->madonvi_xd }}')"
                class="btn btn-sm btn-clean btn-icon">
                <i class="icon-lg la fa-share text-primary"></i>
            </button>

            <button title="Lý do hồ sơ bị trả lại" type="button"
                onclick="viewLyDo('{{ $tt->mahosotdkt }}','{{ $inputs['madonvi'] }}', '{{ $inputs['url_hs'] . 'LayLyDo' }}')"
                class="btn btn-sm btn-clean btn-icon" data-target="#tralai-modal" data-toggle="modal">
                <i class="icon-lg la flaticon2-information text-info"></i>
            </button>
        @endif

        <button type="button" onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url_hs'] . 'Xoa' }}')"
            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm" data-toggle="modal">
            <i class="icon-lg la fa-trash text-danger"></i>
        </button>
    @endif

    {{-- @if (chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'hoanthanh'))
                                                <a title="Phê duyệt hồ sơ khen thưởng"
                                                    href="{{ url($inputs['url_hs'] . 'PheDuyet?mahosotdkt=' . $tt->mahosotdkt) }}"
                                                    class="btn btn-sm btn-clean btn-icon {{ $tt->soluongkhenthuong == 0 ? 'disabled' : '' }}">
                                                    <i class="icon-lg la flaticon-interface-10 text-success"></i>
                                                </a>
                                            @endif --}}
@endif

{{-- @if ($tt->trangthai == 'DKT' && chkPhanQuyen('dshosodenghikhenthuongcongtrang', 'hoanthanh'))
                                            <button title="Hủy phê duyệt hồ sơ khen thưởng" type="button"
                                                onclick="setHuyPheDuyet('{{ $tt->mahosotdkt }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#modal-HuyPheDuyet"
                                                data-toggle="modal">
                                                <i class="icon-lg la flaticon-interface-10 text-danger"></i>
                                            </button>
                                        @endif --}}
