<?php

namespace app\api\controller;

use DateTime;
use think\Db;
use think\Validate;

class Getinfo extends BaseController
{

    /**
     * 获取个人信息页面
     */
    public function getHomeInfo()
    {
        if (empty($_POST['id'])) {
            return json(['error_code' => 1, 'msg' => '请输入用户id！']);
        }

        $get = Db('counselor')
            ->field('id, username, email, phone, grade, department')
            ->where(['id' => $_POST['id']])
            ->find();

        if (empty($get)) { //学生
            $getStuInfo = Db('student')
                ->field('id, sex, username, email, phone, grade, department, dorm')
                ->where(['id' => $_POST['id']])
                ->find();

            $getRoom = Db('dorm')
                ->field('id, block, room, dorm_num')
                ->where(['dorm_num' => $getStuInfo['dorm']])
                ->select();

            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '获取数据成功！';
            $return_data['data']['stuInfo'] = $getStuInfo;
            $return_data['data']['roomInfo'] = $getRoom;
            return json($return_data);
        } else { //辅导员
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '获取数据成功！';
            $return_data['data'] = $get;
            return json($return_data);
        }
    }

    /**
     * 折线图 
     * 返回近7/30天每天抽到的宿舍，未签到的宿舍(上传照片算签到)，以及学生未签到次数
     */
    public function lineInfo()
    {
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        }

