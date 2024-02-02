<!DOCTYPE html>
<html>

<head>
    <title>{{ $pageTitle }}</title>
    <link rel="shortcut icon" href="{{ url('images/LIFESOFT.png') }}" type="image/x-icon">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<style>
    @media print {
        .noPrint {
            visibility: hidden;
        }
    }
</style>

<script>
    function ClickDelete() {
        $('#frm_delete').submit();
    }
    $(document).ready(function() {
        $("#luutoado").click(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var x1 = $("#flying1").position();
            var x2 = $("#flying2").position();
            var x3 = $("#flying3").position();
            var x4 = $("#flying4").position();
            var x5 = $("#flying5").position();
            var x6 = $("#flying6").position();
            var x7 = $("#flying7").position();
            var x8 = $("#flying8").position();
            var x9 = $("#flying9").position();
            var x10 = $("#flying10").position();
            var x11 = $("#flying11").position();
            var x12 = $("#flying12").position();
            var x13 = $("#flying13").position();
            var x14 = $("#flying14").position();
            var x15 = $("#flying15").position();
            var x16 = $("#flying16").position();
            var x17 = $("#flying17").position();
            var x18 = $("#flying18").position();
            var x19 = $("#flying19").position();
            var x20 = $("#flying20").position();
            var x21 = $("#flying21").position();
            var x22 = $("#flying22").position();
            var x23 = $("#flying23").position();
            var x24 = $("#flying24").position();
            var x25 = $("#flying25").position();
            $.ajax({
                type: 'GET',
                url: '/ajaxluutoado',
                data: {
                    _token: CSRF_TOKEN,
                    toado1: 'top:' + x1.top + 'px;left:' + x1.left + 'px',
                    toado2: 'top:' + x2.top + 'px;left:' + x2.left + 'px',
                    toado3: 'top:' + x3.top + 'px;left:' + x3.left + 'px',
                    toado4: 'top:' + x4.top + 'px;left:' + x4.left + 'px',
                    toado5: 'top:' + x5.top + 'px;left:' + x5.left + 'px',
                    toado6: 'top:' + x6.top + 'px;left:' + x6.left + 'px',
                    toado7: 'top:' + x7.top + 'px;left:' + x7.left + 'px',
                    toado8: 'top:' + x8.top + 'px;left:' + x8.left + 'px',
                    toado9: 'top:' + x9.top + 'px;left:' + x9.left + 'px',
                    toado10: 'top:' + x10.top + 'px;left:' + x10.left + 'px',
                    toado11: 'top:' + x11.top + 'px;left:' + x11.left + 'px',
                    toado12: 'top:' + x12.top + 'px;left:' + x12.left + 'px',
                    toado13: 'top:' + x13.top + 'px;left:' + x13.left + 'px',
                    toado14: 'top:' + x14.top + 'px;left:' + x14.left + 'px',
                    toado15: 'top:' + x15.top + 'px;left:' + x15.left + 'px',
                    toado16: 'top:' + x16.top + 'px;left:' + x16.left + 'px',
                    toado17: 'top:' + x17.top + 'px;left:' + x17.left + 'px',
                    toado18: 'top:' + x18.top + 'px;left:' + x18.left + 'px',
                    toado19: 'top:' + x19.top + 'px;left:' + x19.left + 'px',
                    toado20: 'top:' + x20.top + 'px;left:' + x20.left + 'px',
                    toado21: 'top:' + x21.top + 'px;left:' + x21.left + 'px',
                    toado22: 'top:' + x22.top + 'px;left:' + x22.left + 'px',
                    toado23: 'top:' + x23.top + 'px;left:' + x23.left + 'px',
                    toado24: 'top:' + x24.top + 'px;left:' + x24.left + 'px',
                    toado25: 'top:' + x25.top + 'px;left:' + x25.left + 'px',
                    phanloai: 'GKS'
                },
                success: function(respond) {
                    location.reload();
                }

            });
        });
    });
