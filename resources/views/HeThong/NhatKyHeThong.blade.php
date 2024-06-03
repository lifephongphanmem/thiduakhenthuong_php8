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

            $('#madonvi').change(function() {
                window.location.href = '/TaiKhoan/DanhSach?madonvi=' + $(this).val();
            });
        });
    </script>
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
    
            function exportTableToExcel() {
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById('sample_3');
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
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
    
            //Get the button
            var mybutton = document.getElementById("myBtn");
    
            // When the user scrolls down 20px from the top of the document, show the button
            // window.onscroll = function () { scrollFunction() };
    
            // function scrollFunction() {
            //     if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            //         document.getElementById("myBtn").style.display = 'block';
            //     } else {
            //         document.getElementById("myBtn").style.display = 'none';
            //     }
            // }
    
            // // When the user clicks on the button, scroll to the top of the document
            // function topFunction() {
            //     document.body.scrollTop = 0;
            //     document.documentElement.scrollTop = 0;
            // }
        </script>
@stop

@section('content')
    <!--begin::Card-->
    <div class="card card-custom wave wave-animate-slow wave-primary" style="min-height: 600px">
        <div class="card-header flex-wrap border-1 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label text-uppercase">Nhật ký hệ thống</h3>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" onclick="exportTableToExcel()">
                    <i class="far fa-file-excel"></i>&ensp;Export Excel
                </button>
            </div>
        </div>
        <div class="card-body"> 
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="sample_3">
                        <thead>
                            <tr class="text-center">
                                <th width="2%">STT</th>
                                <th>Mã hồ sơ</th>
                                <th>Thời gian</th>
                                <th>Tên tài khoản</th>
                                <th>Nội dung thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            @foreach ($model as $key => $tt)
                                <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td>{{ $tt->mahoso }}</td>
                                    <td class="text-center">{{ $tt->thoigian }}</td>
                                    <td class="text-center">{{ $tt->tendangnhap }}</td>
                                    <td>{{ $tt->thongtin }}</td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    

@stop
