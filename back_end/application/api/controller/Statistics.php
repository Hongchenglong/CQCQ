<?php

namespace app\api\controller;

class Statistics extends Face
{
    public function face_search()
    {
        // $parameter = ['grade', 'department', 'start_time', 'end_time', 'dorm'];
        // 输入判断
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['start_time'])) {
            return json(['error_code' => 1, 'msg' => '请输入开始时间！']);
        } else if (empty($_POST['end_time'])) {
            return json(['error_code' => 1, 'msg' => '请输入结束时间！']);
        } else if (empty($_POST['dorm'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍号！']);
        } 

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['d.dorm_num'] = $_POST['dorm'];
        $where['r.deleted'] = 0;

        $img = Db('record')  // 提取该宿舍照片
            ->alias('r')
            ->field('r.photo, s.id')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $stu = array_column($img, 'id');
        $photo = array_unique(array_column($img, 'photo'))[0];

        Db('record')   // 本宿舍中的学号下的sign清零
            ->alias('r')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->join('result t', 't.record_id = r.id')
            ->where($where)
            ->setField('t.sign', 0);

        $data = array();

        $dorm = str_replace("#", '', $_POST['dorm']);

        if (empty($photo)) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '未上传照片！';
            $return_data['unsign_stu'] = $stu;
            return json($return_data);
        }

        $res = $this->multi_search($photo, $dorm, $_POST['grade']);  // 人脸搜索
        $res = json_decode($res, true);

        if (!empty($res['result'])) {
            foreach ($res['result']['face_list'] as $key => $value) {
                if (!empty($res['result']['face_list'][$key]['user_list'])) {
                    $data[$key] = intval($res['result']['face_list'][$key]['user_list'][0]['user_id']); // 提取学号转换为整型

                    $where = array();
                    $where['r.start_time'] = $_POST['start_time'];
                    $where['r.end_time'] = $_POST['end_time'];
                    $where['r.deleted'] = 0;
                    $where['t.student_id'] = $data[$key];

                    Db('record')   // 本宿舍识别到的学号记录下sign记为1
                        ->alias('r')
                        ->join('result t', 't.record_id = r.id')
                        ->where($where)
                        ->setField('t.sign', 1);
                }
            }
        }

        $unsign_stu = array_diff($stu, $data);
        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '人脸识别完成！';
        $return_data['unsign_stu'] = $unsign_stu;
        return json($return_data);
    }

    public function stu_statistics()
    {
        // $parameter = ['grade', 'department', 'start_time', 'end_time'];
        // 输入判断
        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['start_time'])) {
            return json(['error_code' => 1, 'msg' => '请输入开始时间！']);
        } else if (empty($_POST['end_time'])) {
            return json(['error_code' => 1, 'msg' => '请输入结束时间！']);
        } 
        
        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['r.deleted'] = 0;
        $where['t.sign'] = 0;

        $list = Db('result')   // 查找未签到人员信息
            ->field('s.id, s.username, d.dorm_num')
            ->alias('t')
            ->join('student s', 's.id = t.student_id')
            ->join('record r', 't.record_id = r.id')
            ->join('dorm d', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        foreach ($list as $k => $v) {
            $list[$k]['block'] = explode('#', $v['dorm_num'])[0];
            $list[$k]['room'] = explode('#', $v['dorm_num'])[1];
            unset($list[$k]['dorm_num']);
        }

        $where['t.sign'] = 1;
        $num = Db('result')   // 查找已签到人员
            ->field('s.id')
            ->alias('t')
            ->join('student s', 's.id = t.student_id')
            ->join('record r', 't.record_id = r.id')
            ->join('dorm d', 's.dorm = d.dorm_num')
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
