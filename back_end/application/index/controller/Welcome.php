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
    public function test()
    {
        return $this->fetch();
    }

    public function welcome()
    {
        return $this->fetch();
    }

    //测试-获取查寝记录情况
    public function test_time()
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

        //当前时间、日期
        $time = date('Y-m-d H:i:s', time());
        $date = date('Y-m-d', time());

        //条件
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
            rsort($record);  //排序

            $data_none = array(); //记录未开始
            $data_start = array(); //记录开始未结束
            $data_end = array(); //记录结束
            $m = 0;
            $n = 0;
            $k = 0;

            for ($i = 0; $i < count($record); $i++) {
                if ($time < $record[$i]['start_time']) {
                    $data_none[$m] = $record[$i];
                    $m++;
                } else if ($time <= $record[$i]['end_time']) {
                    $data_start[$n] = $record[$i];
                    $n++;
                } else if ($time > $record[$i]['end_time']) {
                    $data_end[$k] = $record[$i];
                    $k++;
                }
            }

            if ($data_none == $record) {
                $return_data = array();
                $return_data['data'] = '今日记录未开始！';
                $return_data['count'] = count($data_end);
            } else if (!empty($data_start) & empty($data_end)) {
                $return_data = array();
                $return_data['data'] = '今日记录未结束！';
                $return_data['count'] = count($data_end);
            } else if (!empty($data_end)) {
                $return_data = array();
                $return_data['data'] = $data_end;  //部分已结束的记录
                $return_data['count'] = count($data_end);
            }
        } else {
            $return_data = array();
            $return_data['data'] = '今日无查寝记录！';
            $return_data['count'] = 0;
        }
        return json($return_data);
    }

    //测试-获取查寝签到情况
    public function test_dorm()
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

        //条件
        $where = array();
        $where['s.grade'] = $grade;
        $where['s.department'] = $department;
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['r.deleted'] = 0;

        
        $dorm = Db('result')  // 该条记录信息
            ->field('d.dorm_num, s.id, re.sign')
            ->alias('re')
            ->join('record r', 're.record_id = r.id')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = re.student_id')
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
