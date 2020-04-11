<?php

namespace app\index\controller;
use think\Db;
use think\Validate;
use phpmailer\PHPMailer;
class Change extends BaseController
{

    /**
     * 修改年级
     */
    public function changeGrade()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['id', 'grade'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;

                return json($return_data);
            }
        }
        //更新数据
        $result = Db('dorm')->where(['id' => $_POST['id']])->setField('grade', $_POST['grade']);

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
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;

                return json($return_data);
            }
        }
        //更新数据
         $result = Db('dorm')->where(['id' => $_POST['id']])->setField('department', $_POST['department']);
        
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
        $parameter = ['id', 'dormNumber'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;

                return json($return_data);
            }
        }
        //更新数据
        $result = Db('dorm')->where(['id' => $_POST['id']])->setField('dormNumber', $_POST['dormNumber']);
        
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '修改成功';
            $return_data['data']['id'] = $_POST['id'];
            $return_data['data']['dormNumber'] = $_POST['dormNumber'];
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
     * 手机验证
     */
    public function verifyPhone()
    {
        $parameter = array();
        $parameter = ['id', 'phone'];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                return json($return_data);
            }
        }

        //验证规则（手机号码）
        // $vphone = new Validate([
        //     ['phone' , 'require|max:11|/^1[3-8]{1}[0-9]{9}$/']
        // ]);

        // //验证
        // if(!$vphone->check($_POST['phone'])){
        //     $return_data = array();
        //     $return_data['error_code'] = 2;
        //     $return_data['msg'] = '无效的手机号码';
        //     return json($return_data);
        // }



    }

    /**
     * 发送邮箱验证码
     */
    
    
    public function sendMailCaptcha()
    {
        
        $email= $_POST['email']; 

        //本人邮箱配置
        $sendmail = '947368746@qq.com'; 
        $sendmailpswd = "ssrrviufblrybecg"; //授权码

        $send_name = 'CQCQ';    // 发件人名字
        $toemail = $email;      // 收件人邮箱
        $to_name = 'test';        // 收件人信息

        $mail = new PHPMailer();
        $mail->isSMTP();                    // 使用SMTP服务
        $mail->CharSet = "utf8";            // 编码格式
        $mail->Host = "smtp.qq.com";        // 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;             // 是否使用身份验证
        $mail->Username = $sendmail;        // 发送方的
        $mail->Password = $sendmailpswd;    // 授权码
        $mail->SMTPSecure = "ssl";          // 使用ssl协议方式
        $mail->Port = 465;                  // qq端口465或587）
        $mail->setFrom($sendmail, $send_name);      // 设置发件人信息
        $mail->addAddress($toemail, $to_name);      // 设置收件人信息
        $mail->addReplyTo($sendmail, $send_name);   // 设置回复人信息
        global $code;
        $code = rand(100000,999999);      // 验证码
        $mail->Subject = "验证邮件";    // 邮件标题

        session("qqcode",$code);
        $mail->Body = "邮件内容是您的验证码是：".$code."，如果非本人操作无需理会！";    // 邮件正文

        if (!$mail->send()) {           // 发送邮件
            echo "Mailer Error: " . $mail->ErrorInfo;   // 输出错误信息
        }else{
           return json(['code'=>'200','msg'=>'发送验证码成功']);
        }

    }

    /**
     * 邮箱验证
     */
    public function verifyMail()
    {
        $parameter = array();
        $parameter = ['id', 'email', 'captcha' ];
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                return json($return_data);
            }
        }

        if ($_POST['captcha'] != $code) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '验证码错误';
            return json($return_data);
        }else{
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '验证成功';
            return json($return_data);
        }
    }

    /**
     * 修改密码
     */
    public function changePassword()
    {
        $parameter = array();
        $parameter = ['id', 'password' , 'password_again'];
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
            'password_word' => $_POST['password_again']
        ];

        // 验证规则（密码）
        $vpassword = new Validate([
            ['password' , 'require|/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{8,16}$/'],
            ['password_word' , 'require|/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{8,16}$/']
        ]);

        //验证
        if(!$vpassword->check($data)){
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '8-16位长度，须包含数字、字母、符号至少2种或以上元素';
            return json($return_data);
        }

        //更新数据
        $result = Db('user')->where(['id' => $_POST['id']])->setField('password', md5($_POST['password']));
        
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