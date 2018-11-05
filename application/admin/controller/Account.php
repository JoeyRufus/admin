<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/18
 * Time: 16:54
 */

namespace app\admin\controller;

use think\Request;

class Account extends Base
{
    public function index()
    {
        return view();
    }

    public function show()
    {
        $account = db('account')->order('create_time', 'desc')->select();
        return json([
            'code' => 0,
            'msg' => '',
            'count' => count($account),
            'data' => $account
        ]);
    }

    public function create(Request $request)
    {
        $data['account'] = $request->post('account');
        $data['create_time'] = date('Y-m-d H:i:s');
        $res = db('account')->insert($data);
        return Rjson($res, '账号添加成功', '账号添加失败');
    }

    public function status(Request $request)
    {
        $res = db('account')->where('id', $request->post('id'))->update(['status' => $request->post('status')]);
        return Rjson($res, '状态修改成功', '状态修改失败');
    }

    public function del($id)
    {
        $res = db('account')->delete($id);
        return Rjson($res, '你已经成功删除了该账号！', '账号删除失败');
    }

}