<?php

namespace app\index\controller;

use \think\Db;

class Record extends BaseController
{

    /**
     * 随机抽取宿舍
     */
    public function draw()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['numOfBoys', 'numOfGirls', 'department', 'grade'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $numOfBoys = $_POST['numOfBoys'];
        $numOfGirls = $_POST['numOfGirls'];

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];


        $boy = Db::table('dorm')
            ->field('dormNumber')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('sex', '男')
            ->orderRaw('rand()')
            ->limit($numOfBoys)
            ->select();
        $girl = Db::table('dorm')
            ->field('dormNumber')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('sex', '女')
            ->orderRaw('rand()')
            ->limit($numOfGirls)
            ->select();

        if ($girl && $boy) {
            for ($i = 0; $i < $numOfBoys; $i++) {
                $boy[$i]['randNumber'] = rand(1, 10000);
            }
            for ($i = 0; $i < $numOfGirls; $i++) {
                $girl[$i]['randNumber'] = rand(1, 10000);
            }

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '抽签成功';
            $return_data['data']['dorm'] = array_merge_recursive($boy, $girl);

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '抽签失败';

            return json($return_data);
        }
    }


    /**
     * 抽取指定宿舍
     */
    public function customize()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['block', 'room', 'department', 'grade'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['dormNumber'] = $_POST['block'] . '#' . $_POST['room'];

        $result = Db::table('dorm')
            ->field('dormNumber')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('sex', '男')
            ->find();   // 查询单个数据

        dump($result);
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
