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
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    <script type="text/javascript">
        var changed = false;
        let browseFile = $('#browseFile');

        let progress = $('.progress');

        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)
        }

        function hideProgress() {
            progress.hide();
        }
    </script>

    <script>
        $('#edit').on('hidden.bs.modal', function() {
            if (changed) {
                location.reload();
            }
            $('#video-link').removeAttr('value');
            $('#videoPreview').removeAttr('src');
            $('#browseFile').html('Chọn Tệp');
            $('#videoPreview').hide();
        });
    </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Danh sách tài liệu hướng dẫn</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @if (session()->has('admin') && chkPhanQuyen('tailieuhuongdan', 'thaydoi'))
                    <button type="button" class="btn btn-success btn-xs" data-target="#taohoso-modal" data-toggle="modal">
                        <i class="fa fa-plus"></i>&nbsp;Thêm mới</button>
                @endif
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            {{-- <div class="form-group row">
                <div class="col-9">
                    <label style="font-weight: bold">Đơn vị</label>
                    <select class="form-control select2basic" id="madonvi">
                        @foreach ($a_diaban as $key => $val)
                            <optgroup label="{{ $val }}">
                                <?php $donvi = $m_donvi->where('madiaban', $key); ?>
                                @foreach ($donvi as $ct)
                                    <option {{ $ct->madonvi == $inputs['madonvi'] ? 'selected' : '' }}
                                        value="{{ $ct->madonvi }}">{{ $ct->tendonvi }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <label style="font-weight: bold">Năm</label>
                    {!! Form::select('nam', getNam(), $inputs['nam'], ['class' => 'form-control select2basic', 'id' => 'nam']) !!}

                </div>
            </div> --}}

            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">STT</th>
                                <th>Tên tài liệu</th>
                                <th>File văn bản</th>
                                <th>Video</th>
                                @if (chkPhanQuyen('tailieuhuongdan', 'thaydoi'))
                                    <th width="20%">Thao tác</th>
                                @endif

                            </tr>
                        </thead>
                        <?php $i = 1; ?>
                        @foreach ($model as $key => $tt)
                            <tr>
                                <td style="text-align: center">{{ $i++ }}</td>
                                <td class="active" name="tentailieu">{{ $tt->tentailieu }}</td>
                                <td class="active">
                                    <a target = "_blank"
                                        href = "{{ url('/data/tailieuhuongdan/' . $tt->noidung) }}">{{ $tt->noidung }}</a>
                                </td>
                                <td name='video' style="width: 15%">
                                    @if ($tt->link1 && Illuminate\Support\Facades\File::exists($tt->link1))
                                        <video controls width="100%">
                                            <source src="{{ url($tt->link1) }}">
                                        </video>
                                    @endif
                                </td>
                                {{-- <td class="active">{{ $tt->noidung }}</td> --}}
                                @if (chkPhanQuyen('tailieuhuongdan', 'thaydoi'))
                                <td class=" text-center">
                                    {{-- @if (chkPhanQuyen('quykhenthuong', 'thaydoi')) --}}
                                    {{-- <a title="Thông tin hồ sơ"
                                        href="{{ url($inputs['url'] . 'Sua?matailieu=' . $tt->matailieu) }}"
                                        data-target="#edit" data-toggle="modal" class="btn btn-sm btn-clean btn-icon">
                                        <i class="icon-lg la flaticon-edit-1 text-success"></i>
                                    </a> --}}

                                        <button title="Sửa thông tin"
                                            onclick="edit(this,'{{ $tt->id }}', '{{ $tt->noidung }}','{{ $tt->link1 }}', '{{ $tt->link2 }}')"
                                            data-target="#edit" data-toggle="modal" class="btn btn-sm btn-clean btn-icon">
                                            <i class="icon-lg la flaticon-edit-1 text-primary "></i>
                                        </button>

                                        <button type="button"
                                            onclick="confirmDelete('{{ $tt->id }}','{{ $inputs['url'] . 'Xoa' }}')"
                                            class="btn btn-sm btn-clean btn-icon" data-target="#delete-modal-confirm"
                                            data-toggle="modal">
                                            <i class="icon-lg la fa-trash text-danger"></i>
                                        </button>

                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->

    <!--Modal Tạo hồ sơ-->
    {!! Form::open(['url' => $inputs['url'] . 'Them', 'id' => 'frm_hoso', 'files' => true]) !!}
    <div id="taohoso-modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 id="modal-header-primary-label" class="modal-title">Thông tin tài liệu hướng dẫn</h4>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Tên tài liệu</label>
                            {!! Form::text('tentailieu', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>File tài liệu</label>
                            {{-- {!! Form::file('noidung', null, ['class' => 'form-control','accept'=>'.pdf,.doc,.docx,.xls,.xlsx']) !!} --}}
                            <input type="file" name='noidung' accept=".pdf,.doc,.docx,.xls,.xlsx">
                        </div>
                        <div class="col-lg-12">
                            <span class="text-danger">* Chỉ sử dụng cho các file: pdf, wolrd, excel</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Hủy thao tác</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!--Cập nhật -->
    <div id="edit" tabindex="-1" role="dialog" aria-hidden="true" class="modal fade kt_select2_modal">
        <form action="" method="POST" id="frm_edit" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <h4 id="modal-header-primary-label" class="modal-title">Thông tin tài liệu hướng dẫn
                        </h4>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12 mb-5">
                                <label class="control-label">Tên tài liệu<span class="require">*</span></label>
                                <input type="text" name="tentailieu" id="tentailieu" class="form-control" required>
                            </div>

                            {{-- <div class="col-md-12 mb-5">
                                    <label class="control-label">Số thứ tự của bài học</label>
                                    <input type="text" name="stt" id="stt" class="form-control">
                                </div> --}}

                            <div class="col-md-12 mb-5">
                                <label class="control-label">Video</label>
                                <div class="col-md-12">
                                    <video id="videoPreview" src="" controls
                                        style="width: 100%; height: auto; display: none;"></video>
                                </div>
                                <div id="upload-container" class="text-center">
                                    <button type="button" id="browseFile" class="btn btn-outline-primary">Chọn
                                        Tệp</button>
                                    <button type="button" id="delFile" class="btn btn-outline-danger">Xóa
                                        video</button>
                                </div>
                                <div style="display: none" class="progress mt-3" style="height: 25px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 75%; height: 100%">75%</div>
                                </div>
                            </div>

                            {{-- <div class="col-md-12">
                                <label class="control-label">Ảnh nền của video</label>
                                <input class="form-control" type="file" id="link2" name="anh-nen-video"
                                    accept="image/*">
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default" id="cancel-edit">Hủy thao
                            tác</button>
                        <button type="submit" data-dismiss="modal" class="btn btn-primary" id="submit-edit"
                            onclick="clickedit()">Đồng
                            ý</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('includes.modal.modal-delete')
    <script>
        function clickedit() {
            $('#frm_edit').submit();
        }



        function edit(e, id, noidung, link1, link2) {
            var url = '/TaiLieuHuongDan/update/' + id;
            var tr = $(e).closest('tr');
            var baseURL = window.location.origin + "/";

            $('#tentailieu').val($(tr).find('td[name=tentailieu]').text());
            // $('#stt').val($(tr).find('td[name=stt]').text());
            if (link1 != '') {
                $('#video-link').val(link1);
                $('#videoPreview').attr('src', baseURL + link1);
                $('#browseFile').html('Thay Đổi')
                $('#videoPreview').show();
            }

            var resumable = new Resumable({
                target: "{{ '/TaiLieuHuongDan/uploadvideo/' }}" + id,
                query: {
                    _token: '{{ csrf_token() }}',
                }, // CSRF token
                fileType: ['mp4'],
                chunkSize: 10 * 1024 *
                    1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
                headers: {
                    'Accept': 'application/json'
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });

            resumable.assignBrowse(browseFile[0]);

            resumable.on('fileAdded', function(file) { // trigger when file picked
                showProgress();
                resumable.upload() // to actually start uploading.
                $('#submit-edit').attr('disabled', '');
                $('#cancel-edit').attr('disabled', '');
                $('#edit').attr('data-bs-backdrop', 'static');
                $('.close').removeAttr('data-dismiss');
            });

            resumable.on('fileProgress', function(file) { // trigger when file progress update
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
                response = JSON.parse(response);
                $('#videoPreview').attr('src', response.path + '/' + response.name);
                $('#videoPreview').show();
                $('#browseFile').html('Thay Đổi');
                $('#submit-edit').removeAttr('disabled');
                $('.progress').hide();
                $('#cancel-edit').removeAttr('disabled', '');
                $('#edit').removeAttr('data-bs-backdrop');
                $('.close').attr('data-dismiss', 'modal');
                changed = true;
                resumable.removeFile(file);
            });

            resumable.on('fileError', function(file, response) { // trigger when there is any error
                alert('Tệp tải lên KHÔNG thành công. Lỗi không xác định');
                console.log(response);
                $('#submit-edit').removeAttr('disabled');
                $('#cancel-edit').removeAttr('disabled', '');
                $('#edit').removeAttr('data-bs-backdrop');
                $('.close').attr('data-dismiss', 'modal');
                $('.progress').hide();
            });

            $('#frm_edit').attr('action', url);

            $('#delFile').on('click', function() {
                var url = '/TaiLieuHuongDan/XoaVideo/' + id;
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        window.location.reload();
                    }
                });
            })
        }
    </script>
@stop
