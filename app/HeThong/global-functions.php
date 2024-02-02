<?php


function getDayVn($date)
{
    if ($date != null || $date != '')
        $newday = date('d/m/Y', strtotime($date));
    else
        $newday = '';
    return $newday;
}

function getDateTime($date)
{
    if ($date != null)
        $newday = date('d/m/Y H:i:s', strtotime($date));
    else
        $newday = '';
    return $newday;
}

function chkSoKhong($num)
{
    if ($num == 0)
        return 1;
    else
        return $num;
}

function getDbl($obj)
{
    $obj = str_replace(',', '', $obj);
    $obj = str_replace('.', '', $obj);
    if (is_numeric($obj)) {
        return $obj;
    } else
        return 0;
}



function getDouble($str)
{
    $sKQ = 0;
    $str = str_replace(',', '', $str);
    $str = str_replace('.', '', $str);
    //if (is_double($str))
    $sKQ = $str;
    return floatval($sKQ);
}

function chuyenkhongdau($str)
{
    if (!$str) return false;
    $utf8 = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ|Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);
    return $str;
}

function chuanhoachuoi($text)
{
    $text = strtolower(chuyenkhongdau($text));
    $text = str_replace("ß", "ss", $text);
    $text = str_replace("%", "", $text);
    $text = preg_replace("/[^_a-zA-Z0-9 -]/", "", $text);
    $text = str_replace(array('%20', ' '), '-', $text);
    $text = str_replace("----", "-", $text);
    $text = str_replace("---", "-", $text);
    $text = str_replace("--", "-", $text);
    return $text;
}

function chuanhoatruong($text)
{
    $text = strtolower(chuyenkhongdau($text));
    $text = str_replace("ß", "ss", $text);
    $text = str_replace("%", "", $text);
    $text = preg_replace("/[^_a-zA-Z0-9 -]/", "", $text);
    $text = str_replace(array('%20', ' '), '_', $text);
    $text = str_replace("----", "_", $text);
    $text = str_replace("---", "_", $text);
    $text = str_replace("--", "_", $text);
    return $text;
}


function getDateToDb($value)
{
    if ($value == '') {
        return null;
    }
    $str =  strtotime(str_replace('/', '-', $value));
    $kq = date('Y-m-d', $str);
    return $kq;
}

function getMoneyToDb($value)
{
    if ($value == '') {
        $kq = 0;
    } else {
        $kq = str_replace(',', '', $value);
        $kq = str_replace('.', '', $kq);
    }
    return $kq;
}

function getDoubleToDb($value)
{
    if ($value == '') {
        $kq = 0;
    } else {
        $kq = str_replace(',', '', $value);
    }
    return $kq;
}

function getDecimalToDb($value)
{
    if ($value == '') {
        $kq = 1;
    } else {
        $kq = str_replace(',', '.', $value);
    }
    return $kq;
}

function getRandomPassword()
{
    $bytes = random_bytes(3); // length in bytes
    $kq = (bin2hex($bytes));
    return $kq;
}

function getSoNnSelectOptions()
{

    $start = '1';
    $stop = '10';
    $options = array();

    for ($i = $start; $i <= $stop; $i++) {

        $options[$i] = $i;
    }
    return $options;
}


function Thang2Quy($thang)
{
    if ($thang == 1 || $thang == 2 || $thang == 3)
        return 1;
    elseif ($thang == 4 || $thang == 5 || $thang == 6)
        return 2;
    elseif ($thang == 7 || $thang == 8 || $thang == 9)
        return 3;
    else
        return 4;
}

function dinhdangso($number, $decimals = 0, $unit = '1', $dec_point = ',', $thousands_sep = '.')
{
    if (!is_numeric($number) || $number == 0) {
        return '';
    }
    $r = $unit;

    switch ($unit) {
        case 2: {
                $decimals = 3;
                $r = 1000;
                break;
            }
        case 3: {
                $decimals = 5;
                $r = 1000000;
                break;
            }
    }

    $number = round($number / $r, $decimals);
    return number_format($number, $decimals, $dec_point, $thousands_sep);
}

function IntToRoman($number)
{
    $roman = '';
    while ($number >= 1000) {
        $roman .= "M";
        $number -= 1000;
    }
    if ($number >= 900) {
        $roman .= "CM";
        $number -= 900;
    }
    if ($number >= 500) {
        $roman .= "D";
        $number -= 500;
    }
    if ($number >= 400) {
        $roman .= "CD";
        $number -= 400;
    }
    while ($number >= 100) {
        $roman .= "C";
        $number -= 100;
    }
    if ($number >= 90) {
        $roman .= "XC";
        $number -= 90;
    }
    if ($number >= 50) {
        $roman .= "L";
        $number -= 50;
    }
    if ($number >= 40) {
        $roman .= "XL";
        $number -= 40;
    }
    while ($number >= 10) {
        $roman .= "X";
        $number -= 10;
    }
    if ($number >= 9) {
        $roman .= "IX";
        $number -= 9;
    }
    if ($number >= 5) {
        $roman .= "V";
        $number -= 5;
    }
    if ($number >= 4) {
        $roman .= "IV";
        $number -= 4;
    }
    while ($number >= 1) {
        $roman .= "I";
        $number -= 1;
    }
    return $roman;
}

