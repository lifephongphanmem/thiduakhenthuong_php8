<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,500,600,700" />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    {{-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>{{ $pageTitle }} | TDKT</title>
    <link rel="shortcut icon" href="{{ url('assets/media/logos/LIFESOFT.png') }}" />
    <style type="text/css">
        @font-face {
            font-family: 'VnShelleyAllegro';
            src: url('{{ url('/fonts/VnShelleyAllegro.TTF') }}');
        }
        @font-face {
            font-family: 'VnShelley';
            src: url('{{ url('/fonts/.VnShelley Allegro.otf') }}');
        }
        @font-face {
            font-family: 'VnTime';
            src: url('{{ url('/fonts/VNTIME.TTF') }}');
        }
        @font-face {
            font-family: 'VnTimeH';
            src: url('{{ url('/fonts/VHTIME.TTF') }}');
        }
    </style>

    <style type="text/css">
        /* .header tr td {
            padding-top: 0px;
            padding-bottom: 5px;
        }        */

        /* table tr td:first-child {
            text-align: center;
        } */

        table,
        p {
            width: 100%;
            /* margin: auto; */
        }

        button {
            border-width: 0px;
            /* margin: auto; */
        }

        th {
            text-align: center;
        }

        /* td,th {
            padding: 5px;
        } */

        /* p {
            padding: 5px;
        } */

        .sangtrangmoi {
            page-break-before: always
        }

        /* span {
            text-transform: uppercase;
            font-weight: bold;
        } */

        @media print {
            .in {
                display: none !important;
            }

            #myBtn {
                display: none !important;
            }

            @page {
                size: A3 landscape;
                /* DIN A4 standard, Europe */
                margin: 0;
            }
        }

        #fixNav {
            /*background: #f7f7f7;*/
            background: #f9f9fa;
            width: 100%;
            height: 35px;
            display: block;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.5);
            /*Đổ bóng cho menu*/
            position: fixed;
            /*Cho menu cố định 1 vị trí với top và left*/
            top: 0;
            /*Nằm trên cùng*/
            left: 0;
            /*Nằm sát bên trái*/
            z-index: 100000;
            /*Hiển thị lớp trên cùng*/
        }

        #fixNav ul {
            margin: 0;
            padding: 0;
        }

        #fixNav ul li {
            list-style: none inside;
            width: auto;
            float: left;
            line-height: 35px;
            /*Cho text canh giữa menu*/
            color: #fff;
            padding: 0;
            margin-left: 20px;
            margin-top: 1px;
            position: relative;
        }

        #fixNav ul li a {
            text-transform: uppercase;
            white-space: nowrap;
            /*Cho chữ trong menu không bị wrap*/
            padding: 0 10px;
            color: #fff;
            display: block;
            font-size: 0.8em;
            text-decoration: none;
        }
    </style>
    @yield('style_css')
    <script>
        function ExDoc() {
            var sourceHTML = document.getElementById("data").innerHTML;
            var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
            var fileDownload = document.createElement("a");
            document.body.appendChild(fileDownload);
            fileDownload.href = source;
            fileDownload.download = $('#title').val() + '.doc';
            fileDownload.click();
            document.body.removeChild(fileDownload);
        }

        function inDuLieu() {
            // alert
            if (getStyle('toado_tendoituongin').includes('color:red;'))
                byId('toado_tendoituongin').classList.add('in');

            if (getStyle('toado_noidungkhenthuong').includes('color:red;'))
                byId('toado_noidungkhenthuong').classList.add('in');

            if (getStyle('toado_ngayqd').includes('color:red;'))
                byId('toado_ngayqd').classList.add('in');

            if (getStyle('toado_chucvunguoikyqd').includes('color:red;'))
                byId('toado_chucvunguoikyqd').classList.add('in');

            if (getStyle('toado_hotennguoikyqd').includes('color:red;'))
                byId('toado_hotennguoikyqd').classList.add('in');

            if (getStyle('toado_chucvudoituong').includes('color:red;'))
                byId('toado_chucvudoituong').classList.add('in');

            if (getStyle('toado_pldoituong').includes('color:red;'))
                byId('toado_pldoituong').classList.add('in');

            if (getStyle('toado_quyetdinh').includes('color:red;'))
                byId('toado_quyetdinh').classList.add('in');
            window.print();
        }

        function exportTableToExcel() {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableHTML = '';
            //Tiêu đề
            var data_header = document.getElementById('data_header');
            if (data_header) {
                tableHTML = tableHTML + data_header.outerHTML.replace(/ /g, '%20');
            }

            //Nội dung 1
            var data_body = document.getElementById('data_body');
            if (data_body) {
                tableHTML = tableHTML + data_body.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 2
            var data_body1 = document.getElementById('data_body1');
            if (data_body1) {
                tableHTML = tableHTML + data_body1.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 3
            var data_body2 = document.getElementById('data_body2');
            if (data_body2) {
                tableHTML = tableHTML + data_body2.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 4
            var data_body3 = document.getElementById('data_body3');
            if (data_body3) {
                tableHTML = tableHTML + data_body3.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 5
            var data_body4 = document.getElementById('data_body4');
            if (data_body4) {
                tableHTML = tableHTML + data_body4.outerHTML.replace(/ /g, '%20');
            }
            //Nội dung 6
            var data_body5 = document.getElementById('data_body5');
            if (data_body5) {
                tableHTML = tableHTML + data_body5.outerHTML.replace(/ /g, '%20');
            }

            //Chữ ký
            var data_footer = document.getElementById('data_footer');
            if (data_footer) {
                tableHTML = tableHTML + data_footer.outerHTML.replace(/ /g, '%20');
            }
            //Xác nhận
            var data_footer1 = document.getElementById('data_footer1');
            if (data_footer1) {
                tableHTML = tableHTML + data_footer1.outerHTML.replace(/ /g, '%20');
            }

            // Specify file name
            var filename = $('#title').val() + '.xls';

            // Create download link element
            downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], {
                    type: dataType
                });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }
        }
    </script>

    <script>
        function ClickDelete() {
            $('#frm_delete').submit();
        }
    </script>

    <style>
        #toado_tendoituongin,
        #toado_noidungkhenthuong,
        #toado_ngayqd,
        #toado_quyetdinh,
        #toado_chucvunguoikyqd,
        #toado_chucvudoituong,
        #toado_pldoituong,
        #toado_hotennguoikyqd {
            position: absolute;
        }
    </style>

    <script>
        function byId(e) {
            return document.getElementById(e);
        }

        window.addEventListener('load', myInitFunc, false);

        function myInitFunc() {
            byId('toado_tendoituongin').addEventListener('mousedown', onImgMouseDown, false);
            byId('toado_noidungkhenthuong').addEventListener('mousedown', onImgMouseDown, false);
            byId('toado_ngayqd').addEventListener('mousedown', onImgMouseDown, false);
            byId('toado_chucvunguoikyqd').addEventListener('mousedown', onImgMouseDown, false);
            byId('toado_hotennguoikyqd').addEventListener('mousedown', onImgMouseDown, false);
            byId('toado_quyetdinh').addEventListener('mousedown', onImgMouseDown, false);
            byId('toado_chucvudoituong').addEventListener('mousedown', onImgMouseDown, false);
            byId('toado_pldoituong').addEventListener('mousedown', onImgMouseDown, false);
        }

        function getStyle(e) {
            var mElem = document.getElementById(e);
            var fontSize = mElem.style.fontSize;
            if (fontSize == '')
                fontSize = '20px';
            var fontWeight = mElem.style.fontWeight;
            if (fontWeight == '')
                fontWeight = 'normal';
            var fontStyle = mElem.style.fontStyle;
            if (fontStyle == '')
                fontStyle = 'normal';

            var fontFamily = mElem.style.fontFamily;
            if (fontFamily == '')
                fontFamily = 'Tahoma';

            var textAlign = mElem.style.textAlign;
            if (textAlign == '')
                textAlign = 'center';

            var color = mElem.style.color;
            if (color == '')
                color = 'black';

            var width = mElem.style.width;
            if (width == '')
                width = '500px';

            return 'top:' + mElem.style.top + ';' + 'left:' + mElem.style.left + ';' +
                'font-size:' + fontSize + ';' + 'font-weight:' + fontWeight + ';' +
                'font-style:' + fontStyle + ';' + 'font-family:' + fontFamily + ';' +
                'text-align:' + textAlign + ';' + 'color:' + color + ';' + 'width:' + width + ';'

        }

        function onImgMouseDown(e) {
            e = e || event;
            var mElem = this;
            var initMx = e.pageX;
            var initMy = e.pageY;
            var initElemX = this.offsetLeft;
            var initElemY = this.offsetTop;

            var dx = initMx - initElemX;
            var dy = initMy - initElemY;

            document.onmousemove = function(e) {
                e = e || event;
                mElem.style.left = e.pageX - dx + 'px';
                mElem.style.top = e.pageY - dy + 'px';
            }
            this.onmouseup = function() {
                document.onmousemove = null;
            }

            this.ondragstart = function() {
                return false;
            }

        }

        function setToaDo() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '/DungChung/LuuToaDo',
                data: {
                    _token: CSRF_TOKEN,
                    toado_tendoituongin: getStyle('toado_tendoituongin'),
                    toado_noidungkhenthuong: getStyle('toado_noidungkhenthuong'),
                    toado_ngayqd: getStyle('toado_ngayqd'),
                    toado_chucvunguoikyqd: getStyle('toado_chucvunguoikyqd'),
                    toado_hotennguoikyqd: getStyle('toado_hotennguoikyqd'),
                    toado_quyetdinh: getStyle('toado_quyetdinh'),
                    toado_chucvudoituong: getStyle('toado_chucvudoituong'),
                    toado_pldoituong: getStyle('toado_pldoituong'),
                    //toado_quyetdinh: getStyle('toado_quyetdinh'),

                    id: "{{ $inputs['id'] }}",
                    phanloaikhenthuong: "{{ $inputs['phanloaikhenthuong'] }}",
                    phanloaidoituong: "{{ $inputs['phanloaidoituong'] }}",
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        alert(data.message);
                        location.reload();
                    }
                }

            });
        }

        function setMacDinh() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '/DungChung/GanToaDoMacDinh',
                data: {
                    _token: CSRF_TOKEN,
                    toado_tendoituongin: getStyle('toado_tendoituongin'),
                    toado_noidungkhenthuong: getStyle('toado_noidungkhenthuong'),
                    toado_ngayqd: getStyle('toado_ngayqd'),
                    toado_chucvunguoikyqd: getStyle('toado_chucvunguoikyqd'),
                    toado_hotennguoikyqd: getStyle('toado_hotennguoikyqd'),
                    toado_quyetdinh: getStyle('toado_quyetdinh'),
                    toado_chucvudoituong: getStyle('toado_chucvudoituong'),
                    toado_pldoituong: getStyle('toado_pldoituong'),

                    madonvi: "{{ $m_hoso['madonvi'] }}",
                    phanloaikhenthuong: "{{ $inputs['phanloaikhenthuong'] }}",
                    phanloaidoituong: "{{ $inputs['phanloaidoituong'] }}",
                    phanloaiphoi: "{{ $inputs['phanloaiphoi'] }}",
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        alert(data.message);
                        location.reload();
                    }
                }

            });
        }
    </script>
