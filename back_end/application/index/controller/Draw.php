<?php

namespace app\index\controller;

use \think\Db;

class Draw extends BaseController
{

    /**
     * 随机抽取宿舍
     */
    public function draw()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['department', 'grade'];   // 'numOfBoys', 'numOfGirls', 
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $numOfBoys = $_POST['numOfBoys'];
        $numOfGirls = $_POST['numOfGirls'];
        $boy = $girl = array();

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];

        // 当选择宿舍数不为0时
        if ($numOfBoys) {
            $boy = Db::table('dorm')
                ->field('dorm.id, dorm_num')   // 指定字段
                ->alias('d')    // 别名
                ->join('student s', 's.id = d.student_id')
                ->where($where)
                ->where('sex', '男')
                ->orderRaw('rand()')
                ->limit($numOfBoys)
                ->select();
            for ($i = 0; $i < $numOfBoys; $i++) {
                $boy[$i]['rand_num'] = rand(1, 10000);
            }
        }

        if ($numOfGirls) {
            $girl = Db::table('dorm')
                ->field('dorm.id, dorm_num')   // 指定字段
                ->alias('d')    // 别名
                ->join('student s', 's.id = d.student_id')
                ->where($where)
                ->where('sex', '女')
                ->orderRaw('rand()')
                ->limit($numOfGirls)
                ->select();
            for ($i = 0; $i < $numOfGirls; $i++) {
                $girl[$i]['rand_num'] = rand(1, 10000);
            }
        }
        $all = array_merge_recursive($boy, $girl);

        if ($all) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '抽签成功';
            $return_data['data']['dorm'] = $all;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '抽签失败，没有选择宿舍';

            return json($return_data);
        }
    }


    /**
     * 抽取指定宿舍
     */
    public function customize()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['department', 'grade', 'block', 'room'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $dormSuc = array();
        $dormFal = array();

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $room = explode(',', $_POST['room']);
        $block = explode(',', $_POST['block']);
        $len = sizeof($room);
        for ($i = 0; $i < $len; $i++) {
            $where['room']  = $room[$i];
            $where['block'] = $block[$i];
            $result = Db::table('dorm')
                ->field('dorm.id, dorm_num')   // 指定字段
                ->alias('d')    // 别名
                ->join('student s', 's.id = d.student_id')
                ->where($where)
                ->find();

            // 存在的宿舍
            if ($result) {
                $result['rand_num'] = rand(1, 10000);
                array_push($dormSuc, $result);
            } else {    // 不存在的宿舍
                array_push($dormFal, $result['dorm_num']);
            }
        }
        // print_r($dorm_num);

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '指定成功';
            $return_data['data']['dormSuc'] = $dormSuc;
            $return_data['data']['dormFal'] = $dormFal;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '无此宿舍';

            return json($return_data);
        }
    }


    /**
     * 确认抽签结果
     */
    public function verifyResults()
    {
        // dump(date('Y-m-d:', time()));
        // 2020-04-30 16:22:52

        // 校验参数是否存在
        $parameter = array();
        $parameter = ['department', 'grade', 'start_time', 'end_time', 'dorm_id', 'rand_num'];
        // dorm_id, rand_num是列表
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $dorm_id = explode(',', $_POST['dorm_id']);
        $rand_num = explode(',', $_POST['rand_num']);
        $len = sizeof($dorm_id);
        for ($i = 0; $i < $len; $i++) {
            $data = array();
            $data['dorm_id'] = $dorm_id[$i];
            $data['rand_num'] = $rand_num[$i];
            $data['start_time'] = $_POST['start_time'];
            $data['end_time'] = $_POST['end_time'];
            $result = Db::table('record')->insert($data);
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '确认成功';
            // $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '没有可确认的抽签结果';

            return json($return_data);
        }
    }

    /**
     * 显示抽签结果
     */
    public function displayResults()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['department', 'grade', 'start_time'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['start_time'] = $_POST['start_time'];
        $result = Db::table('record')
            ->field('d.dorm_num, r.rand_num, r.start_time, r.end_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->select();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '显示抽签结果';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '暂无抽签结果';

            return json($return_data);
        }
    }

    /**
     * 显示当前的抽签结果
     */
    public function displayCurrentResults()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['department', 'grade'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $now = date('Y-m-d H:i:s', time());

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $result = Db::table('record')
            ->field('d.dorm_num, r.rand_num, r.start_time, r.end_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('end_time', '> time', $now)
            ->select();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '显示抽签结果';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '暂无抽签结果';

            return json($return_data);
        }
    }

    /**
     * 显示最近一次的抽签结果
     */
    public function displayRecentResults()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['department', 'grade'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];

        // 先找到id最大的开始时间
        $recentTime = Db::table('record')
            ->field('r.id, start_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->order('r.id desc')
            ->find();

        // 再用这个时间去找和它同一批的数据
        $result = Db::table('record')
            ->field('d.dorm_num, r.rand_num, r.start_time, r.end_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('start_time', $recentTime['start_time'])
            ->select();


        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '显示抽签结果';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '暂无抽签结果';

            return json($return_data);
        }
    }
}
