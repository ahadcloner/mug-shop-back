<?php
function faTOen($string)
{
    return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
}

function farsiToEngDate($date)
{
    if ($date)
    {
        $result = explode('/', $date);
        $year = $result[0];
        $year = faTOen($year);
        $month = $result[1];
        $month = faTOen($month);
        $day = $result[2];
        $day = faTOen($day);
        $_birth_date = Verta::jalaliToGregorian($year, $month, $day);
        $new_birth_date = (string)$_birth_date[0] . '-' . (string)$_birth_date[1] . '-' . (string)$_birth_date[2];
        return $new_birth_date;
    }

}
