<?php

namespace app\api\controller;

use think\Db;

class Statistics extends Face
{
    /**
     * 通过人脸搜索M:N识别，返回单个宿舍的签到与未签到名单
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function face_search()
    {
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

        $current = date("Y-m-d h:i:s");
        if ($_POST['end_time'] < $current) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '查寝时间已结束！';
            return json($return_data);
        }

        $img = Db::table('cq_record')  // 提取该宿舍照片
            ->alias('r')
            ->field('r.photo, s.id, s.username')
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        $stu = array_column($img, 'id'); // 提取id列，即学号
        $stu_name = array_column($img, 'username'); // 提取姓名
        $photo = array_unique(array_column($img, 'photo'))[0]; // 提取photo列并去重

        Db::table('cq_record')   // 重新上传照片后，本宿舍中的学号下的签到sign清零
            ->alias('r')
            ->join('cq_dorm d', 'd.id = r.dorm_id')
            ->join('cq_student s', 's.dorm = d.dorm_num')
            ->join('cq_result t', 't.record_id = r.id')
            ->where($where)
            ->setField('t.sign', 0);

        $data = array();
        $dorm = str_replace("#", '', $_POST['dorm']);

        // 未上传照片
        if (empty($photo)) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '未上传照片！';
            $return_data['unsign_stu'] = $stu; // 学号
            $return_data['unsign_stu_name'] = $stu_name;

            return json($return_data);
        }

        // $res = $this->faceverify($photo);  // 活体检测

        $res = $this->multi_search($photo, $dorm, $_POST['grade']);  // 人脸搜索
        $res = json_decode($res, true); // score80分以上可以判断为同一人

        if (!empty($res['result'])) {
            foreach ($res['result']['face_list'] as $key => $value) {
                if (!empty($res['result']['face_list'][$key]['user_list'])) { // 匹配的用户信息列表
                    $sign_stu[$key] = intval($res['result']['face_list'][$key]['user_list'][0]['user_id']); // 提取学号并转为整型

                    $where = array();
                    $where['r.start_time'] = $_POST['start_time'];
                    $where['r.end_time'] = $_POST['end_time'];
                    $where['r.deleted'] = 0;
                    $where['t.student_id'] = $sign_stu[$key];

                    Db::table('cq_record')   // 本宿舍识别到的学号记录下sign记为1
                        ->alias('r')
                        ->join('cq_result t', 't.record_id = r.id')
                        ->where($where)
                        ->setField('t.sign', 1);
                }
            }
        }

        $unsign_stu = array_diff($stu, $sign_stu); // (所有，已签) 比较两个数组的值，并返回差集
        $unsign_stu = array_merge($unsign_stu); // 扁平化

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '人脸识别完成！';
        $return_data['unsign_stu'] = $unsign_stu; // 未签的学号
        $return_data['sign_stu'] = $sign_stu;

        // 通过学号匹配该学生的姓名
        if (!empty($return_data['unsign_stu'])) {
            foreach ($unsign_stu as $key => $value) {
                $name = Db::table('cq_student')
                    ->field('username')
                    ->where('id', $unsign_stu[$key])
                    ->find();
                $return_data['unsign_stu_name'][$key] = $name['username'];
            }
            $return_data['unsign_stu_name'] = array_merge($return_data['unsign_stu_name']); // 扁平化
        }

        if (!empty($return_data['sign_stu'])) {
            foreach ($sign_stu as $key => $value) {
                $name = Db::table('cq_student')
                    ->field('username')
                    ->where('id', $sign_stu[$key])
                    ->find();
                $return_data['sign_stu_name'][$key] = $name['username'];
            }
            $return_data['sign_stu_name'] = array_merge($return_data['sign_stu_name']); // 扁平化
        }

        return json($return_data);
    }

    /**
     * 某次未签到名单
     */
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

        $list = Db::table('cq_result')   // 查找未签到人员信息
            ->field('s.id, s.username, d.dorm_num')
            ->alias('t')
            ->join('cq_student s', 's.id = t.student_id')
            ->join('cq_record r', 't.record_id = r.id')
            ->join('cq_dorm d', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();

        foreach ($list as $k => $v) {
            $list[$k]['block'] = explode('#', $v['dorm_num'])[0];
            $list[$k]['room'] = explode('#', $v['dorm_num'])[1];
            unset($list[$k]['dorm_num']);
        }

        $where['t.sign'] = 1;
        $num = Db::table('cq_result')   // 查找已签到人员
            ->field('s.id')
            ->alias('t')
            ->join('cq_student s', 's.id = t.student_id')
            ->join('cq_record r', 't.record_id = r.id')
            ->join('cq_dorm d', 's.dorm = d.dorm_num')
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
