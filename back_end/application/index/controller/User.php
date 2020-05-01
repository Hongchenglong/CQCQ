<?php

namespace app\index\controller;

use \think\Db;

class User extends BaseController
{

    /**
     * 用户登录
     * @return [type] [description]
     */
    public function login()
    {

        // 校验参数是否存在
        if (empty($_POST['password'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足: password';

            return json($return_data);
        }

        $account = '';
        // 构造查询条件
        $where = array();
        $parameter = array();
        $parameter = ['id', 'phone', 'email'];
        foreach ($parameter as $key => $value) {
            if (!empty($_POST[$value])) {
                $account = $value;
                $where[$value] = $_POST[$value];    // 3个至少有一个
            }
        }

        //  3个都不存在 
        if (empty($where)) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足: id/phone/email';

            return json($return_data);
        }

        // 先从学生表中查询，若不存在从辅导员表中查询
        $user = Db::table('student')
            ->where($where)
            ->find();
            
        if (empty($user)) {
            $user = Db::table('counselor')
                ->where($where)
                ->find();
        }

        // dump($user);
        // 如果查询到该手机号用户
        if ($user) {
            // 如果密码不等
            if (md5($_POST['password']) != $user['password']) {
                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = '密码不正确，请重新输入';

                return json($return_data);
            } else {
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '登录成功';

                $return_data['data']['user_id'] = $user['id'];
                $return_data['data']['username'] = $user['username'];
                $return_data['data']['phone'] = $user['phone'];
                $return_data['data']['face_url'] = $user['face_url'];

                return json($return_data);
            }
        } else {
            // 用户不存在
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '不存在该'. $account.'用户，请注册';

            return json($return_data);
        }
    }


    /**
     * 用户注册
     * @return [type] [description]
     */
    public function sign()
    {

        // 校验参数是否存在
        $parameter = array();
        $parameter = ['username', 'password', 'password_again', 'email', 'phone'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;

                return json($return_data);
            }
        }

        // 检验两次密码是否输入一致
        if ($_POST['password'] != $_POST['password_again']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '两次密码不一致';

            return json($return_data);
        }

        // 检验邮箱、手机号是否已被注册
        // 构造查询条件
        $parameter = array();
        $parameter = ['email', 'phone'];
        foreach ($parameter as $key => $value) {
            $where = array();
            $where[$value] = $_POST[$value];
            $user = db('user')->where($where)->find();
            if ($user) {
                // 如果存在，提示已注册
                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = $value . '已被注册';

                return json($return_data);
            }
        }


        // 如果尚未注册，则注册
        $data = array();
        $data['username'] = $_POST['username'];
        $data['phone'] = $_POST['phone'];
        $data['email'] = $_POST['email'];
        // 密码经过md5函数加密，得到32位字符串
        $data['password'] = md5($_POST['password']);

        // dump(1);
        // 插入记录并获取自增ID
        $result = db('user')->insertGetId($data);

        // dump($result);
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '注册成功';
            $return_data['data']['user_id'] = $result;
            $return_data['data']['username'] = $_POST['username'];
            $return_data['data']['phone'] = $_POST['phone'];
            $return_data['data']['email'] = $_POST['email'];

            return json($return_data);
        } else {
            // 插入数据执行失败
            $return_data = array();
            $return_data['error_code'] = 4;
            $return_data['msg'] = '注册失败';

            return json($return_data);
        }
    }
}
