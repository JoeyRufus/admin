<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/17
 * Time: 11:38
 */
namespace app\admin\controller;

use gmars\rbac\Rbac;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    protected $beforeActionList = ['base'];

    //登录验证
    protected function base()
    {
        if (is_null(Session::get('user'))) {
            $this->redirect('login/index');
        } else {
            $url = explode('.', $_SERVER['REQUEST_URI'])[0];
            //如果用户是admin则不进行权限验证
            if (session('user.is_admin') == 0) {
                //$allRights权限及全体成员均能访问
                $allRights = [
                    "/admin/index/index",
                    "/admin/index/home"
                ];
                if (!in_array($url, $allRights)) {
                    $Rbac = new Rbac();
                    $result = $Rbac->can($url, session('user.id'));
                    if ($result == false) {
                        $this->redirect('login/rights');
                    }
                }
            }
        }
    }
}