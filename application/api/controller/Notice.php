<?php

namespace app\api\controller;

class Notice extends BaseController
{

    public function notice()
    {
        $notice = db("notice")->where("send_time", null)->where("end_time","> time", date('Y-m-d H:i:s', time()))->select();
        $count = sizeof($notice);
        for ($i = 0; $i < $count; $i++) {
            $counselor = db("counselor")->where("id", $notice[$i]["counselor_id"])->find();
            if (empty($counselor["email"])) continue;

            $where = array();
            $where['s.grade'] = $counselor['grade'];
            $where['s.department'] = $counselor['department'];
            $where['r.start_time'] = $notice[$i]['start_time'];
            $where['r.end_time'] = $notice[$i]['end_time'];
            $where['r.deleted'] = 0;
            $where['t.sign'] = 0;

            $list = Db('result')   // 查找未签到人员信息
                ->field('s.id, s.username, s.dorm, s.phone')
                ->alias('t')
                ->join('student s', 's.id = t.student_id')
                ->join('record r', 't.record_id = r.id')
                ->where($where)
                ->distinct(true)
                ->select();

            $body = "本次查寝结束，未签名单如下：\n宿舍         学号            姓名         手机\n" ;
            $cnt = sizeof($list);
            for ($j = 0; $j < $cnt; $j++) {
                $body .= $list[$j]["dorm"] . " " . $list[$j]['id'] . " " . $list[$j]['username'] . " " . $list[$j]["phone"] . "\n";
            }

            $res = $this->EmailNotice($counselor["email"], $counselor["username"], $body);
            if ($res['isSuccess']) {
                db('notice')->where('counselor_id', $notice[$i]["counselor_id"])->update(['send_time'=> date('Y-m-d H:i:s', time())]);
            } 
        }
    }
}


// crontab -e
// */5 * * * * curl "oeong.com/cqcq/public/index.php/api/notice/notice"
// service crond restart
// grep "notice" /var/log/cron

