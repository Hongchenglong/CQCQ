<?php

namespace app\index\controller;

use \think\Controller;

// 基础控制器

class BaseController extends Controller
{
    public function _initialize()
    {
    }

    public function ballot($sex, $num, $total, $book, $return_data)
    {
        $result = array();
        for ($i = 0; $i < $num; $i++) {
            do {
                $where = array();
                $where['id'] = rand(1, $total);
                $where['sex'] = $sex;
                $result = db('dorm')->where($where)->find();
                dump($result);
            } while ($book[$result['id']]);

            $book[$result['id']] = 1; // 标记为1，表示被抽过
            $return_data['data']['dormNumber'] = $result['dormNumber'];
            $return_data['data']['randNumber'] = rand(1, 10000);    // [1, 10000]的随机数
        }
        return $return_data;
    }


    // 检查参数是否存在
    public function checkForExistence($parameter)
    {
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                // print_r(json($return_data));
                return json($return_data);
            }
        }
    }
}
