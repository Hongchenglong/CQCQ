<?php

namespace app\index\controller;

use think\Db;
use think\Validate;
use phpmailer\PHPMailer;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

class Forget extends BaseController
{

    /**
     * 发送手机验证码
     */
    public function sendSms()
    {
        if (empty($_POST['phone'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足';
            return json($return_data);
        }

        //验证规则（手机号码）
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
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '无此用户！';
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

        if ($acsResponse) {   // 发送短信
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '发送验证码成功';
            $return_data['data']['phone'] = $phone;
            $return_data['data']['captcha'] = $code;
            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 4;
            $return_data['msg'] = '发送验证码失败';
            return json($return_data);
        }
    }

    /**
     * 手机验证
     */
    public function verifyPhone()
    {
        $parameter = array();
        $parameter = ['phone', 'captcha'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                return json($return_data);
            }
        }

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '验证成功';
        return json($return_data);
    }


    /**
     * 发送邮箱验证码
     */
    public function sendMailCaptcha()
    {
        if (empty($_POST['email'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足';
            return json($return_data);
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
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '无此用户！';
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

        session("aliyunCode", $code);
        $mail->Body = "邮件内容是您的验证码是：" . $code . "，如果非本人操作无需理会！";    // 邮件正文

        if (!$mail->send()) {   // 发送邮件
            $return_data = array();
            $return_data['error_code'] = 4;
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
    public function verifyEmail()
    {
        $parameter = array();
        $parameter = ['email', 'captcha'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                return json($return_data);
            }
        }

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '验证成功';
        return json($return_data);
    }

    /**
     * 修改密码
     */
    public function changePassword()
    {
        $parameter = array();
        $parameter = ['id', 'password', 'password_again'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                return json($return_data);
            }
        }

        if ($_POST['password'] != $_POST['password_again']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '两次密码不一致';
            return json($return_data);
        }
        $data = [
            'password' => $_POST['password'],
            'password_again' => $_POST['password_again']
        ];

        // 验证规则（密码）
        $vpassword = new Validate([
            ['password', 'require|/^[0-9a-zA-Z-#_*%$@!?^]{8,16}$/i'],
            ['password_again', 'require|/^[0-9a-zA-Z-#_*%$@!?^]{8,16}$/i']
        ]);

        //验证
        if (!$vpassword->check($data)) {
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '8-16位长度，须包含数字、字母、符号至少2种或以上元素';
            return json($return_data);
        }

        //更新数据
        $result = Db('student')->where(['id' => $_POST['id']])->setField('password', md5($_POST['password']));

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功';
            return json($return_data);
        } else {
            // 更新数据执行失败
            $return_data = array();
            $return_data['error_code'] = 4;
            $return_data['msg'] = '修改失败';
            return json($return_data);
        }
    }
}
