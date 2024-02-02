{{-- In dữ liệu --}}
<div id="indulieu-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade">
    {!! Form::open(['url' => '', 'id' => 'frm_InDuLieu']) !!}
    <input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
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
                            <i class="la flaticon2-print"></i>Thông tin hồ sơ đề nghị
                        </a>
                    </div>
                </div>
                
                <div id="div_inDuLieu">
                    <div class="row">
                        <div class="col-lg-12">
                            <a onclick="setInDL($(this), '{{ $inputs['url_qd'] . 'InHoSo'}}')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Thông tin hồ sơ khen thưởng
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <a id="btnInQD" onclick="setInDL($(this), '{{ $inputs['url_qd'] . 'InQuyetDinh'}}')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" target="_blank">
                                <i class="la flaticon2-print"></i>Quyết định khen thưởng
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" onclick="setInPhoi('{{ $inputs['url_qd'] . 'InBangKhen' }}', 'TAPTHE')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi bằng khen(Tập thể)
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" onclick="setInPhoi('{{ $inputs['url_qd'] . 'InBangKhen' }}', 'CANHAN')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi bằng khen(Cá nhân)
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" onclick="setInPhoi('{{ $inputs['url_qd'] . 'InGiayKhen' }}', 'TAPTHE')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi giấy khen(Tập thể)
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" onclick="setInPhoi('{{ $inputs['url_qd'] . 'InGiayKhen' }}', 'CANHAN')"
                                class="btn btn-sm btn-clean text-dark font-weight-bold" data-target="#modal-InPhoi"
                                data-toggle="modal">
                                <i class="la flaticon2-print"></i>In phôi giấy khen(Cá nhân)
                            </button>
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
    <input type="hidden" name="mahosotdkt" />
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
    
    function setInDuLieu(mahosotdkt, maphongtraotd, trangthai) {
        $('#div_inDuLieu').hide();
        $('#frm_InDuLieu').find("[name='mahosotdkt']").val(mahosotdkt);
        $('#frm_InDuLieu').find("[name='maphongtraotd']").val(maphongtraotd);
        if (trangthai == 'DKT')
            $('#div_inDuLieu').show();
    }

    function setInDL(e, url) {
        e.prop('href', url + '?mahosotdkt=' + $('#frm_InDuLieu').find("[name='mahosotdkt']").val());
    }

    function setInPhoi(url, phanloai) {
        $('#frm_InPhoi').attr('action', url);
        $('#frm_InPhoi').find("[name='mahosotdkt']").val($('#frm_InDuLieu').find("[name='mahosotdkt']").val());
        $('#frm_InPhoi').find("[name='phanloai']").val(phanloai);
        var formData = new FormData($('#frm_InPhoi')[0]);

        $.ajax({
            url: "{{$inputs['url_qd']}}" + "LayDoiTuong",
            method: "POST",
            cache: false,
            dataType: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function(data) {
                //console.log(data);               
                if (data.status == 'success') {
                    $('#doituonginphoi').replaceWith(data.message);
                }
            }
        });
    }

    // function setPheDuyet(mahosotdkt) {
    //     $('#frm_PheDuyet').find("[name='mahosotdkt']").val(mahosotdkt);
    // }

    // function setHuyPheDuyet(mahosotdkt) {
    //     $('#frm_HuyPheDuyet').find("[name='mahosotdkt']").val(mahosotdkt);
    // }
</script>
