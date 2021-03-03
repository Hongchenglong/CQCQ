<?php

namespace app\api\controller;

use think\Db;
use think\Validate;
use phpmailer\PHPMailer;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

class Remind extends BaseController
{
    /**
     * 提醒
     */
    public function remind()
    {
        // $parameter = ['grade', 'department', 'start_time'];
        // 输入判断
        if (empty($_POST['grade'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入年级！';
            return json($return_data);
        } else if (empty($_POST['department'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入系！';
            return json($return_data);
        } else if (empty($_POST['start_time'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入开始时间！';
            return json($return_data);
        } else if (empty($_POST['end_time'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入结束时间！';
            return json($return_data);
        }

        // 查询条件
        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];

        $record = Db::table('cq_record')
            ->field('start_time, end_time, photo, d.dorm_num, rand_num, upload_time') // 指定字段
            ->alias('r') // 别名
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.id = d.student_id')
            ->where($where)
            ->where('r.deleted', 0)
            ->select();

        // 思路：变量有：$start_time、$end_time、$dorm['dorm_num']['rand_num']['email']，选出上传时间为空的宿舍，记录宿舍号和随机数，查找邮箱，发送邮箱
        // 记录时间
        $start_time = $record[0]['start_time'];
        $end_time = $record[0]['end_time'];

        // 查找未上传照片且有邮箱的宿舍，记录宿舍号、随机数、邮箱
        $dorm = [];
        $cnt = 0;
        $records = count($record);
        for ($i = 0; $i < $records; $i++) {
            $stuEmail = Db::table('cq_dorm')
                ->field('email')
                ->alias('d')
                ->join('cq_student s', 's.id = d.student_id')
                ->where(['d.dorm_num' => $record[$i]['dorm_num']])
                ->find();
            if ($record[$i]['upload_time'] == null && $stuEmail['email'] != null) {
                $dorm[$cnt]['rand_num'] = $record[$i]['rand_num'];
                $dorm[$cnt]['dorm_num'] = $record[$i]['dorm_num'];
                $dorm[$cnt]['email'] = $stuEmail['email'];
                $cnt += 1;
            }
        }
        dump($dorm);
        $dorms = count($dorm);
        // dorm为0，即查找不到未上传照片的宿舍
        if ($dorms == 0) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '此次查寝所有绑定邮箱的宿舍均已上传！';
            return json($return_data);
        }

        // 发送邮件配置
        for ($i = 0; $i < $dorms; $i++) {
            $email = $dorm[$i]['email'];

            $ret = Db::table('cq_setting')->where('key', 'mail')->find();
            $values = json_decode($ret['values'], true);

            $sendmail = $values['key']; //邮箱配置
            $sendmailpswd = $values['secret']; //授权码

            $send_name = 'CQCQ'; // 发件人名字
            $toemail = $email; // 收件人邮箱
            $to_name = 'test'; // 收件人信息

            $mail = new PHPMailer();
            $mail->isSMTP(); // 使用SMTP服务
            $mail->CharSet = "utf8"; // 编码格式
            $mail->Host = "smtpdm.aliyun.com"; // 发送方的SMTP服务器地址
            $mail->SMTPAuth = true; // 是否使用身份验证
            $mail->Username = $sendmail; // 发送方的
            $mail->Password = $sendmailpswd; // 授权码
            $mail->SMTPSecure = "ssl"; // 使用ssl协议方式
            $mail->Port = 465;
            $mail->setFrom($sendmail, $send_name); // 设置发件人信息
            $mail->addAddress($toemail, $to_name); // 设置收件人信息
            $mail->addReplyTo($sendmail, $send_name); // 设置回复人信息

            $mail->Subject = "CQCQ查寝签到提醒邮件"; // 邮件标题
            $mail->Body = "尊敬的用户：\n    您好！邮件内容是您的查寝签到提醒，您的宿舍 " . $dorm[$i]['dorm_num'] .
                " 已被辅导员随机抽取到，随机数为 " . $dorm[$i]['rand_num'] . " ，本次查寝于" . $start_time . "开始，截止至" . $end_time . "，请及时前往查寝签到！"; // 邮件正文

            $result = $mail->send();
        }

        if (!$result) { // 发送邮件
            $return_data = array();
            $return_data['error_code'] = 3;
            $return_data['msg'] = '发送提醒邮件错误！';
            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '发送提醒邮件成功！';
            return json($return_data);
        }
    }
}
