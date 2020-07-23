<?php

namespace app\index\controller;

use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

class Record extends BaseController
{
    public function records()
    {
        return $this->fetch();
    }
    //获取时间日期
    public function get_date()
    {
        // session_start();
        Db::connect();
        // $grade = Request::instance()->post('grade');
        // $department = Request::instance()->post('department');
        $grade = Session::get('grade');
        $department = Session::get('department');
        $record = Db::table('record')
            ->field('start_time, end_time')   // 指定字段
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where(['grade' => $grade])
            ->where(['department' => $department])
            ->where(['deleted' => 0])
            ->distinct(true)   // 返回唯一不同的值
            ->select();

        if (!empty($record)) {
            $return_data = array();
            rsort($record);  //排序
            $return_data['code'] = 0;
            $return_data['msg'] = '';
            $return_data['count'] = count($record);
            $return_data['data'] = $record;
            return json($return_data);
        } else {
            echo false;
        }
    }

    //搜索
    public function search_date()
    {
        session_start();
        $date = Request::instance()->post('date');
        // $grade = $_SESSION['grade'];
        // $department = $_SESSION['department'];
        $grade = Session::get('grade');
        $department = Session::get('department');
        $drecord = Db::table('record')
            ->field('start_time, end_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->distinct(true)   // 返回唯一不同的值
            ->where('start_time', 'between time', [$date . ' 00:00:00', $date . ' 23:59:59'])
            ->where(['grade' => $grade])
            ->where(['department' => $department])
            ->where(['deleted' => 0])
            ->select();
        if (!empty($drecord)) {
            $data = array();
            rsort($drecord);  //排序
            $data['code'] = 0;
            $data['msg'] = '';
            $data['data'] = $drecord;
            $data['count'] = count($drecord);
            return json($data);
        } else {
            return 0;
        }
    }

    //统计未签到
    public function statistics()
    {
        // session_start();
        // $parameter = ['grade', 'department', 'start_time', 'end_time'];
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

        date_default_timezone_set("PRC"); //时区标识符 解决时差8小时
        if (date("Y-m-d H:i:s") < $_POST['start_time']) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '该次抽查尚未开始！';
            return json($return_data);
        } else if (date("Y-m-d H:i:s") < $_POST['end_time']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '该查寝尚未结束！';
            return json($return_data);
        } else {
            $return_data = array();

            $where = array();
            $where['s.grade'] = $grade;
            $where['s.department'] = $department;
            $where['r.start_time'] = $_POST['start_time'];
            $where['r.end_time'] = $_POST['end_time'];
            $where['r.deleted'] = 0;

            $where['t.sign'] = 0;
            $list = Db('result')   // 查找未签到人员信息
                ->field('s.id, s.username, d.dorm_num')
                ->alias('t')
                ->join('record r', 't.record_id = r.id')
                ->join('dorm d', 'd.id = r.dorm_id')
                ->join('student s', 's.id = t.student_id')
                ->where($where)
                ->distinct(true)
                ->select();

            foreach ($list as $k => $v) {
                $list[$k]['block'] = explode('#', $v['dorm_num'])[0];
                $list[$k]['room'] = explode('#', $v['dorm_num'])[1];
                unset($list[$k]['dorm_num']); //销毁变量 
            }

            $where['t.sign'] = 1;
            $num = Db('result')   // 查找未签到人员信息
                ->field('s.id, s.username, d.dorm_num')
                ->alias('t')
                ->join('record r', 't.record_id = r.id')
                ->join('dorm d', 'd.id = r.dorm_id')
                ->join('student s', 's.id = t.student_id')
                ->where($where)
                ->distinct(true)
                ->select();

            $sign_num = count($num);   // 已签到人数
            $unsign_num = count($list);  // 未签到人数

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '统计结束！';
            $return_data['data']['sign_num'] = $sign_num;
            $return_data['data']['unsign_num'] = $unsign_num;
            $return_data['data']['unsign_list'] = $list;
            return json($return_data);
        }
    }
}
