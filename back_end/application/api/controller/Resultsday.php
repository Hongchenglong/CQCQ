<?php

namespace app\api\controller;

class Resultsday
{
    // 获取所有记录的日期
    public function getDay()
    {
        // $parameter = ['department', 'grade'];
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
        }

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.deleted'] = 0;

        $day = Db('record')
            ->alias('r')    // 别名
            ->field('r.start_time')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $day = array_column($day, 'start_time');
        foreach ($day as $k => $v) {
            $day[$k] = explode(' ', $day[$k])[0];
        }

        $day = array_values(array_unique($day));

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '输出记录日期';
        $return_data['data']['day'] = $day;
        return json($return_data);
    }

    // 获取指定天数的所有记录的开始时间与结束时间
    public function getDayRecord()
    {
        // $parameter = ['department', 'grade', 'time'];
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
        } else if (empty($_POST['time'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入时间（年月日）！';
            return json($return_data);
        }

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.deleted'] = 0;

        $day = Db('record')
            ->alias('r')    // 别名
            ->field('r.start_time, r.end_time')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
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
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入学号！';
            return json($return_data);
        } else if (empty($_POST['time'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入时间（年月）！';
            return json($return_data);
        }

        $where = array();
        $where['t.student_id'] = $_POST['id'];
        $where['r.deleted'] = 0;

        // 查找该学号所有的签到记录
        $record = Db('record')
            ->alias('r')
            ->field('r.start_time, r.end_time, t.sign')
            ->join('result t', 't.record_id = r.id')
            ->where($where)
            ->select();

        $day = array();
        foreach ($record as $k => $v) {
            if (substr($v['start_time'], 0, 7) == $_POST['time']) {
                $day[$k] = $v;
            }
        }

        $day = array_values($day); // 重新排序

        $record_num = count($day);
        $sign_num = array_sum(array_column($day, 'sign'));
        $percent = $sign_num/$record_num;
        
        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '输出指定月份签到情况！';
        $return_data['data']['day'] = $day;
        $return_data['data']['percent'] = $percent;
        return json($return_data);
    }
}
