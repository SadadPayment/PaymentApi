<?php

namespace App\Model;

use Carbon\Carbon;

class DateTime
{
    // @Return nowdatetime in string format
    public static function getDateTime(){
        $now = Carbon::now();
        $day = $now->day >= 10 ? $now->day : "0" . $now->day;
        $mounth = $now->month >= 10 ? $now->month : "0" . $now->month;
        $year = $now->year - 2000;

        $hour = $now->hour >= 10 ? $now->hour : "0" . $now->hour;

        $minute = $now->minute >= 10 ? $now->minute : "0" . $now->minute;
        $second = $now->second >= 10 ? $now->second : "0" . $now->second;
        $convert = "" . $day . "" . $mounth . "" . $year . "" . $hour . "" . $minute . "" . $second . "";
        return $convert;
    }
}
