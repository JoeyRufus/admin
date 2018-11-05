<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/18
 * Time: 10:33
 */

namespace app\admin\controller;


use think\Request;
use app\admin\model\User as UserModel;

class User extends Base
{
    public function index()
    {
        $role = db('role')->select();
        $userModel = new UserModel();
        $users = $userModel->relation('role')->where('is_admin', 0)->select();
        return view('index', ['users' => $users, 'role' => $role]);
    }

    public function store(Request $request)
    {
        $user = db('user')->where('username', $request->post('username'))->find();
        if ($user) {
            return json([
                'code' => 403,
                'msg' => '该账号已被注册'
            ]);
        } else {
            $data = $request->post();
            $data['password'] = md5($data['password']);
            $data['create_time'] = date("Y-m-d H:i:s");
            if ($data['role_id'] == 0) {
                $data['is_admin'] = 1;
            }
            $res = db("user")->strict(false)->insert($data);
            return Rjson($res, '注册成功', '注册失败');
        }
    }

    public function status(Request $request)
    {
        $res = db('user')->where('id', $request->post('id'))->update(['status' => $request->post('status')]);
        return Rjson($res, '状态修改成功', '状态修改失败');
    }
}