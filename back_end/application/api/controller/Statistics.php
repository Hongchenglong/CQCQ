<?php

namespace app\api\controller;

class Statistics extends Face
{
    public function statistics()
    {
        // $parameter = ['grade', 'department', 'start_time', 'end_time'];
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

        if (date("Y-m-d h:i:s") < $_POST['end_time']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '该查寝尚未结束！';
            return json($return_data);
        }

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['r.deleted'] = 0;

        $img = Db('record')  // 该条记录下的所有宿舍
            ->alias('r')
            ->field('d.dorm_num, photo')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $return_data = array();
        foreach ($img as $k => $v) {
            $v['dorm'] = str_replace("#", '', $v['dorm_num']);

            if (empty($v['photo'])) {
                continue;
            }

            $res[$k] = $this->multi_search($v['photo'], $v['dorm']);  // 人脸搜索
            $res[$k] = json_decode($res[$k], true);

            // if ($res[$k]['error_code'] == 222207) {
            //     echo $v['dorm_num'] . '人脸库中不存在该照片中用户！';
            // }

            if (!empty($res[$k]['result'])) {
                foreach ($res[$k]['result']['face_list'] as $key => $value) {
                    if (!empty($res[$k]['result']['face_list'][$key]['user_list'])) {
                        $return_data[$key] = intval($res[$k]['result']['face_list'][$key]['user_list'][0]['user_id']); // 提取学号转换为整型

                        $where = array();
                        $where['r.start_time'] = $_POST['start_time'];
                        $where['r.end_time'] = $_POST['end_time'];
                        $where['r.deleted'] = 0;
                        $where['t.student_id'] = $return_data[$key];

                        Db('record')   // 成功搜索到，则该学号该条记录下sign+1
                            ->alias('r')
                            ->join('result t', 't.record_id = r.id')
                            ->where($where)
                            ->setField('t.sign', 1);
                    }
                }
            }
        }

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['r.deleted'] = 0;
        $where['t.sign'] = 0;

        $list = Db('record')   // 查找未签到人员信息
            ->field('s.id, s.username, d.dorm_num')
            ->alias('r')
            ->join('result t', 't.record_id = r.id')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        foreach($list as $k => $v){
            $list[$k]['block'] = explode('#', $v['dorm_num'])[0];
            $list[$k]['room'] = explode('#', $v['dorm_num'])[1];
            unset($list[$k]['dorm_num']);
        }

        $where['t.sign'] = 1;
        $num = Db('record')   // 查找已签到人员
            ->field('t.student_id')
            ->alias('r')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->join('result t', 't.record_id = r.id')
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
