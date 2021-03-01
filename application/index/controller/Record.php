<?php

namespace app\index\controller;

use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

class Record extends BaseController
{
    public function record()
    {
        return $this->fetch();
    }
    
    //获取最近7次查寝时间
    public function get_date()
    {
        // session_start();
//        Db::connect();
        // $grade = Request::instance()->post('grade');
        // $department = Request::instance()->post('department');
        $grade = Session::get('grade');
        $department = Session::get('department');

        $record = Db::table('cq_record')
            ->field('start_time, end_time')   // 指定字段
            ->alias('r')    // 别名
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->where(['grade' => $grade])
            ->where(['department' => $department])
            ->where(['deleted' => 0])
            ->distinct(true)   // 返回唯一不同的值
            ->limit(7)
            ->order('start_time desc')
            ->select();

        $time = date('Y-m-d H:i:s', time()); //当前时间

        if (!empty($record)) {
            $return_data = array();
            $j = 0;
            rsort($record);  //排序

            for ($i = 0; $i < count($record); $i++) {
                if ($time < $record[$i]['start_time']) {
                    $return_data[$j]['msg'] = '未开始';
                    $return_data[$j]['data'] = $record[$i];
                    $j++;
                } else if ($time >= $record[$i]['start_time'] & $time <= $record[$i]['end_time']) {
                    $return_data[$j]['msg'] = '进行中';
                    $return_data[$j]['data'] = $record[$i];
                    $j++;
                } else if ($time > $record[$i]['end_time']) {
                    $return_data[$j]['msg'] = '已结束';
                    $return_data[$j]['data'] = $record[$i];
                    $j++;
                }
            }
            $return_data['count'] = count($record);
            return json($return_data);
        } else {
            return false;
        }
    }

    //搜索
    public function search_date()
    {
//        session_start();
        $date = Request::instance()->post('date');
        $grade = Session::get('grade');
        $department = Session::get('department');
        $drecord = Db::table('cq_record')
            ->field('start_time, end_time')
            ->alias('r')    // 别名
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->distinct(true)   // 返回唯一不同的值
            ->where('start_time', 'between time', [$date . ' 00:00:00', $date . ' 23:59:59'])
            ->where(['grade' => $grade])
            ->where(['department' => $department])
            ->where(['deleted' => 0])
            ->select();

        //当前时间
        $time = date('Y-m-d H:i:s', time());
        if (!empty($drecord)) {
            $data = array();
            rsort($drecord);  //排序
            $j = 0;
            for ($i = 0; $i < count($drecord); $i++) {
                if ($time < $drecord[$i]['start_time']) {
                    $data[$j]['msg'] = '未开始';
                    $data[$j]['data'] = $drecord[$i];
                    $j++;
                } else if ($time >= $drecord[$i]['start_time'] & $time <= $drecord[$i]['end_time']) {
                    $data[$j]['msg'] = '进行中';
                    $data[$j]['data'] = $drecord[$i];
                    $j++;
                } else if ($time > $drecord[$i]['end_time']) {
                    $data[$j]['msg'] = '已结束';
                    $data[$j]['data'] = $drecord[$i];
                    $j++;
                }
            }
            $data['count'] = count($drecord);
            return json($data);
        } else {
            return 0;
        }
    }

    //获取某一条记录里的签到情况
    public function dorm()
    {
//        session_start();
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

        //条件
        $where = array();
        $where['s.grade'] = $grade;
        $where['s.department'] = $department;
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['r.deleted'] = 0;

        $dorm = Db::table('cq_result')  // 该条记录信息
            ->field('d.dorm_num, s.id, re.sign')
            ->alias('re')
            ->join('cq_record r', 're.record_id = r.id')
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.id = re.student_id')
            ->where($where)
            ->distinct(true)
            ->select();

        // return json($dorm);
        if (!empty($dorm)) {
            $return_data = array();
            rsort($dorm);  //排序
            $return_data['count'] = count($dorm);
            $return_data['data'] = $dorm;
            return json($return_data);
        } else {
            echo false;
        }
    }
}
