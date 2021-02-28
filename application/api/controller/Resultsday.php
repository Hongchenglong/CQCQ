<?php

namespace app\api\controller;
use think\Db;
class Resultsday
{   
    // 获取所有查寝记录的日期
    // 可改进：写入数据库，不必每次查询
    public function getDay()
    {
        // $parameter = ['department', 'grade'];
        // 输入判断
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        }

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.deleted'] = 0;

        $day = Db::table('cq_record')
            ->alias('r')    // 别名
            ->field('r.start_time')
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $day = array_column($day, 'start_time');
        foreach ($day as $k => $v) {
            $day[$k] = explode(' ', $day[$k])[0]; // 留日期 去时间
        }

        $day = array_values(array_unique($day)); // 去重

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '输出记录日期';
        $return_data['data']['day'] = $day;
        return json($return_data);
    }

    // 获取指定日期当天所有记录的开始时间与结束时间
    public function getDayRecord()
    {
        // $parameter = ['department', 'grade', 'time'];
        // 输入判断
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['time'])) {
            return json(['error_code' => 1, 'msg' => '请输入时间（年月日）！']);
        }

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.deleted'] = 0;

        $day = Db::table('cq_record')
            ->alias('r')    // 别名
            ->field('r.start_time, r.end_time')
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $day_ = array();
        foreach ($day as $k => $v) {
            if (substr($v['start_time'], 0, 10) == $_POST['time']) {
                $day_[$k] = $v;
            }
        }

        $day_ = array_values($day_); // 重新排序

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '输出指定天数记录！';
        $return_data['data']['day'] = $day_;
        return json($return_data);
    }

    // 获取指定月份的签到情况
    public function stuSignSituation()
    {
        // $parameter = ['id', 'time'];
        // 输入判断
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入学号！']);
        } else if (empty($_POST['time'])) {
            return json(['error_code' => 1, 'msg' => '请输入时间（年月）！']);
        }

        $where = array();
        $where['t.student_id'] = $_POST['id'];
        $where['t.sign'] = 0;
        $where['r.deleted'] = 0;

        // 查找该学号所有的签到记录
        $unsign_record = Db::table('cq_record')
            ->alias('r')
            ->field('r.start_time, r.end_time')
            ->join('cq_result t', 't.record_id = r.id')
            ->where($where)
            ->select();


        $unsign_day = array();
        foreach ($unsign_record as $k => $v) {
            if (substr($v['start_time'], 0, 7) == $_POST['time']) {
                $unsign_day[$k] = $v;
            }
        }

        $unsign_day = array_values($unsign_day); // 重新排序
        foreach ($unsign_day as $k => $v) {  // 提取数据
            $unsign_day[$k]['day'] = explode(' ', $v['start_time'])[0];
            $unsign_day[$k]['start'] = explode(' ', $v['start_time'])[1];
            $unsign_day[$k]['end'] = explode(' ', $v['end_time'])[1];
            unset($unsign_day[$k]['start_time']);
            unset($unsign_day[$k]['end_time']);
        }

        $where['t.sign'] = 1;
        $sign_record = Db::table('cq_record')
            ->alias('r')
            ->field('r.start_time, r.end_time')
            ->join('cq_result t', 't.record_id = r.id')
            ->where($where)
            ->select();


        $sign_day = array();
        foreach ($sign_record as $k => $v) {
            if (substr($v['start_time'], 0, 7) == $_POST['time']) {
                $sign_day[$k] = $v;
            }
        }

        $sign_day = array_values($sign_day); // 重新排序
        foreach ($sign_day as $k => $v) {
            $sign_day[$k]['day'] = explode(' ', $v['start_time'])[0];
            $sign_day[$k]['start'] = explode(' ', $v['start_time'])[1];
            $sign_day[$k]['end'] = explode(' ', $v['end_time'])[1];
            unset($sign_day[$k]['start_time']);
            unset($sign_day[$k]['end_time']);
        }

        $sign_num = count($sign_day);
        $unsign_num = count($unsign_day);
        $record_num = $sign_num + $unsign_num;

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '输出指定月份签到情况！';
        $return_data['data']['unsign_day'] = $unsign_day;
        $return_data['data']['unsign_num'] = $unsign_num;
        $return_data['data']['sign_day'] = $sign_day;
        $return_data['data']['sign_num'] = $sign_num;
        $return_data['data']['record_num'] = $record_num;
        return json($return_data);
    }
}
