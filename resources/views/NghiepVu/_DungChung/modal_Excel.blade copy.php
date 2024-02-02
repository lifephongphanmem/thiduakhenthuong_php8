    {{-- Nhận file Excel --}}
    <div class="modal fade bs-modal-lg" id="modal-nhanexcel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nhận dữ liệu từ file</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">
                        <div class="card-header card-header-tabs-line">
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#excel_tapthe">
                                            <span class="nav-icon">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <span class="nav-text">Tập thể</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#excel_canhan">
                                            <span class="nav-icon">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <span class="nav-text">Cá nhân</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#excel_detai">
                                            <span class="nav-icon">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <span class="nav-text">Đề tài sáng kiến</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="excel_tapthe" role="tabpanel"
                                    aria-labelledby="excel_tapthe">

                                    {!! Form::open([
                                        'url' => $inputs['url_hs'] . 'NhanExcelTapThe',
                                        'method' => 'POST',
                                        'id' => 'frm_NhanExcel',
                                        'class' => 'form',
                                        'files' => true,
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Tên đơn vị / tập thể</label>
                                            {!! Form::text('tentapthe', 'B', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Phân loại đơn vị</label>
                                            {!! Form::text('maphanloaitapthe', 'C', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Hình thức khen thưởng</label>
                                            {!! Form::text('madanhhieukhenthuong', 'D', ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- <div class="col-md-3">
                                            <label class="form-control-label">Danh hiệu thi đua</label>
                                            {!! Form::text('madanhhieutd', 'E', ['class' => 'form-control']) !!}
                                        </div> --}}
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Nhận từ dòng<span
                                                    class="require">*</span></label>
                                            {!! Form::text('tudong', '4', ['class' => 'form-control']) !!}
                                            {{-- {!! Form::text('tudong', '4', ['class' => 'form-control', 'required', 'data-mask' => 'fdecimal']) !!} --}}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Nhận đến dòng</label>
                                            {!! Form::text('dendong', '200', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>File danh sách: </label>
                                            {!! Form::file('fexcel', null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <h4>Tham số mặc định</h4>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label class="control-label">Phân loại đơn vị<span
                                                    class="require">*</span></label>
                                            {!! Form::select('maphanloaitapthe_md', $a_tapthe, null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>

                                        <div class="col-md-4">
                                            <label class="control-label">Hình thức khen thưởng(Danh hiệu thi đua) </label>
                                            {!! Form::select('madanhhieukhenthuong_md', $a_dhkt_tapthe, $inputs['mahinhthuckt'], ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- <div class="col-md-4">
                                            <label class="control-label">Danh hiệu thi đua</label>
                                            {!! Form::select('madanhhieutd_md', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div> --}}
                                    </div>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-check"></i>Hoàn thành</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}

                                </div>

                                <div class="tab-pane fade" id="excel_canhan" role="tabpanel"
                                    aria-labelledby="excel_canhan">
                                    {!! Form::open([
                                        'url' => $inputs['url_hs'] . 'NhanExcelCaNhan',
                                        'id' => 'frm_NhanExcel',
                                        'method' => 'POST',
                                        'class' => 'form',
                                        'files' => true,
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Tên đối tượng</label>
                                            {!! Form::text('tendoituong', 'B', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Giới tính</label>
                                            {!! Form::text('gioitinh', 'C', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Ngày sinh</label>
                                            {!! Form::text('ngaysinh', 'D', ['class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="form-control-label">Chức vụ/Chức danh</label>
                                            {!! Form::text('chucvu', 'E', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tên phòng ban</label>
                                            {!! Form::text('tenphongban', 'F', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tên cơ quan</label>
                                            {!! Form::text('tencoquan', 'G', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Nơi ở / Địa chỉ</label>
                                            {!! Form::text('tencoquan', 'H', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Phân loại cán bộ</label>
                                            {!! Form::text('maphanloaicanbo', 'I', ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Hình thức khen thưởng</label>
                                            {!! Form::text('madanhhieukhenthuong', 'J', ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- <div class="col-md-3">
                                            <label class="control-label">Danh hiệu thi đua</label>
                                            {!! Form::text('madanhhieutd', 'K', ['id' => 'lanhdao', 'class' => 'form-control']) !!}
                                        </div> --}}
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Nhận từ dòng<span
                                                    class="require">*</span></label>
                                            {!! Form::text('tudong', '4', ['class' => 'form-control']) !!}
                                            {{-- {!! Form::text('tudong', '4', ['class' => 'form-control', 'required', 'data-mask' => 'fdecimal']) !!} --}}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Nhận đến dòng</label>
                                            {!! Form::text('dendong', '200', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>File danh sách: </label>
                                            {!! Form::file('fexcel', null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>

                                    <hr>
                                    <h4>Tham số mặc định</h4>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label class="control-label">Phân loại cán bộ<span
                                                    class="require">*</span></label>
                                            {!! Form::select('maphanloaicanbo_md', $a_canhan, null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>

                                        <div class="col-md-4">
                                            <label class="control-label">Hình thức khen thưởng(Danh hiệu thi đua) </label>
                                            {!! Form::select('madanhhieukhenthuong_md', $a_dhkt_canhan, $inputs['mahinhthuckt'], ['class' => 'form-control']) !!}
                                        </div>

                                        {{-- <div class="col-md-4">
                                            <label class="control-label">Danh hiệu thi đua</label>
                                            {!! Form::select('madanhhieutd_md', setArrayAll($a_danhhieutd, 'Không đăng ký', 'null'), null, [
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div> --}}
                                    </div>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-check"></i>Hoàn thành</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                                <div class="tab-pane fade" id="excel_detai" role="tabpanel"
                                    aria-labelledby="excel_canhan">
                                    {!! Form::open([
                                        'url' => $inputs['url_hs'] . 'NhanExcelDeTai',
                                        'id' => 'frm_NhanExcel',
                                        'method' => 'POST',
                                        'class' => 'form',
                                        'files' => true,
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="mahosotdkt" value="{{ $model->mahosotdkt }}" />
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Tên đề tài, sáng kiến</label>
                                            {!! Form::text('tensangkien', 'B', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Ngày tháng công nhận</label>
                                            {!! Form::text('thoigiancongnhan', 'C', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Đơn vị công nhận</label>
                                            {!! Form::text('donvicongnhan', 'D', ['class' => 'form-control']) !!}
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="form-control-label">Tóm tắt thành tích</label>
                                            {!! Form::text('thanhtichdatduoc', 'E', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tên tác giả</label>
                                            {!! Form::text('tendoituong', 'F', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tên phòng ban làm việc</label>
                                            {!! Form::text('tenphongban', 'G', ['class' => 'form-control']) !!}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-control-label">Tên cơ quan làm việc</label>
                                            {!! Form::text('tencoquan', 'H', ['class' => 'form-control']) !!}
                                        </div>                                    
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="control-label">Nhận từ dòng<span
                                                    class="require">*</span></label>
                                            {!! Form::text('tudong', '4', ['class' => 'form-control']) !!}
                                            {{-- {!! Form::text('tudong', '4', ['class' => 'form-control', 'required', 'data-mask' => 'fdecimal']) !!} --}}
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Nhận đến dòng</label>
                                            {!! Form::text('dendong', '200', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>File danh sách: </label>
                                            {!! Form::file('fexcel', null, ['class' => 'form-control', 'required'=>'true']) !!}
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fa fa-check"></i>Hoàn thành</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
