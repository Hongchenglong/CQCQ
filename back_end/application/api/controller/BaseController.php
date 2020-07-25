<?php

namespace app\api\controller;

use \think\Controller;
use phpmailer\PHPMailer;
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

    public function get_token() //获取access_token
    {
        $url = 'https://aip.baidubce.com/oauth/2.0/token';
        $post_data['grant_type']       = 'client_credentials';
        $post_data['client_id']      = 'GCjHu7F1LGrE2Dq1wm19rKGo';
        $post_data['client_secret'] = 'TBLg5ROb7wvpLAk4gIOzM5VhWE2Hv48S';
        $o = "";
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";
        }
        $post_data = substr($o, 0, -1);

        $res = $this->request_post($url, $post_data);
        $res = json_decode($res, true);
        return $res['access_token'];
    }

    public function sendMsg($phone) // 发送短信
    {
        cookie('code', rand(100000, 999999), 3600);
        $code = cookie('code');         // 验证码

        require_once EXTEND_PATH . 'api_sdk/vendor/autoload.php';
        Config::load();
        $product = "Dysmsapi";
        $domain = "dysmsapi.aliyuncs.com";
        $accessKeyId = "LTAI4G1mPBWPvu5BrwERMbtq";
        $accessKeySecret = "kAUXGZeqpLltbdEUlCwXr2zDqtEpci";
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
        $request->setTemplateCode("SMS_189611359");
        $request->setTemplateParam(json_encode(['code' => $code]));
        $acsResponse = $acsClient->getAcsResponse($request);

        $return_data = array();
        $return_data['acsResponse'] = $acsResponse;
        $return_data['code'] = $code;
        return $return_data;
    }

    public function sendEmail($email) // 发送邮件
    {
        //本人邮箱配置
        $sendmail = 'oeong@oeong.xyz';
        $sendmailpswd = "LongDIO1412"; //授权码

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
}
