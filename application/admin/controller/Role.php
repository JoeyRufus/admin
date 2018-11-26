<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/22
 * Time: 9:37
 */

namespace app\admin\controller;


use gmars\rbac\Rbac;
use think\Request;
use app\admin\model\Role as RoleModel;

class Role extends Base
{
    public function index()
    {
        $permission = db('permission')->select();
        $tree = new \treeData();
        $permission = $tree->tree($permission);
        return view('index', ['permissions' => $permission]);
    }

    public function show()
    {
        $role = db('role')->where('id', '>', 0)->select();
        return json([
            'code' => 0,
            'msg' => '',
            'count' => count($role),
            'data' => $role
        ]);
    }

    public function store(Request $request)
    {
        $roleModel = new RoleModel();
        $role = $roleModel->create($request->post());
        if ($request->post('access')) {
            $data = [];
            foreach ($request->post('access') as $value) {
                $tmp = explode('_', $value);
                $data[] = $tmp[0];
            }
            $Rbac = new Rbac();
            $Rbac->assignRolePermission($role['id'], $data);
        }
        return Rjson($role, '角色创建成功！', '角色创建失败');
    }

    public function edit($id)
    {
        $permission = db('permission')->select();
        $tree = new \treeData();
        $permission = $tree->tree($permission);
        $role = db('role_permission')->where('role_id', $id)->column('permission_id');
        $i = 0;
        foreach ($permission as $v) {
            if (in_array($v['id'], $role)) {
                $permission[$i]['access'] = 1;
            } else {
                $permission[$i]['access'] = 0;
            }
            $i++;
        }
        $roleInfo = db('role')->where('id', $id)->find();
        return view('edit', ['permissions' => $permission, 'role' => $roleInfo]);
    }

    public function update(Request $request)
    {
        $Rbac = new Rbac();
        $roleM = new RoleModel();
        $data = [];
        $roleM->update($request->post(), ['id' => $request->post('id')]);
        foreach ($request->post('access') as $value) {
            $tmp = explode('_', $value);
            $data[] = $tmp[0];
        }
        db('role_permission')->where('role_id', $request->post('id'))->delete();
        $Rbac->assignRolePermission($request->post('id'), $data);
        $this->redirect('index');
    }
}