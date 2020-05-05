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
        $parameter = ['grade', 'department', 'sex', 'block', 'room', 'studentId'];
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

        // 检验宿舍号是否已存在
        $dorm = Db::table('dorm')
            ->field('dorm.id, dorm_num')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')->where($where)->find();

        // 检验学号是否已被注册
        $where = array();
        $where['id'] = $_POST['studentId'];
        $student = db('student')->where($where)->find();

        if ($dorm) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '该宿舍已存在';
            return json($return_data);
        } else if ($student) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '学号' . $_POST['studentId'] . '已存在';

            return json($return_data);
        } else {
            // 添加宿舍
            $data = array();
            $data['room'] = $_POST['room'];
            $data['block'] = $_POST['block'];
            $data['student_id'] = $_POST['studentId'];
            $data['dorm_num'] = $_POST['block'] . '#' . $_POST['room'];
            $dorm = db('dorm')->insert($data);

            // 如果尚未注册，则注册
            $data = array();
            $data['id'] = $_POST['studentId'];
            $data['sex'] = $_POST['sex'];
            $data['username'] = $_POST['block'] . '#' . $_POST['room'];
            $data['grade'] =  $_POST['grade'];
            $data['department'] = $_POST['department'];
            // 密码经过md5函数加密，得到32位字符串
            $data['password'] = md5($data['id']);
            $student = db('student')->insert($data);

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '添加成功';
            $return_data['data']['dorm'] = $_POST['block'] . '#' . $_POST['room'];
            $return_data['data']['student'] = $_POST['studentId'];

            return json($return_data);
        }
    }

    /**
     * 添加宿舍后的删除宿舍
     */
    public function delete()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['grade', 'department', 'sex', 'block', 'room', 'studentId'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 删除宿舍
        $where = array();
        $where['room'] = $_POST['room'];
        $where['block'] = $_POST['block'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        // $result = Db::table('dorm')
        //     ->alias('d')    // 别名
        //     ->join('student s', 's.id = d.student_id')
        //     ->where($where)
        //     ->delete();
        $result = Db::execute(
            "delete d from dorm d join student s on s.id = d.student_id 
            where s.grade=:grade and s.department=:department and d.room=:room and d.block=:block",
            ['grade' => $where['grade'], 'department' => $where['department'], 'room' => $where['room'], 'block' => $where['block']]
        );

        // 删除账号
        $where = array();
        $where['sex'] = $_POST['sex'];
        $where['id'] = $_POST['studentId'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $result = Db::table('student')
            ->where($where)
            ->delete();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '删除成功';

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '没有可删除的宿舍';

            return json($return_data);
        }
    }

    /**
     * 获取区号
     */
    public function getBlock()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['grade', 'department'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }
        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $result = db('dorm')
            ->field('block')
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->distinct(true)
            ->where($where)
            ->select();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '成功获取区号';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '暂无区号';
            return json($return_data);
        }
    }
}
