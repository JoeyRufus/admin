admin
===============

基于thinkPHP搭建的后台管理系统
 + 数据库格式在admin中直接引入
 + Rbac权限管理
 + Layui数据表格


> ThinkPHP5的运行环境要求PHP5.6以上。

## 简化Rbac

 * 原版Rbac简介及安装方法：https://www.cnblogs.com/venom95/p/9803697.html
 * 简版Rbac中将用户表与角色表简化为多对一关联
 * Role中的主键1必定为超级管理员，超级管理员不进行Rbac权限校验
 * permission中的各个节点中1,2级中涉及到index.html中DOM渲染



