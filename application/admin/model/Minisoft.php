<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2018/10/29
 * Time: 15:53
 */

namespace app\admin\model;


use think\Model;

class Minisoft extends Model
{
    protected $table = 'minisoft';

    public function user()
    {
        return $this->belongsTo('user');
    }
}