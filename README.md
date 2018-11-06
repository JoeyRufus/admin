admin
===============

基于thinkPHP搭建的后台管理系统
 + 数据库格式在admin.sql中直接引入
 + Rbac权限管理
 + Layui数据表格


> ThinkPHP5的运行环境要求PHP5.6以上。

## 简化Rbac

 * 原版Rbac简介及安装方法：https://www.cnblogs.com/venom95/p/9803697.html
 * 简版Rbac中将用户表与角色表简化为多对一关联
 * Role中的主键1必定为超级管理员，超级管理员不进行Rbac权限校验
 * 后台主页中的菜单栏是根据permission中的level1与level2生成



