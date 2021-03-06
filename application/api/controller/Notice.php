<?php

namespace app\api\controller;
use think\Db;
class Notice extends BaseController
{
    public function notice()
    {
        $notice = Db::table('cq_notice')->where("send_time", null)->where("end_time","<= time", date('Y-m-d H:i:s', time()))->select();
        // dump($notice);
        $count = sizeof($notice);
        for ($i = 0; $i < $count; $i++) {
            $instructor = Db::table('cq_instructor')->where("id", $notice[$i]["instructor_id"])->find();
            if (empty($instructor["email"])) continue;

            $where = array();
            $where['s.grade'] = $instructor['grade'];
            $where['s.department'] = $instructor['department'];
            $where['r.start_time'] = $notice[$i]['start_time'];
            $where['r.end_time'] = $notice[$i]['end_time'];
            $where['r.deleted'] = 0;
            $where['t.sign'] = 0;

            $list = Db::table('cq_result')   // 查找未签到人员信息
                ->field('s.id, s.username, s.dorm, s.phone')
                ->alias('t')
                ->join('cq_student s', 's.id = t.student_id')
                ->join('cq_record r', 't.record_id = r.id')
                ->where($where)
                ->distinct(true)
                ->select();

            $body = "本次查寝结束，未签名单如下：\n宿舍         学号            姓名         手机\n" ;
            $cnt = sizeof($list);
            for ($j = 0; $j < $cnt; $j++) {
                $body .= $list[$j]["dorm"] . " " . $list[$j]['id'] . " " . $list[$j]['username'] . " " . $list[$j]["phone"] . "\n";
            }

            $res = $this->EmailNotice($instructor["email"], $instructor["username"], $body);
            if ($res['isSuccess']) {
                Db::table('cq_notice')->where(['start_time'=> $notice[$i]['start_time'], 'end_time' => $notice[$i]['end_time']])->update(['send_time'=> date('Y-m-d H:i:s', time())]);
                echo "<script>alert(\"发送成功\")</script>";
            } else {
                echo "<script>alert(\"发送失败\");/script>";
            }
        }
    }
}

// crontab -e
// */5 * * * * curl "https://oeong.com/cqcq/public/index.php/api/notice/notice"
// service crond restart
// grep "notice" /var/log/cron

