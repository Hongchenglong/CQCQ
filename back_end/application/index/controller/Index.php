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
        $where = array();
        $room = explode(',', $_POST['room']);
        $block = explode(',', $_POST['block']);
        $len = sizeof($room);
        for ($i = 0; $i < $len; $i++) {
            $where['room']  = $room[$i];
            $where['block'] = $block[$i];
            $result = Db::table('dorm')
                ->field('dorm.id, dorm_num')   // 指定字段
                ->alias('d')    // 别名
                ->join('student s', 's.id = d.student_id')
                ->where($where)
                ->find();

            $data = array();
            $data['dorm_id'] = $result['id'];
            $data['rand_num'] = rand(1, 10000);
            $result = Db::table('record')->insert($data);
        }
        // $data = array();
        // $data['block'] = $_POST['block'];
        // $data['room'] = $_POST['room'];
        // $result = Db::table('test')->insert($data);

        // dump($result);


    }
}
