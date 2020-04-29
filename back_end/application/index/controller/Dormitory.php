<?php

namespace app\index\controller;

use \think\Db;

class Dormitory extends BaseController
{
    /**
     * 查看宿舍
     */
    public function examine()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['grade', 'department', 'block'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询条件
        $where = array();
        $where['block'] = $_POST['block'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];

        $result = Db::table('dorm')
            ->field('block, room')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->select();

            // dump($result);
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '查看成功';
            $return_data['data'] = $result;


            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '无该区的宿舍信息';

            return json($return_data);
        }
        
    }

    /**
     * 添加宿舍
     */
    public function insert()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['grade', 'department', 'sex', 'block', 'room'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询宿舍
        $where = array();
        $where['sex'] = $_POST['sex'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['dorm_num'] = $_POST['block'] . '#' . $_POST['room'];
        $result = db('dorm')->where($where)->find();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '该宿舍已存在';
            return json($return_data);
        } else {
            db('dorm')->where($where)->insert();
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '添加成功';
            return json($return_data);
        }
    }

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
            ->field('dorm.id, dorm_num')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('sex', '男')
            ->orderRaw('rand()')
            ->limit($numOfBoys)
            ->select();
        $girl = Db::table('dorm')
            ->field('dorm.id, dorm_num')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('sex', '女')
            ->orderRaw('rand()')
            ->limit($numOfGirls)
            ->select();

        if ($girl && $boy) {

            // 获取随机数，并将抽到的宿舍添加到record表中
            for ($i = 0; $i < $numOfBoys; $i++) {
                $boy[$i]['rand_num'] = rand(1, 10000);
                $data = array();
                $data['dorm_id'] = $boy[$i]['id'];
                $data['rand_num'] = $boy[$i]['rand_num'];
                Db::table('record')->insert($data);
            }
            for ($i = 0; $i < $numOfGirls; $i++) {
                $girl[$i]['rand_num'] = rand(1, 10000);
                $data = array();
                $data['dorm_id'] = $girl[$i]['id'];
                $data['rand_num'] = $girl[$i]['rand_num'];
                Db::table('record')->insert($data);
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
        $where['dorm_num'] = $_POST['block'] . '#' . $_POST['room'];

        $result = Db::table('dorm')
            ->field('dorm_num')   // 指定字段
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
            $return_data['data']['dorm_num'] = $result['dorm_num'];
            $return_data['data']['rand_num'] = rand(1, 10000);    // [1, 10000]的随机数
            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '无此宿舍';

            return json($return_data);
        }
    }

}
