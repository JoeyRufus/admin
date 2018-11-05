<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/27
 * Time: 15:40
 */

namespace app\admin\controller;


use think\facade\Config;
use think\Request;
use app\admin\model\Minisoft as MinisoftModel;

class Minisoft extends Base
{

    public function index()
    {
        $user_ids = db('minisoft')->distinct(true)->column('user_id');
        $user = db('user')->select();
        $user_list = [];
        foreach ($user as $v) {
            if (in_array($v['id'], $user_ids)) {
                $user_list[] = $v;
            }
        }
        $condition = [
            'limit' => Config::get('base.limit'),
            'status' => isset($_POST['status']) ? $_POST['status'] : 10,
            'user_id' => isset($_POST['user_id']) ? $_POST['user_id'] : '',
            'date' => isset($_POST['date']) ? $_POST['date'] : ''
        ];
        return view('index', ['condition' => $condition, 'user_list' => $user_list]);
    }

    public function show(Request $request)
    {
        $minisoftModel = new MinisoftModel();
        $arr = [];
        if ($_POST['status'] != 10) {
            $arr[] = ['on_off', '=', $_POST['status']];
        }
        if (!empty($_POST['user_id'])) {
            $arr[] = ['user_id', '=', $_POST['user_id']];
        }
        if ($_POST['date']) {
            $arr[] = ['create_time', 'like', $_POST['date'] . '%'];
        }
        $data = $minisoftModel->relation('user')->order('create_time', 'desc')->where($arr)->page($request->post('page'), $request->post('limit'))->select();
        $num = $minisoftModel->where($arr)->count();
        return json([
            'data' => $data,
            'code' => 0,
            'msg' => '',
            'count' => $num
        ]);
    }
}