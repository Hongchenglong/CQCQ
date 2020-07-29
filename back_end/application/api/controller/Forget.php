<?php

namespace app\api\controller;

use think\Validate;

class Forget extends BaseController
{

    /**
     * 发送手机验证码
     */
    public function sendSms()
    {
        if (empty($_POST['phone'])) {
            return json(['error_code' => 1, 'msg' => '请输入手机号！']);
        }

        //验证规则（手机号码）
        $vphone = new Validate([
            ['phone', 'max:11|/^1[3-8]{1}[0-9]{9}$/']
        ]);

        //验证
        if (!$vphone->check($_POST['phone'])) {
            return json(['error_code' => 2, 'msg' => '无效的手机号码！']);
        }

        //判断是否存在该用户
        $user = Db('student')
            ->where(['phone' => $_POST['phone']])
            ->find();

        if (empty($user)) {
            $user = Db('counselor')
                ->where(['phone' => $_POST['phone']])
                ->find();
        }

        if (!$user) {
            return json(['error_code' => 3, 'msg' => '无此用户！']);
        }

        $res = $this->sendMsg($_POST['phone']); // 调用发送手机短信

        if ($res['acsResponse']) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '发送验证码成功！';
            $return_data['data']['phone'] = $_POST['phone'];
            $return_data['data']['captcha'] = $res['code'];
            return json($return_data);
        } else {
            return json(['error_code' => 4, 'msg' => '发送验证码失败！']);
        }
    }

    /**
     * 手机验证
     */
    public function verifyPhone()
    {
        // $parameter = ['phone', 'captcha'];
        // 输入判断
        if (empty($_POST['phone'])) {
            return json(['error_code' => 1, 'msg' => '请输入手机号！']);
        } else if (empty($_POST['captcha'])) {
            return json(['error_code' => 1, 'msg' => '请输入验证码！']);
        }

        return json(['error_code' => 0, 'msg' => '验证成功！']);
    }


    /**
     * 发送邮箱验证码
     */
    public function sendMailCaptcha()
    {
        if (empty($_POST['email'])) {
            return json(['error_code' => 1, 'msg' => '请输入邮箱！']);
        }

        $vemail = new Validate([
            ['email', 'email']
        ]);

        //验证
        if (!$vemail->check($_POST['email'])) {
            return json(['error_code' => 2, 'msg' => '无效的邮箱地址！']);
        }

        //判断是否存在该用户
        $user = Db('student')
            ->where(['email' => $_POST['email']])
            ->find();

        if (empty($user)) {
            $user = Db('counselor')
                ->where(['email' => $_POST['email']])
                ->find();
        }

        if (!$user) {
            return json(['error_code' => 3, 'msg' => '无此用户！']);
        }

        $res = $this->sendEmail($_POST['email']);

        if ($res['isSuccess']) {   // 发送邮件
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '发送验证码成功！';
            $return_data['data']['email'] = $_POST['email'];
            $return_data['data']['captcha'] = $res['code'];
            return json($return_data);
        } else {
            return json(['error_code' => 4, 'msg' => '发送验证码错误！']);
        }
    }

    /**
     * 邮箱验证
     */
    public function verifyEmail()
    {
        // $parameter = ['email', 'captcha'];
        // 输入判断
        if (empty($_POST['email'])) {
            return json(['error_code' => 1, 'msg' => '请输入邮箱！']);
        } else if (empty($_POST['captcha'])) {
            return json(['error_code' => 1, 'msg' => '请输入验证码！']);
        }

        return json(['error_code' => 0, 'msg' => '验证成功！']);
    }

    /**
     * 修改密码
     */
    public function changePassword()
    {
        // $parameter = ['password', 'password_again', 'phone', 'email'];
        // 输入判断
        if (empty($_POST['password'])) {
            return json(['error_code' => 1, 'msg' => '请输入新密码！']);
        } else if (empty($_POST['password_again'])) {
            return json(['error_code' => 1, 'msg' => '请再次输入新密码！']);
        }

        if (!empty($_POST['email'])) {
            $res = true;
        } else if (!empty($_POST['phone'])) {
            $res = false;
        } else {
            return json(['error_code' => 1, 'msg' => '未输入手机或邮箱！']);
        }

        if ($_POST['password'] != $_POST['password_again']) {
            return json(['error_code' => 2, 'msg' => '两次密码不一致！']);
        }
        $data = [
            'password' => $_POST['password'],
            'password_again' => $_POST['password_again']
        ];

        // 验证规则（密码）
        $vpassword = new Validate([
            ['password', 'require|/^(?![0-9]+$)(?![a-zA-Z]+$)(?![a-zA-Z\\W]+$)[0-9A-Za-z\\W]{8,16}$/'],
            ['password_again', 'require|/^(?![0-9]+$)(?![a-zA-Z]+$)(?![a-zA-Z\\W]+$)[0-9A-Za-z\\W]{8,16}$/']
        ]);

        //验证
        if (!$vpassword->check($data)) {
            return json(['error_code' => 3, 'msg' => '8-16位长度，须包含数字、字母、符号至少2种或以上元素！']);
        }

        //更新数据
        if ($res) {
            if (Db('student')->where(['email' => $_POST['email']])->find()) {
                $result = Db('student')->where(['email' => $_POST['email']])->setField('password', md5($_POST['password']));
            } else if (Db('counselor')->where(['email' => $_POST['email']])->find()) {
                $result = Db('counselor')->where(['email' => $_POST['email']])->setField('password', md5($_POST['password']));
            }
        } else {

            if (Db('student')->where(['phone' => $_POST['phone']])->find()) {
                $result = Db('student')->where(['phone' => $_POST['phone']])->setField('password', md5($_POST['password']));
            } else if (Db('counselor')->where(['phone' => $_POST['phone']])->find()) {
                $result = Db('counselor')->where(['phone' => $_POST['phone']])->setField('password', md5($_POST['password']));
            }
        }

        if ($result) {
            return json(['error_code' => 0, 'msg' => '修改成功！']);
        } else {
            return json(['error_code' => 4, 'msg' => '请勿将新密码修改为原密码！']);
        }
    }
}
