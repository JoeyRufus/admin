<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/11/2
 * Time: 14:57
 */

namespace app\admin\controller;


use app\admin\model\Minisoft;
use app\admin\model\User;

class Visual extends Base
{
    public function index()
    {
        return view();
    }

    public function show()
    {
        $minisoftModel = new Minisoft();
        $weekday = getAWeekTimeSlot();
        $minisoft = $minisoftModel->relation('user')->where('create_time', 'between', [$weekday[0], $weekday[6]])->select();
        $list = [];
        $num = [];
        foreach ($weekday as $v) {
            $list['.All'][$v] = 0;
        }
        foreach ($minisoft as $value) {
            $time = substr($value['create_time'], 0, 10);
            if (!array_key_exists($value['user']['nickname'], $list)) {
                foreach ($weekday as $v) {
                    $list[$value['user']['nickname']][$v] = 0;
                }
            }
            $list[$value['user']['nickname']][$time]++;
            $list['.All'][$time]++;
        }
        foreach ($list as $key => $value) {
            $num[$key] = 0;
            foreach ($value as $v) {
                $num[$key] += $v;
            }
        }
        //柱状图、统计每个成员的上线情况
        $userModel = new User();
        $user_minisoft = $userModel->relation('minisoft')->select();//所有用户的上线信息
        $user_list = [];
        $on_num = [];
        $off_num = [];
        foreach ($user_minisoft as $value) {
            $minisoft_num = count($value['minisoft']);
            if ($minisoft_num) {
                $user_list[] = $value['nickname'];
                $i = 0;
                foreach ($value['minisoft'] as $v) {
                    if ($v['on_off'] == 1) {
                        $i++;
                    }
                }
                $on_num[] = $i;
                $off_num[] = $minisoft_num - $i;
            }
        }
        return json([
            'list' => $list,
            'num' => $num,
            'user_list' => $user_list,
            'on' => $on_num,
            'off' => $off_num
        ]);
    }
}