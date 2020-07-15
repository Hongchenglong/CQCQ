<?php

namespace app\index\controller;

use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

class Welcome extends BaseController
{
    public function welcome()
    {
        return $this->fetch();
    }
}