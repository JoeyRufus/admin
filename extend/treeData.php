<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/20
 * Time: 11:02
 */
class treeData
{
    static protected $array = [];

    //无限级分类
    public function tree($data, $pid = 0)
    {
        foreach ($data as $key => $value) {
            if ($value['pid'] == $pid) {
                self::$array[] = $value;
                unset($data[$key]);
                self::tree($data, $value['id']);
            }
        }
        return self::$array;
    }
}