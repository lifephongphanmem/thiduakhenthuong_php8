<!--Modal Tao hồ sơ đề nghị-->
{!! Form::open(['url' => $inputs['url_hs'] . 'ThemKT', 'id' => 'frm_hoso', 'files' => true]) !!}
<input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
<input type="hidden" name="maphongtraotd" value="{{ $inputs['maphongtraotd'] }}" />
<div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 id="modal-header-primary-label" class="modal-title">Đồng ý tạo hồ sơ trình khen thưởng?</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-custom">
                            <div class="card-header card-header-tabs-line">
                                <div class="card-toolbar">
                                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#kt_thongtinchung">
                                                <span class="nav-icon">
                                                    <i class="fas fa-users"></i>
                                                </span>
                                                <span class="nav-text">Thông tin chung</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#kt_hoso">
                                                <span class="nav-icon">
                                                    <i class="fas fa-users"></i>
                                                </span>
                                                <span class="nav-text">Danh sách hồ sơ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-toolbar"></div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="kt_thongtinchung" role="tabpanel"
                                        aria-labelledby="kt_thongtinchung">

                                        @if ($inputs['trangthai'] != 'CC')
                                            <div class="form-group row">
                                                <div id="donvixetduyet" class="col-6">
                                                    <label>Đơn vị xét duyệt</label>
                                                    {!! Form::select('madonvi_xd', setArrayAll($a_donviql, 'Chọn đơn vị', 'ALL'), 'ALL', [
                                                        'onchange' => 'getDonViKhenThuong_ThemHS($(this))',
                                                        'id' => 'madonvi_xd_themhs',
                                                        'class' => 'form-control select2_modal',
                                                        'required',
                                                    ]) !!}
                                                </div>

                                                <div id="donvikhenthuong" class="col-6">
                                                    <label>Đơn vị khen thưởng</label>
                                                    {!! Form::select('madonvi_kt', ['ALL' => 'Chọn đơn vị'], null, [
                                                        'id' => 'madonvi_kt_themhs',
                                                        'class' => 'form-control select2_modal',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>Số tờ trình</label>
                                                {!! Form::text('sototrinh', null, ['class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Ngày tạo hồ sơ</label>
                                                {!! Form::input('date', 'ngayhoso', date('Y-m-d'), ['class' => 'form-control']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>Chức vụ người ký tờ trình</label>
                                                {!! Form::text('chucvunguoiky', null, ['class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Họ tên người ký tờ trình</label>
                                                {!! Form::text('nguoikytotrinh', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>Nội dung trình khen thưởng</label>
                                                {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="kt_hoso" role="tabpanel" aria-labelledby="kt_hoso">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <table
                                                    class="table table-striped table-bordered table-hover dulieubang">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th width="2%">STT</th>
                                                            <th width="20%">Đơn vị tham gia</th>
                                                            <th>Nội dung hồ sơ</th>
                                                            <th width="8%">Ngày tháng</th>
                                                            {{-- <th width="8%">Trạng thái</th>                                                             --}}
                                                            <th width="5%">Thao tác</th>
                                                        </tr>
                                                    </thead>

                                                    <?php $i = 1; ?>
                                                    @foreach ($model_hoso as $key => $tt)
                                                        <tr>
                                                            <td class="text-center">{{ $i++ }}</td>
                                                            <td>{{ $a_donvi[$tt->madonvi] ?? '' }}</td>
                                                            <td>{{ $tt->noidung }}</td>
                                                            <td class="text-center">
                                                                {{ $tt->sototrinh }}<br>{{ getDayVn($tt->ngayhoso) }}
                                                            </td>
                                                            {{-- @include('includes.td.td_trangthai_hoso') --}}
                                                            
                                                            <td class="text-center">
                                                                <input type="checkbox"
                                                                    name="{{ 'hoso[' . $tt->mahosothamgiapt . ']' }}"
                                                                    checked />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <div class="col-lg-12">
                        <label>Phong trào thi đua</label>
                        {!! Form::select('maphongtraotd', $a_phongtraotd, null, ['class' => 'form-control']) !!}
                    </div>
                </div> --}}



                {{-- <div class="form-group row">
                    <div class="col-12">
                        <label>Tờ trình: </label>
                        {!! Form::file('totrinh', null, ['id' => 'totrinh', 'class' => 'form-control']) !!}
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                <button type="submit" onclick="chkThongTinHoSo()" class="btn btn-primary">Đồng ý</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script>
    function confirmKhenThuong(maphongtraotd) {
        $('#frm_hoso').find("[name='maphongtraotd']").val(maphongtraotd).trigger('change');
    }

    function getDonViKhenThuong_ThemHS(e) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "/DungChung/getDonViKhenThuong_ThemHS",
            type: 'GET',
            data: {
                _token: CSRF_TOKEN,
                madonvi: e.val(),
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 'success') {
                    $('#donvikhenthuong').replaceWith(data.message);
                }
            }
        });
    }

    function chkThongTinHoSo() {
        var ok = true,
            message = '';

        if ($('#madonvi_xd_themhs')[0] && $('#madonvi_xd_themhs').val() == 'ALL') {
            ok = false;
            message += 'Đơn vị xét duyệt đề nghị không được bỏ trống. \n';
        }

        if ($('#madonvi_kt_themhs')[0] && $('#madonvi_kt_themhs').val() == 'ALL') {
            ok = false;
            message += 'Đơn vị phê duyệt đề nghị không được bỏ trống. \n';
        }

        //Kết quả
        if (ok == false) {
            toastr.error(message, "Lỗi!");
            $("#frm_hoso").submit(function(e) {
                e.preventDefault();
            });
        } else {
            $("#frm_hoso").unbind('submit').submit();
        }
    }
</script>
