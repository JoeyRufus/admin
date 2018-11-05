<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/26
 * Time: 15:04
 */

namespace app\admin\controller;


use think\facade\Config;
use think\Request;

class Minisoftadd extends Base
{
    public function index()
    {
        $limit = Config::get('base.limit');
        return view('index', ['limit' => $limit]);
    }

    public function show(Request $request)
    {
        $data = db('minisoft')->where('user_id', session('user.id'))->order('create_time', 'desc')->page($request->post('page'), $request->post('limit'))->select();
        $num = db('minisoft')->where('user_id', session('user.id'))->count();
        return json([
            'data' => $data,
            'code' => 0,
            'msg' => '',
            'count' => $num
        ]);
    }

    public function status(Request $request)
    {
        $res = db('minisoft')->where('id', $request->post('id'))->update(['on_off' => $request->post('on_off')]);
        return Rjson($res, '状态修改成功', '状态修改失败');
    }

    public function store(Request $request)
    {
        $data = $request->post();
        $data['create_time'] = date("Y-m-d H:i:s");
        $data['code'] = uniqid() . rand(100, 999);
        $res = db('minisoft')->insert($data);
        return Rjson($res, 'success', 'error');
    }

    public function update(Request $request)
    {
        $res = db('minisoft')->update($request->post());
        return Rjson($res, '修改成功', 'error');
    }

    public function del($id)
    {
        $res = db('minisoft')->delete($id);
        return Rjson($res, 'success', 'error');
    }
}