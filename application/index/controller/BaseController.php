<?php

namespace app\index\controller;

use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;

/**
 * 后台控制器基类
 * Class Base
 * @package app\index\controller
 */
class BaseController extends Controller
{
    public function _initialize()
    {
        if (!session('username')) {
            $this->error('请先登录系统', 'index/index/login');
        }
    }
}
