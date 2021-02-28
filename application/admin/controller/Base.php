<?php


namespace app\admin\controller;
use  think\Controller;

/**
 * 后台控制器基类
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    public function _initialize()
    {
        if (!session('name')) {
            $this->error('请先登录系统', 'Index/login');
        }
    }
}