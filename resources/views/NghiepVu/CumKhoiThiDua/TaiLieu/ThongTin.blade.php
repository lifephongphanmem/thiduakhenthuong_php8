@extends('HeThong.main')

@section('custom-style')
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/dataTables.bootstrap.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/pages/select2.css') }}" /> --}}
@stop

@section('custom-script-footer')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/assets/js/pages/select2.js"></script>
    <script src="/assets/js/pages/jquery.dataTables.min.js"></script>
    <script src="/assets/js/pages/dataTables.bootstrap.js"></script>
    <script src="/assets/js/pages/table-lifesc.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script>
        jQuery(document).ready(function() {
            TableManaged3.init();
            $('#loaivb').change(function() {
                window.location.href = "{{ $inputs['url'] }}" + "ThongTin?loaivb=" + $('#loaivb').val();
            });
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách tài liệu, văn bản ban hành trong cụm, khối thi đua</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (chkPhanQuyen('vanbanphaply', 'thaydoi'))
                    <a type="button" href="{{ url($inputs['url'] . 'Them') }}" class="btn btn-success btn-xs">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới
                    </a>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="form-group row">
                <div class="col-lg-6">
                    <label>Loại văn bản</label>
                    {!! Form::select('loaivb', setArrayAll(getLoaiVanBan()), $inputs['loaivb'], [
                        'id' => 'loaivb',
                        'class' => 'form-control select2basic',
                    ]) !!}
                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th width="15%">Đơn vị ban hành</th>
                                <th>Số hiệu<br>văn bản</th>
                                <th>Nội dung</th>
                                <th>Ngày<br>áp dụng</th>
                                <th>Trạng thái</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td class="active">{{ $tt->dvbanhanh }}</td>
                                    <td class="text-center">{{ $tt->kyhieuvb }}<br>{{ getDayVn($tt->ngayqd) }}</td>
                                    <td>{{ $tt->tieude }}</td>
                                    <td style="text-align: center">{{ getDayVn($tt->ngayapdung) }}</td>
                                    <td style="text-align: center">{{ $a_tinhtrang[$tt->tinhtrang] ?? '' }}
                                        @if ($tt->vanbanbosung != '')
                                            <br>Văn bản bổ sung, thế thế: {{ $tt->vanbanbosung }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" onclick="get_attack('{{ $tt->mavanban }}','{{ $inputs['url'] . 'TaiLieuDinhKem' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#dinhkem-modal-confirm"
                                            data-toggle="modal" title="Tải văn bản">
                                            <i class="icon-lg la flaticon-download text-dark"></i>
                                        </button>

                                        @if (chkPhanQuyen('dsvanbancumkhoi', 'thaydoi'))
                                            <a href="{{ url($inputs['url'] . 'Sua?mavanban=' . $tt->mavanban) }}"
                                                class="btn btn-sm btn-clean btn-icon" title="Sửa thông tin">
                                                <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                            </a>

                                            <button type="button"
                                                onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                                class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                                data-toggle="modal" title="Xóa văn bản">
                                                <i class="icon-lg la flaticon-delete text-danger"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    @include('includes.modal.modal_attackfile')
    @include('includes.modal.modal-delete')
@stop