</script>
<button class="noPrint" id="luutoado">Lưu tọa độ</button>
<style>
    #flying,
    #flying1,
    #flying2,
    #flying3,
    #flying4,
    #flying5,
    #flying6,
    #flying7,
    #flying8,
    #flying9,
    #flying10,
    #flying11,
    #flying12,
    #flying13,
    #flying14,
    #flying15,
    #flying16,
    #flying17,
    #flying18,
    #flying19,
    #flying20,
    #flying21,
    #flying22,
    #flying23,
    #flying24,
    #flying25 {
        position: fixed;
        /* position: absolute; */
    }
</style>

<script>
    function byId(e) {
        return document.getElementById(e);
    }

    window.addEventListener('load', myInitFunc, false);

    function myInitFunc() {
        //byId('flying').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying1').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying2').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying3').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying4').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying5').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying6').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying7').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying8').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying9').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying10').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying11').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying12').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying13').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying14').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying15').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying16').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying17').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying18').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying19').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying20').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying21').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying22').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying23').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying24').addEventListener('mousedown', onImgMouseDown, false);
        byId('flying25').addEventListener('mousedown', onImgMouseDown, false);
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
</script>

</head>

<body style="font-size: 16px; width:99%;">
    <table width="96%" border="0" cellspacing="0" cellpadding="4" style="margin:0 auto 20px; text-align: center;">
        <tr>
            <td style="width:26%"></td>
            <td>
                <b class="noPrint">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</b><br>
            </td>
            <td>
                <i style="visibility: hidden;">Mẫu TP/CN-2011/CN.01.a</i>
            </td>
        </tr>
        <tr>
            <td style="width:26%"></td>
            <td>
                <p class="noPrint" style="margin-top:-5px;"><b><u>ĐỘC LẬP - TỰ DO - HẠNH PHÚC</u></b></p>
                <img class="noPrint" src="{{ url('images/quochuy.png') }}" width="100">
            </td>
            <td>
                <p style="text-align:left"><span class="noPrint">Số:</span>

                </p>
                <label id="flying" class="noPrint" style="left: 1031.984375px; top: 54.984375px;">
                    Lock
                </label>
            </td>
        </tr>
        <tr>
        </tr>
    </table>

    <table width="96%" border="0" cellspacing="0" cellpadding="8"
        style="margin: auto auto; text-align: center;font-size: 25px">
        <tr>
            <td>
                <b class="noPrint">GIẤY KHAI SINH</b>
            </td>
        </tr>
    </table>
    <table width="85%" border="0" cellspacing="0" cellpadding="8"
        style="font-size: 27px;border-collapse: collapse; margin:0px auto">
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px;">
                    <b style="visibility: hidden;position:relative;top:20px;" class="noPrint">Họ, chữ đệm, tên: </b>
                    <label style="{{ $toadoks->toado1 }}" id="flying1"><b
                            style="text-transform: uppercase;margin-left: 20px; position:relative;top:20px;">{{ $model->hotenks }}</b></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 5px; margin-bottom: 5px"><span style="visibility: hidden;">a</span></p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;top:8px;" class="noPrint">Ngày, tháng, năm
                        sinh:</span><label style="{{ $toadoks->toado2 }}" id="flying2"><a
                            style="position:relative;margin-left: 20px;top:8px;">{{ getDayVn($model->ngaysinhks) }}</a></label>
                    <span style="visibility: hidden;position:relative;top:8px;margin-left: 220px;" class="noPrint"> ghi
                        bằng chữ:</span><label style="{{ $toadoks->toado3 }}" id="flying3"><a
                            style="position:relative;top:8px;">{{ $model->ngaysinhksbangchu }}</a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 5px; margin-bottom: 5px"><span style="visibility: hidden;">a</span></p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:0px;" class="noPrint">Giới
                        tính:</span><label style="{{ $toadoks->toado4 }}" id="flying4"><a
                            style="position:relative;bottom:0px; margin-left: 20px;">{{ $model->gioitinhks }}</a></label>
                    <span style="visibility: hidden;position:relative;bottom:0px;margin-left: 60px;" class="noPrint">Dân
                        tộc:</span><label style="{{ $toadoks->toado5 }}" id="flying5"><a
                            style="position:relative;bottom:0px; margin-left: 20px;">{{ $model->dantocks }}</a></label>
                    <!-- position:relative: chú ý thuộc tính này làm cho dân tộc Hmong bị níu lại -->
                    <span style="visibility: hidden;position:relative;bottom:0px;margin-left: 100px;"
                        class="noPrint">Quốc tịch:</span>
                    <label style="{{ $toadoks->toado6 }}" id="flying6">
                        <a tyle="position:relative;bottom:0px; margin-left: 20px;">{{ $model->quoctichks }}</a>
                    </label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:2px;" class="noPrint">Nơi
                        sinh:</span><label style="{{ $toadoks->toado7 }}" id="flying7"><a
                            style="position:relative;margin-left: 10px;bottom:2px;">{{ $model->noisinh }}</a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 5px; margin-bottom: 5px"><span style="visibility: hidden;">a</span></p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:8px;" class="noPrint">Quê
                        quán:</span><label style="{{ $toadoks->toado8 }}" id="flying8"><a
                            style="position:relative;margin-left: 20px;bottom:8px;">{{ $model->quequanks }}</a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 5px; margin-bottom: 5px"><span style="visibility: hidden;">a</span></p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:10px;" class="noPrint">Số định danh cá
                        nhân:</span><label style="{{ $toadoks->toado9 }}" id="flying9"><a
                            style="position:relative;margin-left: 20px;bottom:10px;">{{ $model->sodinhdanhcanhan }}</a></label>
                </p>
            </td>
        </tr>
        <!--Thông tin mẹ-->
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <b style="visibility: hidden;position:relative;bottom:15px;" class="noPrint">Họ, chữ đệm, tên
                        người
                        mẹ: </b> <label style="{{ $toadoks->toado10 }}" id="flying10"><b><a
                                style="position:relative;margin-left: 20px;bottom:15px;text-transform: uppercase">{{ $model->hotenme }}</a></b></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:20px;" class="noPrint">Năm
                        sinh:</span><label style="{{ $toadoks->toado11 }}" id="flying11"><a>
                            @if ($model->hotenme != '')
                                {{ $model->ngaysinhme }}
                            @endif
                        </a></label>
                    <span style="visibility: hidden;position:relative;bottom:20px;margin-left: 100px;"
                        class="noPrint">Dân tộc:</span><label style="{{ $toadoks->toado12 }}" id="flying12"><a
                            style="position:relative;bottom:20px; margin-left: 2px;">
                            @if ($model->hotenme != '')
                                {{ $model->dantocme }}
                            @endif
                        </a></label>
                    <span style="visibility: hidden;position:relative;bottom:20px;margin-left: 100px;"
                        class="noPrint">Quốc tịch:</span><label style="{{ $toadoks->toado13 }}" id="flying13"><a
                            style="position:relative;bottom:20px; margin-left: 2px;">
                            @if ($model->hotenme != '')
                                {{ $model->quoctichme }}
                            @endif
                        </a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:15px;" class="noPrint">Nơi cư
                        trú:</span><label style="{{ $toadoks->toado14 }}" f id="flying14"><a
                            style="position:relative;bottom:15px; margin-left: 2px;">
                            @if ($model->hotenme != '')
                                {{ $model->diachime }}
                            @else
                            @endif
                        </a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 5px; margin-bottom: 5px"><span style="visibility: hidden;">a</span></p>
            </td>
        </tr>
        <!--Thông tin cha-->
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px"><b
                        style="visibility: hidden;position:relative;bottom:20px;" class="noPrint">Họ, chữ đệm, tên
                        người cha: </b> <label style="{{ $toadoks->toado15 }}" id="flying15"><b
                            style="position:relative;bottom:20px; margin-left: 10px;text-transform: uppercase">{{ $model->hotencha }}</b></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:20px;" class="noPrint">Năm
                        sinh:</span><label style="{{ $toadoks->toado16 }}" id="flying16"><a>
                            @if ($model->hotencha != '')
                                {{ $model->ngaysinhcha }}
                            @endif
                        </a></label>
                    <span style="visibility: hidden;position:relative;bottom:20px;margin-left: 100px;"
                        class="noPrint">Dân tộc:</span><label style="{{ $toadoks->toado17 }}" id="flying17"><a
                            style="position:relative;bottom:20px; margin-left: 2px;">
                            @if ($model->hotencha != '')
                                {{ $model->dantoccha }}
                            @else
                            @endif
                        </a></label>
                    <span style="visibility: hidden;position:relative;bottom:20px;margin-left: 100px;"
                        class="noPrint">Quốc tịch:</span><label style="{{ $toadoks->toado18 }}" id="flying18"><a
                            style="position:relative;bottom:20px; margin-left: 2px;">
                            @if ($model->hotencha != '')
                                {{ $model->quoctichcha }}
                            @else
                            @endif
                        </a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:25px;" class="noPrint">Nơi cư
                        trú:</span><label style="{{ $toadoks->toado19 }}" id="flying19"><a
                            style="position:relative;bottom:25px; margin-left: 10px;">
                            @if ($model->hotencha != '')
                                {{ $model->diachicha }}
                            @else
                            @endif
                        </a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 5px; margin-bottom: 5px"><span style="visibility: hidden;">a</span></p>
            </td>
        </tr>
        <!--Thông tin người đi khai sinh-->
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <b style="visibility: hidden;position:relative;bottom:35px;" class="noPrint">Họ, chữ đệm, tên
                        người đi khai sinh: </b> <label style="{{ $toadoks->toado20 }}" id="flying20"><b
                            style="position:relative;bottom:35px; margin-left: 20px; text-transform: uppercase">{{ $model->hotennk }}</b></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <span style="visibility: hidden;position:relative;bottom:30px;"class="noPrint">Giấy tờ tùy
                        thân:</span><label style="{{ $toadoks->toado21 }}" id="flying21"><a
                            style="position:relative;bottom:30px; margin-left: 25px;">{{ $model->loaigiaytonk }} số:
                            {{ $model->sogiaytonk }}, {{ $model->noicapgtnk }} cấp ngày
                            {{ getDayVn($model->ngaycapgtnk) }} </a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <b style="visibility: hidden;position:relative;bottom:25px;" class="noPrint">Nơi đăng ký khai
                        sinh:</b><label style="{{ $toadoks->toado22 }}" id="flying22"><a
                            style="position:relative;bottom:25px; margin-left: 25px;">{{ $xa }},
                            {{ $huyen }}, Tỉnh Hà Giang</a></label>
                </p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 5px; margin-bottom: 5px"><span style="visibility: hidden;">a</span></p>
            </td>
        </tr>
        <tr style="line-height: 0.00001">
            <td>
                <p style="margin-top: 10px; margin-bottom: 10px">
                    <b style="visibility: hidden;position:relative;bottom:30px;" class="noPrint">Ngày, tháng, năm đăng
                        ký:</b><label style="{{ $toadoks->toado23 }}" id="flying23"><a
                            style="position:relative;bottom:30px; margin-left: 25px;">{{ getDayVn($model->ngaydangky) }}</a></label>
                </p>
            </td>
        </tr>
    </table>
    <table style="font-size: 29px;margin:auto; text-align: center;">
        <tr>
            <td width="50%"></td>
            <td>
                <table>
                    <tr>
                        <td><b style="visibility: hidden;"class="noPrint">NGƯỜI KÝ GIẤY KHAI SINH</b></td>
                    </tr>
                    <tr>
                        <td><i style="visibility: hidden;" class="noPrint">(Ký, ghi rõ họ, chữ đệm, tên, chức vụ, đóng
                                dấu)</i></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: bottom">
                            <p>
                                <b style="{{ $toadoks->toado24 }}" id="flying24">{{ $model->nguoiky }}</b>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: bottom">
                            <p>
                                <b style="{{ $toadoks->toado25 }}" id="flying25">{{ $model->so }}</b>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
