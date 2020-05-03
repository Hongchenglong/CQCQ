<?php

namespace app\index\controller;

use \think\Controller;

// 基础控制器

class BaseController extends Controller
{
    public function _initialize()
    {
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

    /**
     * 学生注册
     * @return [type] [description]
     */
    public function sign($studentId, $sex, $username, $grade, $department)
    {

        // 校验参数是否存在
        $parameter = array();
        $parameter = [$studentId, $sex, $username, $grade, $department];
        foreach ($parameter as $key => $value) {
            if (empty($value)) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;

                return json($return_data);
            }
        }

        // 检验学号是否已被注册
        $where = array();
        $where['id'] = $studentId;
        $user = db('student')->where($where)->find();
        if ($user) {
            // 如果存在，提示已注册
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = $value . '已被注册';

            return json($return_data);
        }

        // 如果尚未注册，则注册
        $data = array();
        $data['id'] = $studentId;
        $data['sex'] = $sex;
        $data['username'] = $username;
        $data['grade'] = $grade;
        $data['department'] = $department;
        // 密码经过md5函数加密，得到32位字符串
        $data['password'] = md5($studentId);
        $result = db('student')->insert($data);

        // dump($result);
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '注册成功';
            $return_data['data'] = $data;

            return json($return_data);
        } else {
            // 插入数据执行失败
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '注册失败';

            return json($return_data);
        }
    }
}
