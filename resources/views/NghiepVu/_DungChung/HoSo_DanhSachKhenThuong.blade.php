<div class="row">
    <div class="col-md-12">
        <div class="card card-custom">
            <div class="card-header card-header-tabs-line">
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tapthe">
                                <span class="nav-icon">
                                    <i class="fas fa-users"></i>
                                </span>
                                <span class="nav-text">Khen thưởng tập thể</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_hogiadinh">
                                <span class="nav-icon">
                                    <i class="fas fa-users"></i>
                                </span>
                                <span class="nav-text">Khen thưởng hộ gia đình</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_canhan">
                                <span class="nav-icon">
                                    <i class="far fa-user"></i>
                                </span>
                                <span class="nav-text">Khen thưởng cá nhân</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tailieu">
                                <span class="nav-icon">
                                    <i class="far flaticon-folder-1"></i>
                                </span>
                                <span class="nav-text">Tài liệu đính kèm</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-toolbar">

                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="kt_tapthe" role="tabpanel" aria-labelledby="kt_tapthe">
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="setTapThe()" data-target="#modal-create-tapthe"
                                        data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm">
                                        <i class="fa fa-plus"></i></button>
                                    <button onclick="setNhanExcel('{{ $model->mahosotdkt }}')"
                                        title="Nhận từ file Excel" data-target="#modal-nhanexcel" data-toggle="modal"
                                        type="button" class="btn btn-info btn-icon btn-sm"><i
                                            class="fas fa-file-import"></i></button>
                                    <a target="_blank" title="Tải file mẫu" href="/data/download/MauTDKT.xlsx"
                                        class="btn btn-primary btn-icon btn-sm"><i class="fa flaticon-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="dskhenthuongtapthe">
                            <div class="col-md-12">
                                <table id="sample_4" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="5%">STT</th>
                                            <th>Tên tập thể</th>
                                            <th>Phân loại<br>đối tượng</th>
                                            <th>Danh hiệu thi đua/<br>Hình thức khen thưởng </th>
                                            <th>Loại hình khen thưởng</th>
                                            <th width="10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($model_tapthe as $key => $tt)
                                            <tr class="odd gradeX">
                                                <td class="text-center">{{ $i++ }}</td>
                                                <td>{{ $tt->tentapthe }}</td>
                                                <td>{{ $a_tapthe[$tt->maphanloaitapthe] ?? '' }}</td>
                                                <td class="text-center">
                                                    {{ $a_dhkt_tapthe[$tt->madanhhieukhenthuong] ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $a_loaihinhkt[$model->maloaihinhkt] ?? '' }}
                                                </td>

                                                <td class="text-center">
                                                    <button title="Sửa thông tin" type="button"
                                                        onclick="getTapThe('{{ $tt->id }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-create-tapthe" data-toggle="modal">
                                                        <i class="icon-lg la fa-edit text-primary"></i>
                                                    </button>
                                                    <button title="Xóa" type="button"
                                                        onclick="delKhenThuong('{{ $tt->id }}',  '{{ $inputs['url'] . 'XoaTapThe' }}', 'TAPTHE')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                        <i class="icon-lg la fa-trash text-danger"></i>
                                                    </button>
                                                    {{-- <button title="Tiêu chuẩn" type="button"
                                                        onclick="getTieuChuan('{{ $tt->id }}','TAPTHE','{{ $tt->tentapthe }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                                        <i class="icon-lg la fa-list text-dark"></i>
                                                    </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kt_hogiadinh" role="tabpanel" aria-labelledby="kt_tapthe">
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="setHoGiaDinh()"
                                        data-target="#modal-create-hogiadinh" data-toggle="modal"
                                        class="btn btn-light-dark btn-icon btn-sm">
                                        <i class="fa fa-plus"></i></button>
                                    <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                                        data-toggle="modal" type="button" class="btn btn-info btn-icon btn-sm"><i
                                            class="fas fa-file-import"></i></button>
                                    <a target="_blank" title="Tải file mẫu" href="/data/download/MauTDKT.xlsx"
                                        class="btn btn-primary btn-icon btn-sm"><i class="fa flaticon-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="dskhenthuonghogiadinh">
                            <div class="col-md-12">
                                <table id="sample_5" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="5%">STT</th>
                                            <th>Tên hộ gia đình</th>
                                            {{-- <th>Phân loại<br>đối tượng</th> --}}
                                            <th>Danh hiệu thi đua/<br>Hình thức khen thưởng </th>
                                            <th>Loại hình khen thưởng</th>
                                            <th width="10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($model_hogiadinh as $key => $tt)
                                            <tr class="odd gradeX">
                                                <td class="text-center">{{ $i++ }}</td>
                                                <td>{{ $tt->tentapthe }}</td>
                                                {{-- <td>{{ $a_hogiadinh[$tt->maphanloaitapthe] ?? '' }}</td> --}}
                                                <td class="text-center">
                                                    {{ $a_dhkt_hogiadinh[$tt->madanhhieukhenthuong] ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $a_loaihinhkt[$model->maloaihinhkt] ?? '' }}
                                                </td>

                                                <td class="text-center">
                                                    <button title="Sửa thông tin" type="button"
                                                        onclick="getHoGiaDinh('{{ $tt->id }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-create-hogiadinh" data-toggle="modal">
                                                        <i class="icon-lg la fa-edit text-primary"></i>
                                                    </button>
                                                    <button title="Xóa" type="button"
                                                        onclick="delKhenThuong('{{ $tt->id }}',  '{{ $inputs['url'] . 'XoaHoGiaDinh' }}', 'HOGIADINH')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                        <i class="icon-lg la fa-trash text-danger"></i>
                                                    </button>
                                                    {{-- <button title="Tiêu chuẩn" type="button"
                                                        onclick="getTieuChuan('{{ $tt->id }}','TAPTHE','{{ $tt->tentapthe }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                                        <i class="icon-lg la fa-list text-dark"></i>
                                                    </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kt_canhan" role="tabpanel" aria-labelledby="kt_canhan">
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group">
                                    <button title="Thêm đối tượng" type="button" data-target="#modal-create"
                                        data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm"
                                        onclick="setCaNhan()">
                                        <i class="fa fa-plus"></i></button>

                                    <button title="Nhận từ file Excel" data-target="#modal-nhanexcel"
                                        data-toggle="modal" type="button" class="btn btn-info btn-icon btn-sm"><i
                                            class="fas fa-file-import"></i></button>

                                    <a target="_blank" title="Tải file mẫu" href="/data/download/MauTDKT.xlsx"
                                        class="btn btn-primary btn-icon btn-sm"><i class="fa flaticon-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="dskhenthuongcanhan">
                            <div class="col-md-12">
                                <table id="sample_3" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="2%">STT</th>
                                            <th>Tên đối tượng</th>
                                            {{-- <th width="8%">Ngày sinh</th> --}}
                                            <th width="5%">Giới</br>tính</th>
                                            <th width="15%">Phân loại cán bộ</th>
                                            <th>Thông tin công tác</th>
                                            <th>Hình thức khen thưởng /<br>Danh hiệu thi đua</th>
                                            <th>Loại hình khen thưởng</th>
                                            <th width="10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($model_canhan as $key => $tt)
                                            <tr class="odd gradeX">
                                                <td class="text-center">{{ $i++ }}</td>
                                                <td>{{ $tt->tendoituong }}</td>
                                                {{-- <td class="text-center">{{ getDayVn($tt->ngaysinh) }}</td> --}}
                                                <td>{{ $tt->gioitinh }}</td>
                                                <td>{{ $a_canhan[$tt->maphanloaicanbo] ?? '' }}</td>
                                                <td class="text-center">
                                                    {{ $tt->chucvu . ',' . $tt->tenphongban . ',' . $tt->tencoquan }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $a_dhkt_canhan[$tt->madanhhieukhenthuong] ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $a_loaihinhkt[$model->maloaihinhkt] ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    <button title="Sửa thông tin" type="button"
                                                        onclick="getCaNhan('{{ $tt->id }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-create" data-toggle="modal">
                                                        <i class="icon-lg la fa-edit text-primary"></i>
                                                    </button>
                                                    <button title="Xóa" type="button"
                                                        onclick="delKhenThuong('{{ $tt->id }}',  '{{ $inputs['url'] . 'XoaCaNhan' }}', 'CANHAN')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-delete-khenthuong" data-toggle="modal">
                                                        <i class="icon-lg la fa-trash text-danger"></i>
                                                    </button>
                                                    {{-- <button title="Tiêu chuẩn" type="button"
                                                        onclick="getTieuChuan('{{ $tt->id }}','CANHAN','{{ $tt->tendoituong }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-tieuchuan" data-toggle="modal">
                                                        <i class="icon-lg la fa-list text-dark"></i>
                                                    </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kt_tailieu" role="tabpanel" aria-labelledby="kt_tailieu">
                        <div class="form-group row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group">
                                    <button title="Thêm đối tượng" type="button" data-target="#modal-tailieu"
                                        data-toggle="modal" class="btn btn-light-dark btn-icon btn-sm"
                                        onclick="setTaiLieu()">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="dstailieu">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover dulieubang">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="2%">STT</th>
                                            <th width="20%">Đơn vị tải lên</th>
                                            <th width="20%">Phân loại tài liệu</th>
                                            <th>Nội dung tóm tắt</th>
                                            <th width="15%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($model_tailieu as $key => $tt)
                                            <tr class="odd gradeX">
                                                <td class="text-center">{{ $i++ }}</td>
                                                <td>{{ $a_donvi[$tt->madonvi] ?? $tt->madonvi }}</td>
                                                <td>{{ $a_pltailieu[$tt->phanloai] ?? $tt->phanloai }}</td>
                                                <td class="text-center">{{ $tt->noidung }}</td>

                                                <td class="text-center">
                                                    <button title="Sửa thông tin" type="button"
                                                        onclick="getTaiLieu('{{ $tt->id }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-tailieu" data-toggle="modal">
                                                        <i class="icon-lg la fa-edit text-primary"></i>
                                                    </button>
                                                    <button title="Xóa" type="button"
                                                        onclick="delTaiLieu('{{ $tt->id }}')"
                                                        class="btn btn-sm btn-clean btn-icon"
                                                        data-target="#modal-delete-tailieu" data-toggle="modal">
                                                        <i class="icon-lg la fa-trash text-danger"></i>
                                                    </button>
                                                    @if ($tt->tentailieu != '')
                                                        <a target="_blank" title="Tải file đính kèm"
                                                            href="{{ '/data/tailieudinhkem/' . $tt->tentailieu }}"
                                                            class="btn btn-clean btn-icon btn-sm"><i
                                                                class="fa flaticon-download text-info"></i>
                                                        </a>
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
            </div>
        </div>
    </div>
</div>