</head>

<body>
    <div class="in">
        <nav id="fixNav">
            <ul>
                <li>
                    <button type="button" class="btn btn-success btn-xs text-right"
                        style="border-radius: 20px; margin-left: 50px" onclick="inDuLieu()">
                        <i class="fa fa-print"></i> In dữ liệu
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary btn-xs" style="border-radius: 20px;"
                        onclick="ExDoc()">
                        <i class="fa fa-file-word-o"></i> File Word
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-info btn-xs" style="border-radius: 20px;"
                        onclick="setToaDo()">
                        <i class="fa fa-file-excel-o"></i> Lưu tọa độ
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-info btn-xs" style="border-radius: 20px;"
                        data-target="#modal-macdinh" data-toggle="modal">
                        <i class="fa fa-file-excel-o"></i> Tải lại tọa độ
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-info btn-xs" style="border-radius: 20px;"
                        onclick="setMacDinh()">
                        <i class="fa fa-file-excel-o"></i> Đặt làm mặc định
                    </button>
                </li>
            </ul>
        </nav>
    </div>

    <div id="data" style="position: relative;">
        @yield('content')
    </div>
</body>

{{-- Lưu tọa độ --}}
{!! Form::open([
    'url' => '/DungChung/LuuThayDoiViTri',
    'id' => 'frm_ThayDoi',
    'class' => 'form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
<input type="hidden" name="id" />
<input type="hidden" name="mahoso" />
<input type="hidden" name="tentruong" />
<input type="hidden" name="toado" />
<input type="hidden" name="phanloaikhenthuong" value="{{ $inputs['phanloaikhenthuong'] }}" />
<input type="hidden" name="phanloaidoituong" value="{{ $inputs['phanloaidoituong'] }}" />
<input type="hidden" name="phanloaiphoi" value="{{ $inputs['phanloaiphoi'] }}" />
<input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
<div class="modal fade bs-modal-lg" id="modal-thaydoi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin chi tiết</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label class="form-control-label">Nội dung in phôi</label>
                        {!! Form::textarea('noidung', null, ['class' => 'form-control', 'rows' => '3']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <label class="form-control-label">Ẩn/Hiện</label>
                        {!! Form::select('color', ['red' => 'Ẩn', 'black' => 'Hiện'], 'black', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">Font chữ</label>
                        {!! Form::select('font-family', getFontFamilyList(), 'Tahoma', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">Căn lề</label>
                        {!! Form::select(
                            'text-align',
                            ['left' => 'Căn trái', 'center' => 'Căn giữa', 'justify' => 'Căn đều', 'right' => 'Căn phải'],
                            'Tahoma',
                            ['class' => 'form-control'],
                        ) !!}
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <label class="form-control-label">Cỡ chữ</label>
                        {!! Form::text('font-size', '20px', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">In đậm</label>
                        {!! Form::select('font-weight', ['normal' => 'Bình thường', 'bold' => 'In đậm'], null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        <label class="form-control-label">In nghiêng</label>
                        {!! Form::select('font-style', ['normal' => 'Bình thường', 'italic' => 'In nghiêng'], null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <label class="form-control-label">Kích thước</label>
                        {!! Form::text('width', '500px', ['class' => 'form-control']) !!}
                    </div>                    
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                <button type="submit" class="btn btn-primary">Hoàn thành</button>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
{!! Form::close() !!}

{!! Form::open([
    'url' => '/DungChung/TaiLaiToaDo',
    'id' => 'frm_MacDinh',
    'class' => 'form',
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
<input type="hidden" name="id" value="{{ $inputs['id'] }}" />
<input type="hidden" name="phanloaikhenthuong" value="{{ $inputs['phanloaikhenthuong'] }}" />
<input type="hidden" name="phanloaidoituong" value="{{ $inputs['phanloaidoituong'] }}" />
<input type="hidden" name="phanloaiphoi" value="{{ $inputs['phanloaiphoi'] }}" />
<input type="hidden" name="madonvi" value="{{ $inputs['madonvi'] }}" />
<div class="modal fade bs-modal-lg" id="modal-macdinh" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin chi tiết</h4>
            </div>
            <div class="modal-body">
                <h4>Thông tin in phôi sẽ được khôi phục lại theo thiết lập mặc định. Bạn có chắc chắn muốn thay đổi.
                </h4>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Thoát</button>
                <button type="submit" class="btn btn-primary">Hoàn thành</button>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
{!! Form::close() !!}

<script>
    function setNoiDung(id, toado, noidung, mahoso, tentruong) {

        var element = document.getElementById(tentruong); //replace elementId with your element's Id.
        var rect = element.getBoundingClientRect();
        var elementLeft, elementTop; //x and y
        var scrollTop = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body
            .scrollTop;
        var scrollLeft = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body
            .scrollLeft;
        elementTop = rect.top + scrollTop;
        elementLeft = rect.left + scrollLeft;

        $('#modal-thaydoi').modal("show");
        //var toado = byId(tentruong).getBoundingClientRect();
        var form = $('#frm_ThayDoi');
        form.find("[name='id']").val(id);
        form.find("[name='mahoso']").val(mahoso);
        form.find("[name='toado']").val('top:' + elementTop + 'px;left:' + elementLeft + 'px;');
        form.find("[name='noidung']").val(noidung);
        form.find("[name='tentruong']").val(tentruong);
        //gán mặc định phòng lỗi
        form.find("[name='text-align']").val('center').trigger('change');
        form.find("[name='color']").val('black').trigger('change');
        var a_style = toado.split(';');
        if (a_style[2] !== undefined) {
            form.find("[name='font-size']").val(a_style[2].split(':')[1]);
        } else
            form.find("[name='font-size']").val('20px');

        if (a_style[3] !== undefined) {
            form.find("[name='font-weight']").val(a_style[3].split(':')[1]).trigger('change');
        } else
            form.find("[name='font-weight']").val('normal').trigger('change');

        if (a_style[4] !== undefined) {
            form.find("[name='font-style']").val(a_style[4].split(':')[1]).trigger('change');
        } else
            form.find("[name='font-style']").val('normal').trigger('change');

        if (a_style[5] !== undefined) {
            //alert(a_style[5].split(':')[1].replace('"','').replace('"',''));
            var font = a_style[5].split(':')[1].replace('"', '').replace('"', '');
            form.find("[name='font-family']").val(font).trigger('change');
        } else
            form.find("[name='font-family']").val('Tahoma').trigger('change');

        if (a_style[6] !== undefined) {
            form.find("[name='text-align']").val(a_style[6].split(':')[1]).trigger('change');
        }
        if (a_style[7] !== undefined) {
            form.find("[name='color']").val(a_style[7].split(':')[1]).trigger('change');
        }

        if (a_style[8] !== undefined) {
            form.find("[name='width']").val(a_style[8].split(':')[1]).trigger('change');
        }

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '/DungChung/InPhoiKhenThuong/getNoiDungKhenThuong',
                data: {
                    _token: CSRF_TOKEN,
                    id: "{{ $inputs['id'] }}",
                    tentruong: tentruong,
                    phanloaikhenthuong: "{{ $inputs['phanloaikhenthuong'] }}",
                    phanloaidoituong: "{{ $inputs['phanloaidoituong'] }}",
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == 'success') {
                        alert(data.message);
                        //location.reload();
                    }
                }

            });

    }
</script>

</html>
