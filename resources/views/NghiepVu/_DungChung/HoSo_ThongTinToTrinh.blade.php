<div class="form-group row">
    <div class="col-lg-6">
        <label>Số tờ trình</label>
        {!! Form::text('sototrinhdenghi', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-lg-6">
        <label>Ngày tháng trình<span class="require">*</span></label>
        {!! Form::input('date', 'ngaythangtotrinhdenghi', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-6">
        <label>Chức vụ người ký tờ trình</label>
        <div class="input-group">
            {!! Form::select(
                'chucvutotrinhdenghi',
                array_unique(array_merge([$model->chucvutotrinhdenghi => $model->chucvutotrinhdenghi], getChucVuKhenThuong())),
                null,
                ['class' => 'form-control', 'id' => 'chucvunguoikyqd'],
            ) !!}
            <div class="input-group-prepend">
                <button type="button" data-target="#modal-chucvu" data-toggle="modal"
                    class="btn btn-light-dark btn-icon">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <label>Họ tên người ký tờ trình</label>
        {!! Form::text('nguoikytotrinhdenghi', null, ['class' => 'form-control']) !!}
    </div>
</div>

{{-- <div class="form-group row">
    <div class="col-6">
        <label>Tờ trình kết quả khen thưởng: </label>
        {!! Form::file('totrinhdenghi', null, ['id' => 'totrinhdenghi', 'class' => 'form-control']) !!}
        @if ($model->totrinhdenghi != '')
            <span class="form-control" style="border-style: none">
                <a href="{{ url('/data/tailieudinhkem/' . $model->totrinhdenghi) }}"
                    target="_blank">{{ $model->totrinhdenghi }}</a>
            </span>
        @endif
        {!! Form::hidden('phanloaitailieu', 'TOTRINHKQ') !!}
    </div>
</div> --}}

<div class="form-group row">
    <div class="col-lg-12 text-right">
        <div class="btn-group" role="group">
            <button title="Thêm đối tượng" type="button" data-target="#modal-tailieu" data-toggle="modal"
                class="btn btn-light-dark btn-icon btn-sm" onclick="setTaiLieu()">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
</div>

<div class="row" id="dstailieu">
    <div class="col-12">
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
                            @if ($tt->madonvi == $model->madonvi_xd)
                                <button title="Sửa thông tin" type="button" onclick="getTaiLieu('{{ $tt->id }}')"
                                    class="btn btn-sm btn-clean btn-icon" data-target="#modal-tailieu"
                                    data-toggle="modal">
                                    <i class="icon-lg la fa-edit text-primary"></i>
                                </button>
                                <button title="Xóa" type="button" onclick="delTaiLieu('{{ $tt->id }}')"
                                    class="btn btn-sm btn-clean btn-icon" data-target="#modal-delete-tailieu"
                                    data-toggle="modal">
                                    <i class="icon-lg la fa-trash text-danger"></i>
                                </button>
                            @endif
                            @if ($tt->tentailieu != '')
                                <a target="_blank" title="Tải file đính kèm"
                                    href="{{ '/data/tailieudinhkem/' . $tt->tentailieu }}"
                                    class="btn btn-clean btn-icon btn-sm"><i class="fa flaticon-download text-info"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
