{{-- In dữ liệu --}}
<div id="indulieu-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    {!! Form::open(['url' => '', 'id' => 'frm_InDuLieu']) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <input type="hidden" name="phanloaihoso" value="{{ $inputs['phanloaihoso'] }}" />
    <input type="hidden" name="mahosotdkt" />
    <input type="hidden" name="maphongtraotd" />
    <input type="hidden" name="mahosokt" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin in dữ liệu</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                {{-- <div class="row">
                    <div class="col-lg-12">
                        <a onclick="setInPT($(this), '')"
                            class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                            <i class="la flaticon2-print"></i>Thông tin phong trào thi đua
                        </a>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-lg-12">
                        <a onclick="setInDL($(this), '{{ $inputs['url_hs'] . 'InHoSo' }}')"
                            class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                            <i class="la flaticon2-print"></i>Thông tin hồ sơ đề nghị khen thưởng
                        </a>
                    </div>
                </div>

                @if (session('admin')->hskhenthuong_totrinh)
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInDuThao($(this), '/DungChung/DuThao/InToTrinhDeNghiKhenThuong')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Tờ trình đề nghị khen thưởng
                            </a>
                        </div>
                    </div>
                @endif


                <div id="div_inDuLieu">
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInDL($(this), '{{ $inputs['url_hs'] . 'InHoSoKT' }}')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Thông tin hồ sơ phê duyệt khen thưởng
                            </a>
                        </div>
                    </div>

                    @if (session('admin')->opt_duthaototrinh)
                        <div class="row">
                            <div class="col-lg-12">
                                <a onclick="setInDuThao($(this), '/DungChung/DuThao/InToTrinhKetQuaKhenThuong')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>Tờ trình phê duyệt đề nghị khen thưởng
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (session('admin')->opt_duthaoquyetdinh)
                        <div class="row">
                            <div class="col-lg-12">
                                <a id="btnInQD"
                                    onclick="setInDuThao($(this), '/DungChung/DuThao/InQuyetDinhKhenThuong')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>Quyết định khen thưởng
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <div id="div_inPhoi">
                    <div class="row">
                        <div class="col-lg-12">
                            @if ($inputs['phanloaikhenthuong'] == 'CUMKHOI')
                                <a onclick="setInPhoi($(this), '/DungChung/InPhoiCumKhoi/DanhSach')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>In phôi bằng khen, giấy khen
                                </a>
                            @else
                                <a onclick="setInPhoi($(this), '/DungChung/InPhoiKhenThuong/DanhSach')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>In phôi bằng khen, giấy khen
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a onclick="setInLichSu($(this), '/DungChung/InLichSuHoSo')"
                            class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                            <i class="la flaticon2-print"></i>In lịch sử hồ sơ
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>


<script>
    function setInDuLieu(mahosotdkt, maphongtraotd, trangthai, inphoi = false) {
        $('#div_inDuLieu').hide();
        $('#div_inPhoi').hide();
        $('#frm_InDuLieu').find("[name='mahosotdkt']").val(mahosotdkt);
        $('#frm_InDuLieu').find("[name='maphongtraotd']").val(maphongtraotd);
        if (trangthai == 'DKT') {
            $('#div_inDuLieu').show();
            if (inphoi)
                $('#div_inPhoi').show();
        }
    }

    function setInDL(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val());
    }

    function setInDuThao(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val() + '&phanloaihoso=' +
            $('#frm_InDuLieu').find("[name='phanloaihoso']").val());
    }

    function setInPhoi(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val() + '&madonvi=' + $(
            '#madonvi').val());
    }

    function setInLichSu(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val() + '&phanloaihoso=' +
            $('#frm_InDuLieu').find("[name='phanloaihoso']").val());
    }
</script>
