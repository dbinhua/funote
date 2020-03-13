<?php

namespace App\Models\Tool;

use Illuminate\Support\Carbon;

class Timer
{
    public function tranTime(Carbon $time)
    {
        $time = strtotime($time->toDateTimeString());
        $time = time() - $time;

        if($time < 60){
            $str = '刚刚';
        }elseif($time < 60 * 60){
            $min = floor($time/60);
            $str = $min.'分钟前';
        }elseif($time < 60 * 60 * 24){
            $hour = floor($time/(60 * 60));
            $str = $hour.'小时前';
        }elseif($time < 60 * 60 * 24 * 7){
            $day = floor($time/(60*60*24));
            if($day == 1){
                $str = '昨天';
            }else{
                $str = $day.'天前';
            }
        }elseif($time < 60 * 60 * 24 * 30){
            $week = floor($time/(60*60*24*7));
            $str = $week.'周前';
        }elseif($time < 60 * 60 * 24 * 30 * 6){
            $month = floor($time/(60*60*24*30));
            $str = $month.'个月前';
        }else{
            $year = floor($time/(60*60*24*30*12));
            if ($year == 0){
                $str = '半年前';
            }else{
                $str = $year.'年前';
            }
        }
        return $str;
    }
}
