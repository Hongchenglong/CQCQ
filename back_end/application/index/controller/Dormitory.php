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
     * 删除宿舍
     */
    public function delete()
    {
        
    }
}
