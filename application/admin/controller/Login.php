<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/17
 * Time: 11:39
 */

namespace app\admin\controller;


use gmars\rbac\Rbac;
use think\captcha\Captcha;
use think\Controller;
use think\facade\Session;
use think\Request;
use app\admin\model\User;

class Login extends Controller
{
    /**
     * 登录页面：渲染
     * @return \think\response\View
     */
    public function index()
    {
        return view();
    }

    public function ie()
    {
        return view();
    }

    /**
     * 登录页面：生成验证码
     * @return \think\Response
     */
    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }

    public function login(Request $request)
    {
        if (!captcha_check($request->post('code'))) {
            return json([
                'code' => -1,
                'msg' => '验证码错误'
            ]);
        } else {
            $username = $request->post('username');
            $password = md5($request->post('password'));
            $userModel = new User();
            $user = $userModel->relation('role')->where(['username' => $username, 'password' => $password])->find();
            if ($user) {
                if ($user['status'] == 0) {
                    return json([
                        'code' => -1,
                        'msg' => '抱歉，你的登录权限已被禁止'
                    ]);
                } else {
                    Session::set('user', $user);
                    if ($user['is_admin'] == 1) {
                        $menu = db('permission')->where('level', '<', '3')->select();
                    } else {
                        $Rbac = new Rbac();
                        $permissions = $Rbac->cachePermission($user['id'], session('user.id'));
                        $menu = [];
                        foreach ($permissions as $permission) {
                            if ($permission['level'] < 3) {
                                $menu[] = $permission;
                            }
                        }
                    }
                    Session::set('menu', $menu);
                    return json(['code' => 1, 'msg' => '登录成功！']);
                }
            } else {
                return json(['code' => -1, 'msg' => '账号或信息错误']);
            }

        }
    }

    public function rights()
    {
        return view();
    }

    //用户退出
    public function logout()
    {
        Session::clear();
        $this->redirect('login/index');
    }
}