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
                ->limit($numOfGirls)
                ->select();
        }

        $all = array_merge_recursive($boy, $girl);
        if ($all) {
            // 获取随机数，并将抽到的宿舍添加到record表中
            for ($i = 0; $i < $numOfBoys; $i++) {
                $boy[$i]['rand_num'] = rand(1, 10000);
                $data = array();
                $data['dorm_id'] = $boy[$i]['id'];
                $data['rand_num'] = $boy[$i]['rand_num'];
                Db::table('record')->insert($data);
            }
            for ($i = 0; $i < $numOfGirls; $i++) {
                $girl[$i]['rand_num'] = rand(1, 10000);
                $data = array();
                $data['dorm_id'] = $girl[$i]['id'];
                $data['rand_num'] = $girl[$i]['rand_num'];
                Db::table('record')->insert($data);
            }

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
                array_push($dormSuc, $result['dorm_num']);
                $data = array();
                $data['dorm_id'] = $result['id'];
                $data['rand_num'] = rand(1, 10000);
                $result = Db::table('record')->insert($data);
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
     * 显示未确认的抽签结果
     */
    public function displayUnconfirmedResults()
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
        $result = Db::table('record')
            ->field('dorm_num, rand_num')   // 指定字段
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where('confirmed', 0)
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
            $return_data['error_code'] = 1;
            $return_data['msg'] = '暂无抽签结果';

            return json($return_data);
        }
    }

    /**
     * 清空
     */
    public function redraw()
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
        $result = Db::execute(
            "delete r from record r join dorm d 
            on r.dorm_id = d.id join student s on s.id = d.student_id 
            where confirmed = 0 and s.grade=:grade and s.department=:department",
            ['grade' => $where['grade'], 'department' => $where['department']]
        );
        // $result = Db::table('record')
        //     ->alias('r')    // 别名
        //     ->join('dorm d', 'd.id = r.dorm_id')
        //     ->join('student s', 's.id = d.student_id')
        //     ->where('confirmed', 0)
        //     ->where($where)
        //     ->delete();
        // dump($result);

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '删除成功';

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '没有可删除的宿舍';

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
        $parameter = ['department', 'grade', 'startTime', 'endTime'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $result = Db::table('record')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where('confirmed = 0')
            ->where($where)
            ->update(['record.confirmed' => 1, 'start_time' => $_POST['startTime'], 'end_time' => $_POST['endTime']]);
        // ->setField('record.confirmed', 1);
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '确认成功';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '没有可确认的抽签结果';

            return json($return_data);
        }
    }

    /**
     * 显示已确认的抽签结果
     */
    public function displayConfirmedResults()
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
        $where['start_time'] = $_POST['start_time'];
        $where['department'] = $_POST['department'];
        $result = Db::table('record')
            ->field('dorm_num, rand_num')   // 指定字段
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where('confirmed', 1)
            ->where($where)
            ->select();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '显示已确认的抽签结果';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '暂无已确认的抽签结果';

            return json($return_data);
        }
    }
}
