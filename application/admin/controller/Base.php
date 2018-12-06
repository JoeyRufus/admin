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
                $allRights = config('base.rbac_except');
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

    public function upload()
    {
        if ($_FILES['file']['error'] != 0) {
            return ['code' => 0, 'msg' => '上传错误'];
        }
        $ext = strrchr($_FILES['file']['name'], '.');
        $path = 'uploads/' . date('Y-m-d') . '/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $filename = uniqid() . $ext;
        $real_path = $path . $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $real_path);
        $file_path = '/uploads/' . date('Y-m-d') . '/' . $filename;
        if ($file_path) {
            echo json_encode([
                'path' => $file_path
            ]);
        }
    }
}