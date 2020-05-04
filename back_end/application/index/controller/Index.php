<?php
namespace app\index\controller;

use \think\Db;

class Index
{
    public function index()
    {
        echo phpinfo();
    }


    public function test() {
        // sendSms();
    }
}
