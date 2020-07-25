<?php

namespace app\api\controller;

use think\Validate;

class Change extends BaseController
{
    /**
     * 修改昵称
     */
    public function changeUsername()
    {
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['username'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户名！']);
        }

        //验证规则（昵称）
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $vusername = new Validate([['username', 'require|/^[a-zA-Z\x{4e00}-\x{9fa5}]{2,16}$/u']]); // 注：汉字只占一个字符
        } else {
            $vusername = new Validate([['username', 'require|/^[a-zA-Z\x{4e00}-\x{9fa5}]{2,16}$/u']]);
        }
        $data = ['username' => $_POST['username']];

        //验证
        if (!$vusername->check($data)) {
            return json(['error_code' => 2, 'msg' => '2-16个字符，只可包含汉字、字母！']);
        }

        // 更新数据
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('username', $_POST['username']);
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('username', $_POST['username']);
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功!';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['username'] = $_POST['username'];
            return json($return_data);
        } else {
            // 更新数据执行失败
            return json(['error_code' => 3, 'msg' => '请勿输入原昵称！']);
        }
    }
    /**
     * 修改年级
     */
    public function changeGrade()
    {
        // $parameter = ['id', 'grade'];
        // 输入判断
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        }

        //更新数据
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('grade', $_POST['grade']);
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('grade', $_POST['grade']);
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['grade'] = $_POST['grade'];
            return json($return_data);
        } else {
            // 更新数据执行失败
            return json(['error_code' => 2, 'msg' => '请勿输入原年级！']);
        }
    }

    /**
     * 修改系
     */
    public function changeDepartment()
    {
        // $parameter = ['id', 'department'];

        // 输入判断
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        }

        //更新数据
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('department', $_POST['department']);
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('department', $_POST['department']);
        }
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功！';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['department'] = $_POST['department'];
            return json($return_data);
        } else {
            // 更新数据执行失败
            return json(['error_code' => 2, 'msg' => '请勿输入原系别！']);
        }
    }


    /**
     * 修改宿舍号
     */
    /*
    public function changeDormNumber()
    {

        // $parameter = ['student_id', 'block', 'room'];

        // 输入判断
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['block'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍楼！']);
        } else if (empty($_POST['room'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍号！']);
        }

        // 组合宿舍号dorm_num
        $dormNumber = $_POST['block'] . '#' . $_POST['room'];
        $data = array('block' => $_POST['block'], 'room' => $_POST['room'], 'dorm_num' => $dormNumber);

        // 数据库里是否已存在该宿舍
        $get = Db('dorm')
            ->where(['dorm_num' => $dormNumber])
            ->find();

        // 获取自己信息里的宿舍
        $judge = Db('dorm')
            ->field('dorm_num')
            ->where(['student_id' => $_POST['student_id']])
            ->find();

        // 更新数据
        // 数据库不存在该宿舍=>允许修改
        if (!$get) {
            $result = Db('dorm')->where(['student_id' => $_POST['student_id']])->setField($data);
        } else if ($get && $judge['dorm_num'] == $dormNumber) { // 数据库存在该宿舍 && 与自己的原宿舍一致 =>不允许修改
            $result = 0;
        } else {
            return json(['error_code' => 2, 'msg' => '请输入自己的宿舍！']);
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功';
            $return_data['data']['student_id'] = $_POST['student_id'];
            $return_data['data']['block'] = $_POST['block'];
            $return_data['data']['room'] = $_POST['room'];
            $return_data['data']['dorm_num'] = $dormNumber;
            return json($return_data);
        } else {
            // 更新数据执行失败
            return json(['error_code' => 3, 'msg' => '请勿输入原宿舍号！']);
        }
    }
    */

    /**
     * 修改密码
     */
    public function changePassword()
    {

        // $parameter = ['id', 'oldPassword', 'newPassword', 'password_again'];
        // 输入判断

        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['oldPassword'])) {
            return json(['error_code' => 1, 'msg' => '请输入原密码！']);
        } else if (empty($_POST['newPassword'])) {
            return json(['error_code' => 1, 'msg' => '请输入新密码！']);
        } else if (empty($_POST['password_again'])) {
            return json(['error_code' => 1, 'msg' => '请再次输入新密码！']);
        }

        // 先从学生表中查询，若不存在从辅导员表中查询
        $user = Db('student')->where(['id' => $_POST['id']])->find();

        if (empty($user)) {
            $user = Db('counselor')->where(['id' => $_POST['id']])->find();
        }

        //判断原密码
        if (md5($_POST['oldPassword']) != $user['password']) {
            return json(['error_code' => 2, 'msg' => '密码不正确，请重新输入!']);
        }

        //判断两次密码是否一样
        if ($_POST['newPassword'] != $_POST['password_again']) {
            return json(['error_code' => 3, 'msg' => '两次密码不一致!']);
        }

        $data = [
            'newPassword' => $_POST['newPassword'],
            'password_again' => $_POST['password_again']
        ];

        // 验证规则（密码）
        $vpassword = new Validate([
            ['newPassword', 'require|/^(?![0-9]+$)(?![a-zA-Z]+$)(?![a-zA-Z\\W]+$)[0-9A-Za-z\\W]{8,16}$/'],
            ['password_again', 'require|/^(?![0-9]+$)(?![a-zA-Z]+$)(?![a-zA-Z\\W]+$)[0-9A-Za-z\\W]{8,16}$/']
        ]);

        //验证
        if (!$vpassword->check($data)) {
            return json(['error_code' => 4, 'msg' => '8-16位长度，须包含数字、字母、符号至少2种或以上元素！']);
        }

        //更新数据
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('password', md5($_POST['newPassword']));
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('password', md5($_POST['newPassword']));
        }

        if ($result) {
            return json(['error_code' => 0, 'msg' => '修改成功！']);
        } else {
            // 更新数据执行失败
            return json(['error_code' => 5, 'msg' => '请勿将新密码修改为原密码！']);
        }
    }

    //发送手机验证码
    public function sendMessage()
    {

        // $parameter = ['phone', 'id'];
        // 输入判断

        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['phone'])) {
            return json(['error_code' => 1, 'msg' => '请输入手机号！']);
        }

        $vphone = new Validate([
            ['phone', 'max:11|/^1[3-8]{1}[0-9]{9}$/']
        ]);

        //验证
        if (!$vphone->check($_POST['phone'])) {
            return json(['error_code' => 2, 'msg' => '无效的手机号码！']);
        }

        //查看该id下的手机号
        $userPhone = Db('counselor') //辅导员
            ->field('phone')
            ->where(['id' => $_POST['id']])
            ->find();

        if (empty($userPhone)) {
            $userPhone = Db('student') //学生
                ->field('phone')
                ->where(['id' => $_POST['id']])
                ->find();
        }
        if ($userPhone) {
            if ($_POST['phone'] == $userPhone['phone']) {
                return json(['error_code' => 3, 'msg' => '请勿输入原手机号！']);
            }
        }

        // 判断输入的手机号是否已经被他人绑定
        $user = Db('counselor') //辅导员
            ->where(['phone' => $_POST['phone']])
            ->find();

        if (empty($user)) {
            $user = Db('student')  //学生
                ->where(['phone' => $_POST['phone']])
                ->find();
        }

        if ($user) {
            return json(['error_code' => 4, 'msg' => '该手机号已经有人绑定！']);
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
            return json(['error_code' => 5, 'msg' => '发送验证码失败！']);
        }
    }


    /**
     * 手机修改验证
     */
    public function verifyModifyPhone()
    {
        // $parameter = ['id', 'phone', 'captcha'];
        // 输入判断
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['phone'])) {
            return json(['error_code' => 1, 'msg' => '请输入手机号！']);
        } else if (empty($_POST['captcha'])) {
            return json(['error_code' => 1, 'msg' => '请输入验证码！']);
        }

        // 判断用户类型
        // 更新数据
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('phone', $_POST['phone']);
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('phone', $_POST['phone']);
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功！';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['phone'] = $_POST['phone'];
            return json($return_data);
        } else {
            return json(['error_code' => 2, 'msg' => '请勿重复修改！']);
        }
    }

    /**
     * 发送邮箱验证码
     */
    public function sendMail()
    {
        // $parameter = ['email', 'id'];
        // 输入判断
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['email'])) {
            return json(['error_code' => 1, 'msg' => '请输入邮箱！']);
        }

        $vemail = new Validate([
            ['email', 'email']
        ]);

        //验证
        if (!$vemail->check($_POST['email'])) {
            return json(['error_code' => 2, 'msg' => '无效的邮箱地址！']);
        }

        //查看该id下的email
        $userEmail = Db('counselor') //辅导员
            ->field('email')
            ->where(['id' => $_POST['id']])
            ->find();

        if (empty($userEmail)) {
            $userEmail = Db('student') //学生
                ->field('email')
                ->where(['id' => $_POST['id']])
                ->find();
        }
        if ($userEmail) {
            if ($_POST['email'] == $userEmail['email']) {
                return json(['error_code' => 3, 'msg' => '请勿输入原邮箱！']);
            }
        }

        // 判断输入的邮箱是否已经被他人绑定
        $user = Db('counselor') //辅导员
            ->where(['email' => $_POST['email']])
            ->find();

        if (empty($user)) {
            $user = Db('student')  //学生
                ->where(['email' => $_POST['email']])
                ->find();
        }

        if ($user) {
            return json(['error_code' => 4, 'msg' => '该邮箱已经有人绑定！']);
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
            return json(['error_code' => 5, 'msg' => '发送验证码错误！']);
        }
    }

    /**
     * 邮箱验证
     */
    public function verifyModifyEmail()
    {
        // $parameter = ['id', 'email', 'captcha'];
        // 输入判断
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        } else if (empty($_POST['email'])) {
            return json(['error_code' => 1, 'msg' => '请输入邮箱！']);
        } else if (empty($_POST['captcha'])) {
            return json(['error_code' => 1, 'msg' => '请输入验证码！']);
        }

        // 判断用户类型
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('email', $_POST['email']);
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('email', $_POST['email']);
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功！';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['email'] = $_POST['email'];
            return json($return_data);
        } else {
            return json(['error_code' => 2, 'msg' => '请勿重复修改！']);
        }
    }
}
