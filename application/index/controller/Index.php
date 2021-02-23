<?php

namespace app\index\controller;

use pSplit;
use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

class Index extends BaseController
{
    public function index()
    {
        $this->redirect("/cqcq/back_end/public/index.php/index/login/index");
    }

    public function welcome()
    {
        $this->redirect("/cqcq/back_end/public/index.php/index/welcome/welcome");
    }

    public function table()
    {
        $this->redirect("/cqcq/back_end/public/index.php/index/table/table");
    }

    public function record()
    {
        $this->redirect("/cqcq/back_end/public/index.php/index/record/records");
    }
}