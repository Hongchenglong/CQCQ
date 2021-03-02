<?php


namespace app\index\validate;
use think\Validate;

class Student extends Validate
{
    protected $rule = [
        'id|学号' => 'unique',
        'username|用户名' => 'require|min:3',
        'password|密码' => 'require|min:6|confirm:repassword',
        'grade|年级' => 'require|min:4|max:4',
        'department|系别' => 'require'
    ];

    protected $message = [
        'id.unique' => '学号必须唯一',
        'username.require' => '用户名不能为空',
        'username.min' => '用户名长度不能小于3',
        'password.require' => '密码不能为空',
        'password.min' => '密码长度不能少于6',
        'password.confirm' => '两次密码不一致',
        'grade.require' => '年级不能为空',
        'grade.min' => '年级必须为4位数字',
        'grade.max' => '年级必须为4位数字',
        'department.require' => '系别不能为空'
    ];
}