<?php


namespace app\admin\model;
use think\Model;

/**
 * 用户模型
 * @package app\admin\model
 */
class Instructor extends Model
{
    protected $auto = ['password'];
    protected function setPasswordAttr($value)
    {
        return md5($value);
    }
}