<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @param string $data
 */
function dd($data = 'Successful creation of breakpoint')
{
    dump($data);
    die;
}

/**
 * @param $flag
 * @param string $s
 * @param string $f
 * @return \think\response\Json
 */
function Rjson($flag, $s = 'success', $f = 'false')
{
    return json([
        'code' => $flag ? 200 : 403,
        'msg' => $flag ? $s : $f
    ]);
}

/**
 * 取得给定日期所在周的开始日期和结束日期
 * @param string $gdate 日期，默认为当天，格式：YYYY-MM-DD
 * @param int $weekStart 一周以星期一还是星期天开始，0为星期天，1为星期一
 * @return array 数组array( "开始日期 ",  "结束日期");
 */
function getAWeekTimeSlot($gdate = '', $weekStart = 0)
{
    if (!$gdate) {
        $gdate = date("Y-m-d");
    }
    $w = date("w", strtotime($gdate)); //取得一周的第几天,星期天开始0-6
    $dn = $w ? $w - $weekStart : 6; //要减去的天数
    if ($w == 0) {
        $sun = $gdate;
    } else {
        $sun = date("Y-m-d", strtotime("$gdate  - " . $dn . "  days "));
    }
    $mon = date("Y-m-d", strtotime("$sun  +1  days "));
    $tues = date("Y-m-d", strtotime("$sun  +2  days "));
    $wed = date("Y-m-d", strtotime("$sun  +3  days "));
    $thur = date("Y-m-d", strtotime("$sun  +4  days "));
    $fri = date("Y-m-d", strtotime("$sun  +5  days "));
    $sat = date("Y-m-d", strtotime("$sun  +6  days "));
    return array($sun, $mon, $tues, $wed, $thur, $fri, $sat); //返回开始和结束日期
}