        // 获取宿舍总数
        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];

        $dorm = Db('dorm')  
            ->field('d.dorm_num')
            ->alias('d')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();
        $numOfDorm = count($dorm); // 宿舍总数

        // 获取7天、30天的一天被抽中的宿舍数
        $today = date('Y-m-d 23:59:59');
        $recent7 = date('Y-m-d', strtotime("-6 days")); // 近7天
        $recent30 = date('Y-m-d', strtotime("-29 days")); // 近30天

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = array('between', array($recent7, $today));
        $where['r.deleted'] = 0;

        $recordDay7 = Db('record')  // 7天内被抽查的宿舍
            ->alias('r')
            ->field('r.start_time, d.dorm_num')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        if (empty($recordDay7)) {
            return json(['error_code' => 2, 'msg' => '近七天无数据！']);
        }

        $where['r.start_time'] = array('between', array($recent30, $today));
        $recordDay30 = Db('record')  // 30天内
            ->alias('r')
            ->field('r.start_time, d.dorm_num')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        if (empty($recordDay30)) {
            return json(['error_code' => 2, 'msg' => '近三十天无数据！']);
        }

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = array('between', array($recent7, $today));
        $where['r.deleted'] = 0;
        $where['t.sign'] = 0;

        $unsign7 = Db('result')   // 7天内的未签到的学生
            ->field('r.start_time, d.dorm_num, t.student_id, s.username')
            ->alias('t')
            ->join('student s', 's.id = t.student_id')
            ->join('record r', 't.record_id = r.id')
            ->join('dorm d', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $where['r.start_time'] = array('between', array($recent30, $today));

        $unsign30 = Db('result')   // 30天内
            ->field('r.start_time, d.dorm_num, t.student_id, s.username')
            ->alias('t')
            ->join('student s', 's.id = t.student_id')
            ->join('record r', 't.record_id = r.id')
            ->join('dorm d', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();
        // dump($recordDay7);
        // dump($recordDay30);
        // dump($unsign7);
        // dump($unsign30);
        $recordDay7_ = $this->common($recordDay7);
        $recordDay30_ = $this->common($recordDay30);
        $unsign7_ = $this->common($unsign7);
        $unsign30_ = $this->common($unsign30);

        $day7 = []; // 获取7天日期
        for ($i = 0; $i < 7; $i++) {
            $day7[$i] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }

        for ($i = 0; $i < 7; $i++) { // 对7天被抽到宿舍进行数据填充
            if (array_key_exists($day7[$i], $recordDay7_)) {
                continue;
            } else {
                $recordDay7_[$day7[$i]]['start_time'] = $day7[$i];
                $recordDay7_[$day7[$i]]['dorm_count'] = 0;
            }
        }

        for ($i = 0; $i < 7; $i++) { // 对7天未签到宿舍进行数据填充
            if (array_key_exists($day7[$i], $unsign7_)) {
                continue;
            } else {
                $unsign7_[$day7[$i]]['start_time'] = $day7[$i];
                $unsign7_[$day7[$i]]['dorm_count'] = 0;
            }
        }
        ksort($unsign7_); // 对键进行排序

        ksort($recordDay7_);

        $day7 = array_column($recordDay7_, 'start_time');
        $dorm7 = array_column($recordDay7_, 'dorm_count');
        $unsignDorm7 = array_column($unsign7_, 'dorm_count');

        $day30 = array_column($recordDay30_, 'start_time');
        $dorm30 = array_column($recordDay30_, 'dorm_count');
        $unsignDorm30 = array_column($unsign30_, 'dorm_count');

        // 7天排行榜
        $unsignStu7 = array_column($unsign7_, 'student_id'); // 提取学号
        $unsignStu7 = array_reduce($unsignStu7, 'array_merge', array()); // 转一维数组
        $unsignStu7 = array_count_values($unsignStu7);

        $i = 0;
        foreach ($unsignStu7 as $k => $v) {  // 转为二维数组
            $unsignStu7_[$i]['student_id'] = $k;
            $unsignStu7_[$i]['count'] = $v;
            $i++;
        }
        array_multisort(array_column($unsignStu7_, 'count'), SORT_DESC, array_column($unsignStu7_, 'student_id'), SORT_ASC, $unsignStu7_); // 数量降序 学号升序
        $i = 1;
        foreach ($unsignStu7_ as $key => $value) {
            if ($key == 0) {
                $unsignStu7_[$key]['index'] = 1;
            } else {
                if ($unsignStu7_[$key - 1]['count'] == $unsignStu7_[$key]['count']) {
                    $unsignStu7_[$key]['index'] = $i;
                } else {
                    $unsignStu7_[$key]['index'] = ++$i;
                }
            }
        }

        // 30天排行榜
        $unsignStu30 = array_column($unsign30_, 'student_id'); // 提取学号
        $unsignStu30 = array_reduce($unsignStu30, 'array_merge', array()); // 转一维数组
        $unsignStu30 = array_count_values($unsignStu30);

        $i = 0;
        foreach ($unsignStu30 as $k => $v) {  // 转为二维数组
            $unsignStu30_[$i]['student_id'] = $k;
            $unsignStu30_[$i]['count'] = $v;
            $i++;
        }
        array_multisort(array_column($unsignStu30_, 'count'), SORT_DESC, array_column($unsignStu30_, 'student_id'), SORT_ASC, $unsignStu30_); // 数量降序 学号升序
        $i = 1;
        foreach ($unsignStu30_ as $key => $value) {
            if ($key == 0) {
                $unsignStu30_[$key]['index'] = 1;
            } else {
                if ($unsignStu30_[$key - 1]['count'] == $unsignStu30_[$key]['count']) {
                    $unsignStu30_[$key]['index'] = $i;
                } else {
                    $unsignStu30_[$key]['index'] = ++$i;
                }
            }
        }

        foreach ($unsign7_ as $k => $v) {
            unset($unsign7_[$k]['student_id']); // 删除学号显示
        }
        foreach ($unsign30_ as $k => $v) {
            unset($unsign30_[$k]['student_id']); // 删除学号显示
        }

        $countStu7 = count($unsignStu7_);
        $countStu30 = count($unsignStu30_);
        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '统计结束！';
        $return_data['data']['numOfDorm'] = $numOfDorm;
        $return_data['data']['day7'] = $day7;
        $return_data['data']['dorm7'] = $dorm7;
        $return_data['data']['unsignDorm7'] = $unsignDorm7;
        $return_data['data']['day30'] = $day30;
        $return_data['data']['dorm30'] = $dorm30;
        $return_data['data']['unsignDorm30'] = $unsignDorm30;
        $return_data['data']['unsignStu7'] = $unsignStu7_;
        $return_data['data']['unsignStu30'] = $unsignStu30_;
        $return_data['data']['countStu7'] = $countStu7;
        $return_data['data']['countStu30'] = $countStu30;
        return json($return_data);
    }

    /**
     * 日期升序排列
     */
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
            // isset是检测变量是否设置，并且不是 NULL。
            if (isset($v['student_id'])) {
                $array_[$k]['student_id'] = explode(',', $v['student_id']);
            }
            unset($array_[$k]['dorm_num']); // 删除宿舍显示
        }

        asort($array_); // 根据日期升序排列
        // $array_ = array_values($array_);
        return $array_;
    }
}
