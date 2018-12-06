<?php
/**
 * Created by PhpStorm.
 * User: li_tz
 * Date: 2018/11/27
 * Time: 1:34
 */

namespace app\admin\controller;


use think\Request;

class Article extends Base
{
    public function index()
    {
        $limit = config("base.limit");
        return view('index', ['limit' => $limit]);
    }

    public function show()
    {
        $articles = db('article')->select();
        return json([
            'code' => 0,
            'msg' => '',
            'count' => count($articles),
            'data' => $articles
        ]);
    }

    public function create()
    {
        return view();
    }

    public function store(Request $request)
    {
        $result = db('article')->insert($request->post());
        return Rjson($result, '文章添加成功。', '文章添加失败');
    }
}