function toAlpha($data)
{
    $alphabet =   array('', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    $alpha_flip = array_flip($alphabet);
    if ($data <= 25) {
        return $alphabet[$data];
    } elseif ($data > 25) {
        $dividend = ($data + 1);
        $alpha = '';
        $modulo = '';
        while ($dividend > 0) {
            $modulo = ($dividend - 1) % 26;
            $alpha = $alphabet[$modulo] . $alpha;
            $dividend = floor((($dividend - $modulo) / 26));
        }
        return $alpha;
    }
}

function romanNumerals($num)
{
    $n = intval($num);
    $res = '';

    /*** roman_numerals array  ***/
    $roman_numerals = array(
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1
    );

    foreach ($roman_numerals as $roman => $number) {
        /*** divide to get  matches ***/
        $matches = intval($n / $number);

        /*** assign the roman char * $matches ***/
        $res .= str_repeat($roman, $matches);

        /*** substract from the number ***/
        $n = $n % $number;
    }

    /*** return the res ***/
    return $res;
}

function getvbpl($str)
{
    $str = str_replace(',', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace(' ', '', $str);
    $str = chuyenkhongdau($str);
    return $str;
}

function VndText($amount)
{
    if ($amount <= 0) {
        return 0;
    }
    $Text = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
    $TextLuythua = array("", "nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
    $textnumber = "";
    $length = strlen($amount);

    for ($i = 0; $i < $length; $i++)
        $unread[$i] = 0;

    for ($i = 0; $i < $length; $i++) {
        $so = substr($amount, $length - $i - 1, 1);

        if (($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)) {
            for ($j = $i + 1; $j < $length; $j++) {
                $so1 = substr($amount, $length - $j - 1, 1);
                if ($so1 != 0)
                    break;
            }

            if (intval(($j - $i) / 3) > 0) {
                for ($k = $i; $k < intval(($j - $i) / 3) * 3 + $i; $k++)
                    $unread[$k] = 1;
            }
        }
    }

    for ($i = 0; $i < $length; $i++) {
        $so = substr($amount, $length - $i - 1, 1);
        if ($unread[$i] == 1)
            continue;

        if (($i % 3 == 0) && ($i > 0))
            $textnumber = $TextLuythua[$i / 3] . " " . $textnumber;

        if ($i % 3 == 2)
            $textnumber = 'trăm ' . $textnumber;

        if ($i % 3 == 1)
            $textnumber = 'mươi ' . $textnumber;


        $textnumber = $Text[$so] . " " . $textnumber;
    }

    //Phai de cac ham replace theo dung thu tu nhu the nay
    $textnumber = str_replace("không mươi", "lẻ", $textnumber);
    $textnumber = str_replace("lẻ không", "", $textnumber);
    $textnumber = str_replace("mươi không", "mươi", $textnumber);
    $textnumber = str_replace("một mươi", "mười", $textnumber);
    $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
    $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
    $textnumber = str_replace("mười năm", "mười lăm", $textnumber);

    return ucfirst($textnumber . " đồng chẵn.");
}

function trim_zeros($str)
{
    if (!is_string($str)) return $str;
    return preg_replace(array('`\.0+$`', '`(\.\d+?)0+$`'), array('', '$1'), $str);
}

function dinhdangsothapphan($number, $decimals = 0)
{
    if (!is_numeric($number) || $number == 0) {
        return '';
    }
    $number = round($number, $decimals);
    $str_kq = trim_zeros(number_format($number, $decimals));
    /*for ($i = 0; $i < strlen($str_kq); $i++){
        if($str_kq[$i]== '.'){
            $str_kq[$i]= ',';
        }elseif($str_kq[$i]== ','){
            $str_kq[$i]= '.';
        }
    }*/
    //$a_so = str_split($str_kq);

    //$str_kq = str_replace(",", ".", $str_kq);
    //$str_kq = str_replace(".", ",", $str_kq);
    return $str_kq;
    //return number_format($number, $decimals ,$dec_point, $thousands_sep);
    //làm lại hàm chú ý đo khi các số thập phân nếu làm tròn thi ko bỏ dc số 0 đằng sau dấu ,
    // round(5.4,4) = 5,4000
}

function chkDbl($obj)
{
    $obj = str_replace(',', '', $obj);
    $obj = str_replace('%', '', $obj);
    if (is_numeric($obj)) {
        return $obj;
    } else {
        return 0;
    }
}

function emailValid($email)
{
    $pattern = '#^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#';
    if (preg_match($pattern, $email))
        return true;
    else
        return false;
}

function Date2Str($date)
{
    if ($date == NULL || $date == null || $date == '' || $date == '0000-00-00') {
        return 'ngày ... tháng ... năm ...';
    } else {
        $day = strtotime($date);
        return 'ngày ' . date('d', $day) . ' tháng ' . date('m', $day) . ' năm ' . date('Y', $day);
    }
}

//function catchuoi($str, $sokytu = 13, $themo = '<p>', $thedong = '</p>')
function catchuoi($str, $sokytu = 13, $themo = '', $thedong = '</br>')
{
    $s_kq = '';
    if (strlen($str) == 0) {
        return $themo . $thedong;
    }
    $a_chuoi = array_chunk(explode(' ', $str), $sokytu);
    for ($i = 0; $i < count($a_chuoi); $i++) {
        $s_kq .= implode(' ', $a_chuoi[$i]);
        if ($i < count($a_chuoi) - 2)
            $s_kq .= $thedong;
    }
    // foreach (array_chunk(explode(' ', $str), $sokytu) as $chuoi) {
    //     $s_kq .= ($themo . implode(' ', $chuoi) . $thedong);
    // }
    return $s_kq;
}

function UNI_2_TCVN3($text)
{
    //$text = "khen thưởng người đã có thành tích Ư";
    //$text = str_replace('ư', 'Ư', $text);//do chữ 'ư' => '' nên pải đổi đi
    //$text = strtoupper($text);

    //$UNI = array("à", "á", "ả", "ã", "ạ", "ă", "ằ", "ắ", "ẳ", "ẵ", "ặ", "â", "ầ", "ấ", "ẩ", "ẫ", "ậ", "đ", "è", "é", "ẻ", "ẽ", "ẹ", "ê", "ề", "ế", "ể", "ễ", "ệ", "ì", "í", "ỉ", "ĩ", "ị", "ò", "ó", "ỏ", "õ", "ọ", "ô", "ồ", "ố", "ổ", "ỗ", "ộ", "ơ", "ờ", "ớ", "ở", "ỡ", "ợ", "ù", "ú", "ủ", "ũ", "ụ", "ư", "ừ", "ứ", "ử", "ữ", "ự", "ỳ", "ý", "ỷ", "ỹ", "ỵ", "Ă", "Â", "Đ", "Ê", "Ô", "Ơ", "Ư");
    $UNI = array(
        "À", "Á", "Â", "Ã", "È", "É", "Ê", "Ì", "Í", "Ò",
        "Ó", "Ô", "Õ", "Ù", "Ú", "Ý", "à", "á", "â", "ã",
        "è", "é", "ê", "ì", "í", "ò", "ó", "ô", "õ", "ù",
        "ú", "ý", "Ă", "ă", "Đ", "đ", "Ĩ", "ĩ", "Ũ", "ũ",
        "Ơ", "ơ", "Ư", "ư", "Ạ", "ạ", "Ả", "ả", "Ấ", "ấ",
        "Ầ", "ầ", "Ẩ", "ẩ", "Ẫ", "ẫ", "Ậ", "ậ", "Ắ", "ắ",
        "Ằ", "ằ", "Ẳ", "ẳ", "Ẵ", "ẵ", "Ặ", "ặ", "Ẹ", "ẹ",
        "Ẻ", "ẻ", "Ẽ", "ẽ", "Ế", "ế", "Ề", "ề", "Ể", "ể",
        "Ễ", "ễ", "Ệ", "ệ", "Ỉ", "ỉ", "Ị", "ị", "Ọ", "ọ",
        "Ỏ", "ỏ", "Ố", "ố", "Ồ", "ồ", "Ổ", "ổ", "Ỗ", "ỗ",
        "Ộ", "ộ", "Ớ", "ớ", "Ờ", "ờ", "Ở", "ở", "Ỡ", "ỡ",
        "Ợ", "ợ", "Ụ", "ụ", "Ủ", "ủ", "Ứ", "ứ", "Ừ", "ừ",
        "Ử", "ử", "Ữ", "ữ", "Ự", "ự", "Ỳ", "ỳ", "Ỵ", "ỵ",
        "Ỷ", "ỷ", "Ỹ", "ỹ"
    );
    //$TCVN3 = array("µ", "¸", "¶", "·", "¹", "¨", "»", "¾", "¼", "½", "Æ", "©", "Ç", "Ê", "È", "É", "Ë", "®", "Ì", "Ð", "Î", "Ï", "Ñ", "ª", "Ò", "Õ", "Ó", "Ô", "Ö", "×", "Ý", "Ø", "Ü", "Þ", "ß", "ã", "á", "â", "ä", "«", "å", "è", "æ", "ç", "é", "¬", "ê", "í", "ë", "ì", "î", "ï", "ó", "ñ", "ò", "ô", "­", "õ", "ø", "ö", "÷", "ù", "ú", "ý", "û", "ü", "þ", "¡", "¢", "§", "£", "¤", "¥", "¦");
    $TCVN3 = array(
        "Aµ", "A¸", "¢", "A·", "EÌ", "EÐ", "£", "I×", "IÝ", "Oß",
        "Oã", "¤", "Oâ", "Uï", "Uó", "Yý", "µ", "¸", "©", "·",
        "Ì", "Ð", "ª", "×", "Ý", "ß", "ã", "«", "â", "ï",
        "ó", "ý", "¡", "¨", "§", "®", "IÜ", "Ü", "Uò", "ò",
        "¥", "¬", "¦", "­", "A¹", "¹", "A¶", "¶", "¢Ê", "Ê",
        "¢Ç", "Ç", "¢È", "È", "¢É", "É", "¢Ë", "Ë", "¡¾", "¾",
        "¡»", "»", "¡¼", "¼", "¡½", "½", "¡Æ", "Æ", "EÑ", "Ñ",
        "EÎ", "Î", "EÏ", "Ï", "£Õ", "Õ", "£Ò", "Ò", "£Ó", "Ó",
        "£Ô", "Ô", "£Ö", "Ö", "IØ", "Ø", "IÞ", "Þ", "Oä", "ä",
        "Oá", "á", "¤è", "è", "¤å", "å", "¤æ", "æ", "¤ç", "ç",
        "¤é", "é", "¥í", "í", "¥ê", "ê", "¥ë", "ë", "¥ì", "ì",
        "¥î", "î", "Uô", "ô", "Uñ", "ñ", "¦ø", "ø", "¦õ", "õ",
        "¦ö", "ö", "¦÷", "÷", "¦ù", "ù", "Yú", "ú", "Yþ", "þ",
        "Yû", "û", "Yü", "ü"
    );
    for ($i = 0; $i < count($UNI); $i++) {
        $text = str_replace($UNI[$i], $TCVN3[$i], $text);
    }
    //dd($text);
    return $text;
}

function UNI_to_TCVN3($text)
{
    $text = "Chủ nhiệm Câu lạc bộ người khuyết tật xã Thanh Hóa, huyện Tuyên Hóa";
    //$text = str_replace('ư', 'Ư', $text);//do chữ 'ư' => '' nên pải đổi đi
    //$text = strtoupper($text);

    $UNI = array("à", "á", "ả", "ã", "ạ", "ă", "ằ", "ắ", "ẳ", "ẵ", "ặ", "â", "ầ", "ấ", "ẩ", "ẫ", "ậ", "đ", "è", "é", "ẻ", "ẽ", "ẹ", "ê", "ề", "ế", "ể", "ễ", "ệ", "ì", "í", "ỉ", "ĩ", "ị", "ò", "ó", "ỏ", "õ", "ọ", "ô", "ồ", "ố", "ổ", "ỗ", "ộ", "ơ", "ờ", "ớ", "ở", "ỡ", "ợ", "ù", "ú", "ủ", "ũ", "ụ", "ư", "ừ", "ứ", "ử", "ữ", "ự", "ỳ", "ý", "ỷ", "ỹ", "ỵ", "Ă", "Â", "Đ", "Ê", "Ô", "Ơ", "Ư");

    $TCVN3 = array("µ", "¸", "¶", "·", "¹", "¨", "»", "¾", "¼", "½", "Æ", "©", "Ç", "Ê", "È", "É", "Ë", "®", "Ì", "Ð", "Î", "Ï", "Ñ", "ª", "Ò", "Õ", "Ó", "Ô", "Ö", "×", "Ý", "Ø", "Ü", "Þ", "ß", "ã", "á", "â", "ä", "«", "å", "è", "æ", "ç", "é", "¬", "ê", "í", "ë", "ì", "î", "ï", "ó", "ñ", "ò", "ô", "­", "õ", "ø", "ö", "÷", "ù", "ú", "ý", "û", "ü", "þ", "¡", "¢", "§", "£", "¤", "¥", "¦");

    for ($i = 0; $i < count($UNI); $i++) {
       // $text = str_replace($UNI[$i], $TCVN3[$i], $text);
    }
    //dd($text);
    return $text;
}

function Str2Bbl($obj)
{
    $ketqua = '';
    for ($i = 0; $i < strlen($obj); $i++) {
        if (is_numeric($obj[$i]) || $obj[$i] == '.') {
            $ketqua .= $obj[$i];
        }
    }
    return $ketqua;
}
