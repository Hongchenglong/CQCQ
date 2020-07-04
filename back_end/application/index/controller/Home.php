<?php

namespace app\index\controller;

use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

header("content-type:text/html; charset=utf-8");

class Home extends BaseController
{
    public function home()
    {
        return $this->fetch();
    }
}
