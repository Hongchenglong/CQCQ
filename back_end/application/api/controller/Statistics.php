<?php

namespace app\api\controller;

class Statistics extends Face
{
    public function statistics()
    {
        // $parameter = ['dorm];
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
            ->field('d.block, d.room, photo')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $return_data = array();
        foreach ($img as $k => $v) {
            $v['dorm_num'] = $v['block'] . $v['room'];

            $where = array();
            $where['s.grade'] = $_POST['grade'];
            $where['s.department'] = $_POST['department'];
            $where['r.start_time'] = $_POST['start_time'];
            $where['r.end_time'] = $_POST['end_time'];
            $where['s.dorm'] = $v['block'] . '#' . $v['room'];
            $where['r.deleted'] = 0;

            $dorm[$k] = Db('record')  // 该宿舍该记录下的人员名单
                ->field('s.id')
                ->alias('r')
                ->join('dorm d', 'd.id = r.dorm_id')
                ->join('student s', 's.dorm = d.dorm_num')
                ->where($where)
                ->select();

            if (empty($v['photo'])) {
                $result[$k] = array_diff(array_column($dorm[$k], 'id'), $return_data);
                // echo $v['dorm_num'] . '宿舍未上传照片！';
                continue;
            }

            // dump($v['dorm_num'] . '进行人脸识别……');
            $res[$k] = $this->multi_search($v['photo'], $v['dorm_num']);  // 人脸搜索
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
                        $where['s.id'] = $return_data[$key];

                        Db('record')   // 成功搜索到，则该宿舍该条记录下sign+1
                            ->alias('r')
                            ->join('dorm d', 'd.id = r.dorm_id')
                            ->join('student s', 's.dorm = d.dorm_num')
                            ->where($where)
                            ->setInc('r.sign', 1);
                    }
                }
            }

            $result[$k] = array_diff(array_column($dorm[$k], 'id'), $return_data); // 查找照片匹配中不在宿舍的人员名单
        }

        foreach ($result as $key => $value) {
            foreach ($value as $k => $v) {
                $list[$key] = Db('student')   // 查找未签到人员信息
                    ->field('s.id, s.username, d.block, d.room')
                    ->alias('s')
                    ->join('dorm d', 's.dorm = d.dorm_num')
                    ->where('s.id', $v)
                    ->select();
            }
        }

        $list_ = array();
        foreach ($list as $k => $v) {   // 转二维数组
            foreach ($v as $key => $value) {
                array_push($list_, $value);
            }
        }
        // dump($list_);

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.start_time'] = $_POST['start_time'];
        $where['r.end_time'] = $_POST['end_time'];
        $where['r.deleted'] = 0;
        $num = Db('record')   // 查找该记录下的sign值
            ->field('r.sign, d.block, d.room')
            ->alias('r')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        // 已签到人数
        $sign_num = array_sum(array_column($num, 'sign')); // sign值求和

        // 未签到人数
        $unsign_num = count($list_);

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '统计结束！';
        $return_data['data']['sign_num'] = $sign_num;
        $return_data['data']['unsign_num'] = $unsign_num;
        $return_data['data']['unsign_list'] = $list_;
        return json($return_data);
    }
}
