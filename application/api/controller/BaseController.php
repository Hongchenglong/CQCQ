<?php

namespace app\api\controller;

use think\Db;
use \think\Controller;
use phpmailer\PHPMailer;
use phpMailer\Exception;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

// 基础控制器

class BaseController extends Controller
{
    public function _initialize()
    {
    }

    // 微信openid所需参数
    public function wx_openid($code)
    {
        $ret = Db::table('cq_setting')->where('key', 'wxapp')->find();
        $values = json_decode($ret['values'], true);
        // 参数
        $params = array();
        $params['appid'] = $values['key'];
        $params['secret'] = $values['secret'];
        $params['js_code'] = $code;
        $params['grant_type'] = 'authorization_code';

        return $params;
    }

    /**
     * 短信验证码
     */
    public function sendMsg($phone)
    {        
        $ret = Db::table('cq_setting')->where('key', 'sms')->find();
        $values = json_decode($ret['values'], true);

        require_once EXTEND_PATH . 'api_sdk/vendor/autoload.php';
        Config::load();
        $product = "Dysmsapi";
        $domain = "dysmsapi.aliyuncs.com";
        $accessKeyId = $values['key'];
        $accessKeySecret = $values['secret'];
        $region = 'cn-hangzhou';
        $endPointName = 'cn-hangzhou';  //服务节点

        cookie('code', rand(100000, 999999), 3600);
        $code = cookie('code');         // 验证码

        //初始化profile
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        //增加服务节点
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
        //初始化acsClient用于发送请求
        $acsClient = new DefaultAcsClient($profile);

        $request = new SendSmsRequest();
        $request->setPhoneNumbers($phone);
        $request->setSignName($values['pswd']); // 签名
        $request->setTemplateCode($values['pmodel']); // 模板
        $request->setTemplateParam(json_encode(['code' => $code]));
        $acsResponse = $acsClient->getAcsResponse($request);

        $return_data = array();
        $return_data['acsResponse'] = $acsResponse;
        $return_data['code'] = $code;
        return $return_data;
    }

    /**
     * 短信通知
     */
    public function MsgNotice($phone, $code)
    {
        $ret = Db::table('cq_setting')->where('key', 'sms')->find();
        $values = json_decode($ret['values'], true);

        require_once EXTEND_PATH . 'api_sdk/vendor/autoload.php';
        Config::load();
        $product = "Dysmsapi";
        $domain = "dysmsapi.aliyuncs.com";
        $accessKeyId = $values['key']; 
        $accessKeySecret = $values['secret'];
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
        $request->setSignName($values['notice']); // 签名
        $request->setTemplateCode($values['nmodel']); // 模板
        $request->setTemplateParam(json_encode(['code' => $code]));
        $acsResponse = $acsClient->getAcsResponse($request);

        $return_data = array();
        $return_data['acsResponse'] = $acsResponse;
        return $return_data;
    }

    /**
     * 邮箱验证码
     */
    public function sendEmail($email)
    {
        $ret = Db::table('cq_setting')->where('key', 'mail')->find();
        $values = json_decode($ret['values'], true);
        //本人邮箱配置
        $sendmail = $values['key'];
        $sendmailpswd = $values['secret']; //授权码

        $send_name = 'CQCQ';    // 发件人名字
        $toemail = $email;      // 收件人邮箱
        $to_name = 'user';        // 收件人信息

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
        $mail->Subject = "CQCQ验证邮件";    // 邮件标题

        cookie("aliyunCode", $code);
        $mail->Body = "您好！您的验证码是：" . $code . "，如果非本人操作无需理会！";    // 邮件正文
        $isSuccess = $mail->send(); // 发送邮件

        $return_data = array();
        $return_data['isSuccess'] = $isSuccess;
        $return_data['code'] = $code;
        return $return_data;
    }

    /**
     * 邮件通知
     */
    public function EmailNotice($email, $to_name, $body)
    {
        $ret = Db::table('cq_setting')->where('key', 'mail')->find();
        $values = json_decode($ret['values'], true);
        //本人邮箱配置
        $sendmail = $values['key'];
        $sendmailpswd = $values['secret']; //授权码

        $send_name = 'CQCQ';    // 发件人名字
        $toemail = $email;      // 收件人邮箱
        // $to_name = $to_name;    // 收件人信息

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
        $mail->Subject = "CQCQ通知邮件";    // 邮件标题

        $mail->Body = $body;   // 邮件正文
        $isSuccess = $mail->send(); // 发送邮件

        $return_data = array();
        $return_data['isSuccess'] = $isSuccess;
        return $return_data;
    }

    public function request_post($url = '', $param = '')
    {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;
        // 初始化curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // post提交方式
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        // 运行curl
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }
}
