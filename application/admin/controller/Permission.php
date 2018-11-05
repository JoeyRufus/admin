<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/19
 * Time: 13:57
 */

namespace app\admin\controller;


use gmars\rbac\Rbac;
use think\Request;

class Permission extends Base
{

    public function index()
    {
        $permission = db('permission')->select();
        $tree = new \treeData();
        $permission = $tree->tree($permission);
//      nodeCreate创建节点是所需
        $nodeCreate = [];
        foreach ($permission as $v) {
            if ($v['level'] < 3) {
                $nodeCreate[] = $v;
            }
        }
        return view('index', ['node' => $nodeCreate]);
    }

    public function show()
    {
        $permission = db('permission')->select();
        $tree = new \treeData();
        $permission = $tree->tree($permission);
        return json([
            'code' => 0,
            'msg' => '',
            'count' => count($permission),
            'data' => $permission
        ]);
    }

    /**
     * 权限节点创建
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function store(Request $request)
    {
        $Rbac = new Rbac();
        $res = $Rbac->createPermission($request->post());
        return Rjson($res, '节点创建成功！', '节点创建失败。');
    }

    public function del($id)
    {
        $data = db('permission')->where('pid', $id)->find();
        if ($data) {
            $res = false;
        } else {
            $Rbac = new Rbac();
            $res = $Rbac->delPermission($id);
        }
        return Rjson($res, '你已经成功删除了该节点！', '该节点存在子节点，不允许被删除。');
    }

}