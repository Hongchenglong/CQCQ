<?php
namespace app\index\controller;

use \think\Db;

class Index
{
    public function index()
    {
        // dump(db('select * from record'));
        echo phpinfo();
    }
}
