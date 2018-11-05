<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/17
 * Time: 15:13
 */

namespace app\admin\controller;


use think\facade\Session;

class Index extends Base
{
    public function index()
    {
        $menu = Session::get('menu');
        $user = session('user');
        $menu_level_1 = $menu_level_2 = [];
        foreach ($menu as $v) {
            if ($v['level'] == 1) {
                $menu_level_1[] = $v;
            } else {
                $menu_level_2[] = $v;
            }
        }
        return view('index', ['user' => $user, 'level_1' => $menu_level_1, 'level_2' => $menu_level_2]);
    }

    public function home()
    {
        return view();
    }

    public function avatar()
    {
        return view();
    }

    public function upload()
    {

    }
}