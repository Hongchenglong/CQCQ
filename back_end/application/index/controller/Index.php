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
        dump($_POST['block']);
        print_r($_POST['room']);


        $data = array();
        $data['block'] = $_POST['block'];
        $data['room'] = $_POST['room'];
        $result = Db::table('test')->insert($data);

        dump($result);


    }
}
