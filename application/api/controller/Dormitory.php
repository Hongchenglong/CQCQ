<?php

namespace app\api\controller;

use \think\Db;

class Dormitory extends BaseController
{
    /**
     * 查看宿舍
     */
    public function examine()
    {
        // $parameter = ['grade', 'department', 'block'];
        // 输入判断
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['block'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍楼！']);
        }

        // 查询条件
        $where = array();
        $where['block'] = $_POST['block'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];

        $result = Db::table('cq_dorm')
            ->field('block, room')   // 指定字段
            ->alias('d')    // 别名
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->order('room')
            ->where($where)
            ->distinct(true)   // 返回唯一不同的值
            ->select();

        // dump($result);
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '查看成功！';
            $return_data['data'] = $result;
            return json($return_data);
        } else {
            return json(['error_code' => 2, 'msg' => '无该区的宿舍信息！']);
        }
    }

    /**
     * 添加宿舍
     */
    public function insert()
    {
        // $parameter = ['grade', 'department', 'sex', 'block', 'room', 'studentId'];
        // 输入判断

        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['block'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍楼！']);
        } else if (empty($_POST['room'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍号！']);
        } else if (empty($_POST['sex'])) {
            return json(['error_code' => 1, 'msg' => '请输入性别！']);
        } else if (empty($_POST['studentId'])) {
            return json(['error_code' => 1, 'msg' => '请输入学号！']);
        } else if (strlen($_POST['studentId']) != 9) {
            return json(['error_code' => 1, 'msg' => '请输入9位数的学号！']);
        }

        $dorm_num = $_POST['block'] . '#' . $_POST['room'];

        // 检验学号是否已被注册
        $where = array();
        $where['id'] = $_POST['studentId'];
        $student = Db::table('cq_student')->where($where)->find();

        // 查询宿舍
        $where = array();
        $where['sex'] = $_POST['sex'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['dorm_num'] = $dorm_num;
        $dorm = Db::table('cq_dorm')
            ->field('dorm.id, dorm_num')   // 指定字段
            ->alias('d')    // 别名
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->find();

        if ($student) {
            return json(['error_code' => 2, 'msg' => '学号' . $_POST['studentId'] . '已存在！']);
        } else {
            // 如果宿舍不存在，则添加
            if (empty($dorm)) {
                $data = array();
                $data['room'] = $_POST['room'];
                $data['block'] = $_POST['block'];
                $data['dorm_num'] = $dorm_num;
                $dorm = Db::table('cq_dorm')->insert($data);
            }

            // 如果尚未注册，则注册
            $data = array();
            $data['id'] = $_POST['studentId'];
            $data['sex'] = $_POST['sex'];
            $data['username'] = $dorm_num;
            $data['dorm'] = $dorm_num;
            $data['grade'] =  $_POST['grade'];
            $data['department'] = $_POST['department'];

            // 密码经过md5函数加密，得到32位字符串
            $data['password'] = md5($data['id']);
            $student = Db::table('cq_student')->insert($data);

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '添加成功';
            $return_data['data']['dorm'] = $dorm_num;
            $return_data['data']['student'] = $_POST['studentId'];
            return json($return_data);
        }
    }

    /**
     * 添加宿舍后的删除宿舍
     */
    public function delete()
    {
        // $parameter = ['grade', 'department', 'sex', 'block', 'room', 'studentId'];
        // 输入判断
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['block'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍楼！']);
        } else if (empty($_POST['room'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍号！']);
        } else if (empty($_POST['sex'])) {
            return json(['error_code' => 1, 'msg' => '请输入性别！']);
        } else if (empty($_POST['studentId'])) {
            return json(['error_code' => 1, 'msg' => '请输入学号！']);
        }

        // 删除宿舍 学生数量少于1
        $where = array();
        $where['room'] = $_POST['room'];
        $where['block'] = $_POST['block'];
        $result = Db::table('cq_dorm')
            ->alias('d')
            ->field('s.id')
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->select();
        if (count($result) == 1) {
            $result = Db::execute(
                "delete d from cq_dorm d join cq_student s on s.dorm = d.dorm_num 
            where s.grade=:grade and s.department=:department and d.room=:room and d.block=:block",
                ['grade' => $where['grade'], 'department' => $where['department'], 'room' => $where['room'], 'block' => $where['block']]
            );
        }   

        // 删除账号
        $where = array();
        $where['sex'] = $_POST['sex'];
        $where['id'] = $_POST['studentId'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $result = Db::table('cq_student')
            ->where($where)
            ->delete();

        if ($result) {
            return json(['error_code' => 0, 'msg' => '删除成功！']);
        } else {
            return json(['error_code' => 2, 'msg' => '没有可删除的宿舍！']);
        }
    }

    /**
     * 获取区号
     */
    public function getBlock()
    {
        // $parameter = ['grade', 'department'];
        // 输入判断
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $result = Db::table('cq_dorm')
            ->field('block')
            ->alias('d')    // 别名
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->distinct(true)
            ->where($where)
            ->select();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '成功获取区号!';
            $return_data['data'] = $result;
            return json($return_data);
        } else {
            return json(['error_code' => 2, 'msg' => '暂无区号！']);
        }
    }
}
