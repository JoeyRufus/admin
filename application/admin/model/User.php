<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/26
 * Time: 10:29
 */

namespace app\admin\model;


use think\Model;

class User extends Model
{
    protected $table = "user";

    public function role()
    {
        return $this->belongsTo("role");
    }

    public function minisoft()
    {
        return $this->hasMany('minisoft');
    }
}