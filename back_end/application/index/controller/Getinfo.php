<?php

namespace app\index\controller;

use think\Db;
use think\Validate;

class Getinfo extends BaseController
{

    /**
     * 获取个人信息页面
     */
    public function getHomeInfo()
    {

        $get = Db('counselor')
            ->field('id, username, email, phone, grade, department')
            ->where(['id' => $_POST['id']])
            ->find();

        if (empty($get)) { //学生

            $getStuInfo = Db('student')
                ->field('id, sex, username, email, phone, grade, department, sex')
                ->where(['id' => $_POST['id']])
                ->select();

            $getRoom = Db('dorm')
                ->field('id, student_id, block, room, dorm_num')
                ->where(['student_id' => $_POST['id']])
                ->select();

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '获取数据成功！';
            $return_data['data']['stuInfo'] = $getStuInfo;
            $return_data['data']['roomInfo'] = $getRoom;
            return json($return_data);
        } else { //辅导员
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '获取数据成功！';
            $return_data['data'] = $get;
            return json($return_data);
        }
    }
}
