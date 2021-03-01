<?php


namespace app\index\model;

use think\Model;

/**
 * 学生模型
 * @package app\index\model
 */
class Student extends Model
{
    protected $auto = ['password'];
    protected function setPasswordAttr($value)
    {
        return md5($value);
    }
}