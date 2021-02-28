<?php

namespace app\api\controller;

use \think\Db;

class Index
{
    public function index()
    {
        echo phpinfo();
    }


    public function test()
    {
        $result = Db::table('cq_student')
        ->field('sex')
        ->where('id', 211706174)
        ->find();

        dump($result);

        print_r($result);
    }
}
