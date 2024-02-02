{{-- In dữ liệu --}}
<div id="indulieu-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    {!! Form::open(['url' => '', 'id' => 'frm_InDuLieu']) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
    <input type="hidden" name="phanloaihoso" value="{{ $inputs['phanloaihoso'] ?? 'dshosothiduakhenthuong' }}" />
    <input type="hidden" name="mahosotdkt" />
    <input type="hidden" name="maphongtraotd" />
    <input type="hidden" name="mahosothamgiapt" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin in dữ liệu</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <a onclick="setInPT($(this), '/PhongTraoThiDua/')"
                            class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                            <i class="la flaticon2-print"></i>Thông tin phong trào thi đua
                        </a>
                    </div>
                </div>

                <div id="div_inHoSo">
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInHS($(this), '/HoSoThiDua/')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Thông tin hồ sơ tham gia thi đua
                            </a>
                        </div>
                    </div>
                </div>

                <div id="div_inHoSoDN">
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInKT($(this), '/XetDuyetHoSoThiDua/')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Thông tin hồ sơ đề nghị khen thưởng
                            </a>
                        </div>
                    </div>

                    @if (session('admin')->opt_duthaototrinh)
                        <div class="row">
                            <div class="col-lg-12">
                                <a onclick="setInDuThao($(this), '/DungChung/DuThao/InToTrinhDeNghiKhenThuong')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>Tờ trình đề nghị khen thưởng
                                </a>
                            </div>
                        </div>
                    @endif                   

                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInKT($(this), '/KhenThuongHoSoThiDua/')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Thông tin hồ sơ quyết định khen thưởng
                            </a>
                        </div>
                    </div>
                </div>

                <div id="div_inDuLieu">
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInDL($(this), '{{ $inputs['url_qd'] . 'InToTrinhPheDuyet' }}')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Tờ trình khen thưởng
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <a id="btnInQD" onclick="setInQD($(this), '')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Quyết định khen thưởng
                            </a>
                        </div>
                    </div>

                    <div id="div_inPhoi">
                        <div class="row">
                            <div class="col-lg-12">
                                <a onclick="setInPhoi($(this), '{{ $inputs['url_qd'] . 'InPhoi' }}')"
                                    class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                    <i class="la flaticon2-print"></i>In phôi bằng khen, giấy khen
                                </a>
                            </div>
                        </div>
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

{{-- In phôi --}}
{!! Form::open(['url' => '', 'id' => 'frm_InPhoi', 'target' => '_blank']) !!}
<div id="modal-InPhoi" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    <input type="hidden" name="mahosokt" />
    <input type="hidden" name="phanloai" />
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Thông tin in dữ liệu</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div id="doituonginphoi" class="row">
                    <div class="col-lg-12">
                        <label class="form-control-label">Tên đối tượng</label>
                        {!! Form::select('tendoituong', setArrayAll([], 'Tất cả'), null, ['class' => 'form-control select2_modal']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Đóng</button>
                <button type="submit" class="btn btn-success">Hoàn thành</button>
            </div>
        </div>
    </div>

</div>
{!! Form::close() !!}

<script>
    function setInDuLieu(mahosothamgiapt, mahosotdkt, maphongtraotd, trangthai, inphoi = false) {
        $('#div_inDuLieu').hide();
        $('#div_inHoSo').hide();
        $('#div_inHoSoDN').hide();
        $('#frm_InDuLieu').find("[name='mahosotdkt']").val(mahosotdkt);
        $('#frm_InDuLieu').find("[name='maphongtraotd']").val(maphongtraotd);
        $('#frm_InDuLieu').find("[name='mahosothamgiapt']").val(mahosothamgiapt);
        if (mahosothamgiapt != '-1')
            $('#div_inHoSo').show();
        if (mahosotdkt != '-1')
            $('#div_inHoSoDN').show();
        if (trangthai == 'DKT') {
            $('#div_inDuLieu').show();
            if (inphoi)
                $('#div_inPhoi').show();
        }
    }

    function setInQD(e, url) {
        e.prop('href', '/KhenThuongHoSoThiDua/XemQuyetDinh?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']")
            .val());
    }

    function setInHS(e, url) {
        e.prop('href', url + 'Xem?mahosothamgiapt=' + $('#frm_InDuLieu').find("[name='mahosothamgiapt']").val());
    }

    function setInKT(e, url) {
        e.prop('href', url + 'Xem?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val());
    }

    function setInPT(e, url) {
        e.prop('href', url + 'Xem?maphongtraotd=' + $('#frm_InDuLieu').find("[name='maphongtraotd']").val());
    }

    function setInDL(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val());
    }

    function setInPhoi(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val() + '&madonvi=' + $(
            '#madonvi').val());
    }

    function setInDuThao(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val() + '&phanloaihoso=' +
            $('#frm_InDuLieu').find("[name='phanloaihoso']").val());
    }
    // function setInPhoi(url, phanloai) {
    //     $('#frm_InPhoi').attr('action', url);
    //     $('#frm_InPhoi').find("[name='mahosokt']").val($('#frm_InDuLieu').find("[name='mahosokt']").val());
    //     $('#frm_InPhoi').find("[name='phanloai']").val(phanloai);
    //     var formData = new FormData($('#frm_InPhoi')[0]);

    //     $.ajax({
    //         url: "/KhenThuongHoSoThiDua/LayDoiTuong",
    //         method: "POST",
    //         cache: false,
    //         dataType: false,
    //         processData: false,
    //         contentType: false,
    //         data: formData,
    //         success: function(data) {
    //             //console.log(data);               
    //             if (data.status == 'success') {
    //                 $('#doituonginphoi').replaceWith(data.message);
    //             }
    //         }
    //     });
    // }
</script>
