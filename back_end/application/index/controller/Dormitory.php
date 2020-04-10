<?php

namespace app\index\controller;

use \think\Db;

class Dormitory extends BaseController
{
    /**
     * 抽取宿舍
     */
    public function draw()
    {

        //query方法用于执行SQL查询操作
        $cnt = Db::query("select count(*) as cnt from dorm");
        $cnt = $cnt[0]['cnt'];
        // dump($cnt[0]['cnt']);

        
        $book = array();
        $return_data = array();
        for ($i = 0; $i < 4; $i++) {
            do {
                $where = array();
                $where['id'] = rand(1, $cnt);
                $where['sex'] = '男';
                $result = db('dorm')->where($where)->find();
            } while ($book[$result['id']]);
            dump(1);
            $book[$result['id']] = 1; // 标记为1，表示被抽过
            $return_data['dormNumber'] = $result['dormNumber'];
            $return_data['data']['randNumber'] = rand(1, 10000);    // [1, 10000]的随机数
        }



        return json($return_data);


    }


    /**
     * 抽取指定宿舍
     */
    public function customize()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['block', 'room'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;

                return json($return_data);
            }
        }

        // 查询宿舍
        $where = array();
        $where['dormNumber'] = $_POST['block'] . '#' . $_POST['room'];
        $result = db('dorm')->where($where)->find();

        // dump(rand(1, 2));
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '指定成功';
            $return_data['data']['dormNumber'] = $result['dormNumber'];
            $return_data['data']['randNumber'] = rand(1, 10000);    // [1, 10000]的随机数
            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '无此宿舍';

            return json($return_data);
        }
    }
}
