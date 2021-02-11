<?php

namespace app\index\controller;

use pSplit;
use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

class Welcome extends BaseController
{

    public function welcome()
    {
        return $this->fetch();
    }

    /**
     * 未签人员名单
     */
    public function get_more()
    {
        session_start();
        $grade = Session::get('grade');
        $department = Session::get('department');
        //输入判断
        if (empty($grade)) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入年级！';
            return json($return_data);
        } else if (empty($department)) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入系！';
            return json($return_data);
        }
        $time = date('Y-m-d H:i:s', time());

        $where = array();
        $where['s.grade'] = $grade;
        $where['s.department'] = $department;
        $where['re.sign'] = 0;
        $where['r.deleted'] = 0;

        $more = Db('result')
            ->field('re.student_id,count(*) as num')
            ->alias('re')
            ->join('record r', 're.record_id = r.id')
            ->join('student s', 's.id = re.student_id')
            ->group('re.student_id')
            ->where($where)
            ->where('r.end_time', '<', $time)
            ->order('num desc')
            ->distinct(true)
            ->select();

        if (!empty($more)) {
            $return_data = array();
            $j = 0;
            $cnt = count($more);
            for ($i = 0; $i < $cnt; $i++) {
                if ($more[$i]['num'] >= 3) {
                    $return_data[$j]['student_id'] = $more[$i]['student_id'];
                    $return_data[$j]['num'] = $more[$i]['num'];
                    $st_name = Db('student')
                        ->field('username')
                        ->where('id', '=', $more[$i]['student_id'])
                        ->distinct(true)
                        ->select();
                    $return_data[$j]['username'] = $st_name[0]['username'];
                    $j++;
                }
            }
            $return_data['count'] = $j;
            if (empty($return_data)) {
                $return_data['data'] = '无';
                $return_data['count'] = 0;
            }
        } else {
            $return_data = array();
            $return_data['data'] = '无';
            $return_data['count'] = 0;
        }
        return json($return_data);
    }

    /**
     * 获取查寝时间情况
     */
    public function get_time()
    {
        session_start();
        $grade = Session::get('grade');
        $department = Session::get('department');

        //输入判断
        if (empty($grade)) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入年级！';
            return json($return_data);
        } else if (empty($department)) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入系！';
            return json($return_data);
        }

        $date = date('Y-m-d', time());

        $where = ['grade' => $grade, 'department' => $department, 'r.deleted' => 0];

        Db::connect();
        $record = Db::table('record')
            ->field('start_time, end_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where('start_time', 'between time', [$date . ' 00:00:00', $date . ' 23:59:59'])
            ->where($where)
            ->distinct(true)   // 返回唯一不同的值
            ->select();

        if (!empty($record)) {
            $return_data = array();
            rsort($record);  //排序
            $j = 0;
            for ($i = 0; $i < count($record); $i++) {
                $dorm = Db('result')  // 该条记录信息
                    ->field('d.dorm_num, s.id')
                    ->alias('re')
                    ->join('record r', 're.record_id = r.id')
                    ->join('dorm d', 'd.id = r.dorm_id')
                    ->join('student s', 's.id = re.student_id')
                    ->where('re.sign', '=', 0)
                    ->where('start_time', '=', $record[$i]['start_time'])
                    ->where('end_time', '=', $record[$i]['end_time'])
                    ->distinct(true)
                    ->select();
                if (!empty($dorm)) {
                    $return_data['data'][$j] = $record[$i];
                    $j++;
                }
            }
            $return_data['count'] = $j;
            if ($return_data['count'] == 0) {
                $return_data['date'] = $date;
                $return_data['data'] = '今日无未签名单！';
            }
        } else {
            $return_data = array();
            $return_data['date'] = $date;
            $return_data['data'] = '无查寝记录！';
            $return_data['count'] = 0;
        }
        return json($return_data);
    }

    /**
     * 获取查寝签到情况
     */
    public function get_records()
    {
        session_start();
        $grade = Session::get('grade');
        $department = Session::get('department');

        // 输入判断
        if (empty($grade)) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入年级！';
            return json($return_data);
        } else if (empty($department)) {
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

        $where = array();
        $where['s.grade'] = $grade;
        $where['s.department'] = $department;
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['re.sign'] = 0;
        $where['r.deleted'] = 0;

        $dorm = Db('result')  // 该条记录信息
            ->field('d.dorm_num, s.id')
            ->alias('re')
            ->join('record r', 're.record_id = r.id')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = re.student_id')
            ->where($where)
            ->distinct(true)
            ->select();

        if (!empty($dorm)) {
            $return_data = array();
            rsort($dorm);  //排序
            $return_data['count'] = count($dorm);
            $return_data['data'] = $dorm;
        } else {
            $return_data = array();
            rsort($dorm);  //排序
            $return_data['count'] = count($dorm);
            // $return_data['data'] = '已全部签到';
        }
        return json($return_data);
    }

    /**
     * 获取今天星期几
     */
    public function getWeek()
    {
        $time = '';
        $week_array = array('日', '一', '二', '三', '四', '五', '六'); //先定义一个数组
        if ($time) {
            return '周' . $week_array[date('w', $time)];
        } else {
            return '周' . $week_array[date('w')];
        }
    }

    /**
     * 获取本周所有日期
     */
    function get_week($time = '', $format = 'Y-m-d')
    {
        $time = $time != '' ? $time : time();
        //获取当前周几
        $week = date('w', $time);
        $weekname = array('周一', '周二', '周三', '周四', '周五', '周六', '周日');
        //星期日排到末位
        if (empty($week)) {
            $week = 7;
        }
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date_time = date($format, strtotime('+' . $i + 1 - $week . ' days', $time));
            $date[$i]['date'] = $date_time;
            $date[$i]['week'] = $weekname[$i];
        }
        return $date;
    }

    public function get_line()
    {
        date_default_timezone_set("PRC"); //时区标识符 解决时差8小时
        Db::connect();
        $grade = Session::get('grade');
        $department = Session::get('department');
        $date = date("Y-m-d"); //获取今天日期
        $week = $this->getWeek(); //获取今天星期几
        $week_date = $this->get_Week(); //获取一周所有的日期
        // print_r($week_date);

        $dorm = Db('dorm')  // 查找一共有多少宿舍
            ->field('dorm_num')
            ->alias('d')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where(['dorm_grade' => $grade, 'dorm_dep' => $department])
            ->distinct(true)
            ->select();
        $total_dorm = count($dorm);

        $stu = Db::table('student') // 获取一共有多少学生
            ->field('id')
            ->where(['grade' => $grade, 'department' => $department])
            ->distinct(true)
            ->select();
        $total_stu = count($stu);

        $where = array();
        $where['s.grade'] = $grade;
        $where['s.department'] = $department;
        $where['r.start_time'] = array('between', array($week_date[0]['date'], $week_date[6]['date']));
        $where['r.deleted'] = 0;

        $re_week = Db::table('record') // 获取一周所有记录的时间
            ->field('start_time, end_time,d.dorm_num,student_id')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('result t', 't.record_id = r.id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)   // 返回唯一不同的值
            ->select();
        $re_week = $this->common($re_week); //将同日期的宿舍合并 'dorm_count':每周每天抽了多少宿舍  'stu_count':每周每天抽了多少学生

        $where = array();
        $where['s.grade'] = $grade;
        $where['s.department'] = $department;
        $where['r.start_time'] = array('between', array($week_date[0]['date'], $week_date[6]['date']));
        $where['r.deleted'] = 0;
        $where['t.sign'] = 0;

        $unsign_week = Db('result')   // 每周每天 多少人/多少宿舍 未签到
            ->field('r.start_time, d.dorm_num, t.student_id')
            ->alias('t')
            ->join('student s', 's.id = t.student_id')
            ->join('record r', 't.record_id = r.id')
            ->join('dorm d', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();
        $unsign_week = $this->common($unsign_week);

        $unsigndorm = array_column($unsign_week, 'dorm_num'); // 提取宿舍号
        $unsigndorm = array_reduce($unsigndorm, 'array_merge', array()); // 转一维数组
        $unsignStu = array_column($unsign_week, 'student_id'); // 提取学号
        $unsignStu = array_reduce($unsignStu, 'array_merge', array()); // 转一维数组

        $weekdorm = array_column($re_week, 'dorm_num'); // 提取宿舍号
        $weekdorm = array_reduce($weekdorm, 'array_merge', array()); // 转一维数组
        $weekStu = array_column($re_week, 'student_id'); // 提取学号
        $weekStu = array_reduce($weekStu, 'array_merge', array()); // 转一维数组

        $unsigndorm7 = count($unsigndorm);  //一周有多少宿舍未签到
        $unsignStu7 = count($unsignStu);  //一周有多少人未签到
        $signdorm7 = count($weekdorm) - count($unsigndorm);  //一周有多少宿舍已签到
        $signStu7 = count($weekStu) - count($unsignStu);  //一周有多少人已签到

        $sign_week = array();
        $j = 0;
        for ($i = 0; $i < count($re_week); $i++) {
            if ($j < count($unsign_week)) {
                if ($re_week[$i]['start_time'] == $unsign_week[$j]['start_time']) {
                    $sign_week[$i]['start_time'] = $unsign_week[$j]['start_time'];
                    $sign_week[$i]['dorm_count'] = $re_week[$i]['dorm_count'] - $unsign_week[$j]['dorm_count'];
                    $sign_week[$i]['stu_count'] = $re_week[$i]['stu_count'] - $unsign_week[$j]['stu_count'];
                    $j++;
                } else {
                    $sign_week[$i]['start_time'] = $re_week[$i]['start_time'];
                    $sign_week[$i]['dorm_count'] = $re_week[$i]['dorm_count'];
                    $sign_week[$i]['stu_count'] = $re_week[$i]['stu_count'];
                }
            } else {
                $sign_week[$i]['start_time'] = $re_week[$i]['start_time'];
                $sign_week[$i]['dorm_count'] = $re_week[$i]['dorm_count'];
                $sign_week[$i]['stu_count'] = $re_week[$i]['stu_count'];
            }
        }
        // dump($sign_week);
        // dump($unsign_week);

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '统计结束！';
        #日期数据
        $return_data['data']['today'] = $date; //今天的日期
        $return_data['data']['week'] = $week; //获取今天星期几
        $return_data['data']['weekday'] = $week_date; //这一周的所有日期
        #每周数据
        $return_data['data']['weeks_dorm'] = count($weekdorm); //这一周抽了多少宿舍
        $return_data['data']['weeks_stu'] = count($weekStu); //这一周抽了多少学生
        $return_data['data']['weeks_unsgdorm'] = $unsigndorm7; //这一周有多少宿舍未签到
        $return_data['data']['weeks_sgdorm'] = $signdorm7; //这一周有多少宿舍已签到
        $return_data['data']['weeks_unsgstu'] = $unsignStu7; //这一周有多少学生未签到
        $return_data['data']['weeks_sgstu'] = $signStu7; //这一周有多少学生已签到
        #每天数据
        $return_data['data']['total_dorm'] = $total_dorm;
        $return_data['data']['total_stu'] = $total_stu;

        $return_data['data']['today_stu'] = 0;
        $return_data['data']['today_chou'] = '0%'; //今日抽查率
        $return_data['data']['seven_chou'] = '0%'; //本周抽查率
        $chous = 0;
        for ($n = 0; $n < count($re_week); $n++) {
            unset($re_week[$n]['dorm_num']); // 删除宿舍显示
            unset($re_week[$n]['student_id']); // 删除学号显示
            $return_data['data']['days'][$n] = $re_week[$n]; //七天每天抽了多少宿舍、多少学生

            $today = date('Y-m-d', time());
            if ($today == $re_week[$n]['start_time']) {
                $return_data['data']['today_stu'] = $re_week[$n]['stu_count'];  //今日查寝数
                $return_data['data']['today_chou'] = round($return_data['data']['today_stu'] / $total_stu * 100, 1) . "%";  //今日抽查率  
            }
            $chous += $re_week[$n]['stu_count'] / $total_stu;
        }
        if (count($re_week) != 0) {
            $return_data['data']['seven_chou'] = round($chous / count($return_data['data']['days']) * 100, 1) . "%"; //本周抽查率
        }

        for ($n = 0; $n < count($unsign_week); $n++) {
            unset($unsign_week[$n]['dorm_num']); // 删除宿舍显示
            unset($unsign_week[$n]['student_id']); // 删除学号显示
            $return_data['data']['days_unsign'][$n] = $unsign_week[$n]; //七天每天多少宿舍、多少学生未签到
        }
        $return_data['data']['days_sign'] = $sign_week; //七天每天多少宿舍、多少学生已签到

        $return_data['data']['today_num'] = '0%'; //今日签到率
        $return_data['data']['seven_num'] = '0%'; //本周签到率
        $every = 0;
        for ($n = 0; $n < count($sign_week); $n++) {
            $today = date('Y-m-d', time());
            if ($today == $sign_week[$n]['start_time']) {
                $return_data['data']['today_num'] = round($sign_week[$n]['stu_count'] / $return_data['data']['today_stu'] * 100, 1) . "%"; //今日签到率
            }
            $every += $sign_week[$n]['stu_count'] / $return_data['data']['days'][$n]['stu_count'];
        }
        if (count($re_week) != 0) {
            $return_data['data']['seven_num'] = round($every / count($return_data['data']['days']) * 100, 1) . "%"; //本周签到率
        }

        return json($return_data);
    }

    public function common($array)
    {
        foreach ($array as $k => $v) {
            $array[$k]['start_time'] = substr($v['start_time'], 0, 10); // 提取年月日
        }

        $array_ = array();
        foreach ($array as $k => $v) { // 相同日期合并
            if (!isset($array_[$v['start_time']])) {
                $array_[$v['start_time']] = $v;
            } else {
                $array_[$v['start_time']]["dorm_num"] .= ',' . $v["dorm_num"];
                if (isset($v['student_id'])) {
                    $array_[$v['start_time']]["student_id"] .= ',' . $v["student_id"];
                }
            }
        }

        foreach ($array_ as $k => $v) { // 对一天抽中的宿舍进行计数
            $array_[$k]['dorm_num'] = explode(',', $v['dorm_num']);
            $array_[$k]['dorm_num'] = array_unique($array_[$k]['dorm_num']); // 宿舍去重
            $array_[$k]['dorm_count'] = count($array_[$k]['dorm_num']); // 计数

            if (isset($v['student_id'])) {
                $array_[$k]['student_id'] = explode(',', $v['student_id']);
                $array_[$k]['student_id'] = array_unique($array_[$k]['student_id']); // 学号去重
                $array_[$k]['stu_count'] = count($array_[$k]['student_id']); // 计数
                // unset($array_[$k]['student_id']); // 删除学号显示
            }
            // unset($array_[$k]['dorm_num']); // 删除宿舍显示
        }

        asort($array_); // 根据日期升序排序
        $array_ = array_values($array_);
        return $array_;
    }
}
