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
        // $parameter = ['id', 'password'];
        // 输入判断
        if (empty($_POST['id'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入用户id！';
            return json($return_data);
        } else if (empty($_POST['password'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入密码！';
            return json($return_data);
        } 
        $where['id'] = $_POST['id'];

        // 先从辅导员表中查询，若不存在从学生表中查询
        $user = Db::table('counselor')
            ->where($where)
            ->find();
        if ($user) $user['user'] = 'counselor';

        if (empty($user)) {
            $user = Db::table('student')
                ->where($where)
                ->find();
            if ($user) $user['user'] = 'student';
        }
        // 如果查询到该用户
        if ($user) {
            // 如果密码不等
            if (md5($_POST['password']) != $user['password']) {
                $return_data = array();
                $return_data['error_code'] = 2;
                $return_data['msg'] = '您输入的账号或密码不正确';

                return json($return_data);
            } else {
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '登录成功';
                $return_data['data'] = $user;

                return json($return_data);
            }
        } 
        else {
            // 用户不存在
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '您输入的账号或密码不正确';

            return json($return_data);
        }
    }


    /**
     * 用户注册
     * @return [type] [description]
     */
    public function sign()
    {
        // $parameter = ['username', 'password', 'password_again', 'email', 'phone'];
        // 输入判断
        if (empty($_POST['username'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入昵称！';
            return json($return_data);
        } else if (empty($_POST['password'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入密码！';
            return json($return_data);
        } else if (empty($_POST['password_again'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请再次输入密码！';
            return json($return_data);
        } else if (empty($_POST['email'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入邮箱！';
            return json($return_data);
        } else if (empty($_POST['phone'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入手机号！';
            return json($return_data);
        } 

        // 检验两次密码是否输入一致
        if ($_POST['password'] != $_POST['password_again']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '两次密码不一致!';

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
                $return_data['msg'] = $value . '已被注册!';

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
            $return_data['msg'] = '注册失败!';

            return json($return_data);
        }
    }
}
