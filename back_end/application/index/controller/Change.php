<?php

namespace app\index\controller;

use think\Db;
use think\Validate;
use phpmailer\PHPMailer;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

class Change extends BaseController
{
    /**
     * 修改昵称
     */
    public function changeUsername()
    {
        $parameter = array();
        $parameter = ['id', 'username'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        //验证规则（昵称）
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $vusername = new Validate([['username', 'require|/^[A-Za-z0-9#\x{4e00}-\x{9fa5}]{6,16}$/u']]); // bug 汉字只占一个字符
        } else {
            $vusername = new Validate([['username', 'require|/^[A-Za-z0-9#\x{4e00}-\x{9fa5}]{3,16}$/u']]); // bug 汉字只占一个字符
        }
        $data = ['username' => $_POST['username']];

        //验证
        if (!$vusername->check($data)) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '6-16个字符，只可包含汉字、数字、字母、#';
            return json($return_data);
        }

        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('username', $_POST['username']);
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('username', $_POST['username']);
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['username'] = $_POST['username'];
            return json($return_data);
        } else {
            // 更新数据执行失败
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '修改失败';
            return json($return_data);
        }
    }
    /**
     * 修改年级
     */
    public function changeGrade()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['id', 'grade'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
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
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '修改失败';
            return json($return_data);
        }
    }

    /**
     * 修改系
     */
    public function changeDepartment()
    {
        $parameter = array();
        $parameter = ['id', 'department'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
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
            $return_data['msg'] = '修改成功';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['department'] = $_POST['department'];
            return json($return_data);
        } else {
            // 更新数据执行失败
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '修改失败';
            return json($return_data);
        }
    }


    /**
     * 修改宿舍号
     */
    public function changeDormNumber()
    {
        $parameter = array();
        $parameter = ['student_id', 'block', 'room'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $dormNumber = $_POST['block'] . '#' . $_POST['room'];
        $get = Db('dorm')
            ->where(['dorm_num' => $dormNumber])
            ->find();

        //更新数据
        if (!$get) {
            $data = array('block' => $_POST['block'], 'room' => $_POST['room'], 'dorm_num' => $dormNumber);
            $result = Db('dorm')->where(['student_id' => $_POST['student_id']])->setField($data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '请输入自己的宿舍！';
            return json($return_data);
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
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '修改失败';
            return json($return_data);
        }
    }

    /**
     * 修改密码
     */
    public function changePassword()
    {
        $parameter = array();
        $parameter = ['id', 'oldPassword', 'newPassword', 'password_again'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 先从学生表中查询，若不存在从辅导员表中查询
        $user = Db('student')
            ->where(['id' => $_POST['id']])
            ->find();

        if (empty($user)) {
            $user = Db('counselor')
                ->where(['id' => $_POST['id']])
                ->find();
        }


        //判断原密码
        if (md5($_POST['oldPassword']) != $user['password']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '密码不正确，请重新输入';
            return json($return_data);
        }

        //判断两次密码是否一样
        if ($_POST['newPassword'] != $_POST['password_again']) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '两次密码不一致';
            return json($return_data);
        }


        $data = [
            'newPassword' => $_POST['newPassword'],
            'password_again' => $_POST['password_again']
        ];

        // 验证规则（密码）
        $vpassword = new Validate([
            ['newPassword', 'require|/^[0-9a-zA-Z-#_*%$@!?^]{8,16}$/i'],
            ['password_again', 'require|/^[0-9a-zA-Z-#_*%$@!?^]{8,16}$/i']
        ]);

        //验证
        if (!$vpassword->check($data)) {
            $return_data = array();
            $return_data['error_code'] = 4;
            $return_data['msg'] = '8-16位长度，须包含数字、字母、符号至少2种或以上元素';
            return json($return_data);
        }

        //更新数据
        if (Db('student')->where(['id' => $_POST['id']])->find()) {
            $result = Db('student')->where(['id' => $_POST['id']])->setField('password', md5($_POST['newPassword']));
        } else {
            $result = Db('counselor')->where(['id' => $_POST['id']])->setField('password', md5($_POST['newPassword']));
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功';
            return json($return_data);
        } else {
            // 更新数据执行失败
            $return_data = array();
            $return_data['error_code'] = 5;
            $return_data['msg'] = '修改失败';
            return json($return_data);
        }
    }

    //发送手机验证码
    public function sendMessage()
    {
        $parameter = array();
        $parameter = ['phone'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $vphone = new Validate([
            ['phone', 'max:11|/^1[3-8]{1}[0-9]{9}$/']
        ]);

        //验证
        if (!$vphone->check($_POST['phone'])) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '无效的手机号码';
            return json($return_data);
        }

        $phone = $_POST['phone'];
        cookie('code', rand(100000, 999999), 3600);
        $code = cookie('code');         // 验证码

        require_once EXTEND_PATH . 'api_sdk/vendor/autoload.php';
        Config::load();
        $product = "Dysmsapi";
        $domain = "dysmsapi.aliyuncs.com";
        $accessKeyId = "LTAI4GF7ef5Wyc3A8nZRi2EW";
        $accessKeySecret = "wMV3FQP1cM8ZOo8YH39Q739kwc00qW";
        $region = 'cn-hangzhou';
        $endPointName = 'cn-hangzhou';  //服务节点

        //初始化profile
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        //增加服务节点
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
        //初始化acsClient用于发送请求
        $acsClient = new DefaultAcsClient($profile);

        $request = new SendSmsRequest();
        $request->setPhoneNumbers($phone);
        $request->setSignName("CQCQ");
        $request->setTemplateCode("SMS_188991747");
        $request->setTemplateParam(json_encode(['code' => $code]));
        $acsResponse = $acsClient->getAcsResponse($request);

        if ($acsResponse) {   // 发送邮件
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '发送验证码成功';
            $return_data['data']['phone'] = $phone;
            $return_data['data']['captcha'] = $code;
            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '发送验证码失败';
            return json($return_data);
        }
    }



    /**
     * 手机修改验证
     */
    public function verifyModifyPhone()
    {
        $parameter = array();
        $parameter = ['id', 'phone', 'captcha'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

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
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '修改失败！';
            return json($return_data);
        }
    }

    /**
     * 发送邮箱验证码
     */
    public function sendMail()
    {
        $parameter = array();
        $parameter = ['email'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $vemail = new Validate([
            ['email', 'email']
        ]);

        //验证
        if (!$vemail->check($_POST['email'])) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '无效的邮箱地址';
            return json($return_data);
        }
        $email = $_POST['email'];

        //本人邮箱配置
        $sendmail = 'oeong@oeong.xyz';
        $sendmailpswd = "GOGOoeong1412"; //授权码

        $send_name = 'CQCQ';    // 发件人名字
        $toemail = $email;      // 收件人邮箱
        $to_name = 'test';        // 收件人信息

        $mail = new PHPMailer();
        $mail->isSMTP();                    // 使用SMTP服务
        $mail->CharSet = "utf8";            // 编码格式
        $mail->Host = "smtpdm.aliyun.com";        // 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;             // 是否使用身份验证
        $mail->Username = $sendmail;        // 发送方的
        $mail->Password = $sendmailpswd;    // 授权码
        $mail->SMTPSecure = "ssl";          // 使用ssl协议方式
        $mail->Port = 465;
        $mail->setFrom($sendmail, $send_name);      // 设置发件人信息
        $mail->addAddress($toemail, $to_name);      // 设置收件人信息
        $mail->addReplyTo($sendmail, $send_name);   // 设置回复人信息
        cookie('code', rand(100000, 999999), 3600);
        $code = cookie('code');         // 验证码
        $mail->Subject = "验证邮件";    // 邮件标题

        cookie("aliyunCode", $code);
        $mail->Body = "邮件内容是您的验证码是：" . $code . "，如果非本人操作无需理会！";    // 邮件正文

        if (!$mail->send()) {   // 发送邮件
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '发送验证码错误';
            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '发送验证码成功';
            $return_data['data']['email'] = $email;
            $return_data['data']['captcha'] = $code;
            return json($return_data);
        }
    }

    /**
     * 邮箱验证
     */
    public function verifyModifyEmail()
    {
        $parameter = array();
        $parameter = ['id', 'email', 'captcha'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

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
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '修改失败！';
            return json($return_data);
        }
    }

    /**
     * 修改性别
     */
    public function changeSex()
    {
        $parameter = array();
        $parameter = ['id', 'sex'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        //验证
        if ($_POST['sex'] !== '男' && $_POST['sex'] !== '女') {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '输入为男或女';
            return json($return_data);
        }

        //更新数据
        $result = Db('student')->where(['id' => $_POST['id']])->setField('sex', $_POST['sex']);

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['sex'] = $_POST['sex'];
            return json($return_data);
        } else {
            // 更新数据执行失败
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '修改失败';
            return json($return_data);
        }
    }
}
