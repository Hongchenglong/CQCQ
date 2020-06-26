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
        // $parameter = ['department', 'grade'];   
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
                ->join('student s', 's.dorm = d.dorm_num')
                ->where($where)
                ->where('sex', '男')
                ->orderRaw('rand()')
                ->limit($numOfBoys)
                ->select();
            for ($i = 0; $i < $numOfBoys; $i++) {
                $boy[$i]['rand_num'] = rand(1000, 10000);
            }
        }

        if ($numOfGirls) {
            $girl = Db::table('dorm')
                ->field('dorm.id, dorm_num')   // 指定字段
                ->alias('d')    // 别名
                ->join('student s', 's.dorm = d.dorm_num')
                ->where($where)
                ->where('sex', '女')
                ->orderRaw('rand()')
                ->limit($numOfGirls)
                ->select();
            for ($i = 0; $i < $numOfGirls; $i++) {
                $girl[$i]['rand_num'] = rand(1000, 10000);
            }
        }
        $all = array_merge_recursive($boy, $girl);

        if ($all) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '抽签成功!';
            $return_data['data']['dorm'] = $all;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '抽签失败，没有选择宿舍!';

            return json($return_data);
        }
    }


    /**
     * 抽取指定宿舍
     */
    public function customize()
    {
        // $parameter = ['department', 'grade', 'block', 'room'];
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
        } else if (empty($_POST['block'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入宿舍楼！';
            return json($return_data);
        } else if (empty($_POST['room'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入宿舍号！';
            return json($return_data);
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
                ->join('student s', 's.dorm = d.dorm_num')
                ->where($where)
                ->find();

            // 存在的宿舍
            if ($result) {
                $result['rand_num'] = rand(1000, 10000);
                array_push($dormSuc, $result);
            } else {    // 不存在的宿舍
                array_push($dormFal, $result['dorm_num']);
            }
        }

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '指定成功!';
            $return_data['data']['dormSuc'] = $dormSuc;
            $return_data['data']['dormFal'] = $dormFal;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '指定了不存在的宿舍!';

            return json($return_data);
        }
    }

    /**
     * 判断单间宿舍是否存在
     */
    public function doesItExist()
    {
        // $parameter = ['department', 'grade', 'block', 'room'];
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
        } else if (empty($_POST['block'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入宿舍楼！';
            return json($return_data);
        } else if (empty($_POST['room'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入宿舍号！';
            return json($return_data);
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['room']  = $_POST['room'];
        $where['block'] = $_POST['block'];
        $result = Db::table('dorm')
            ->alias('d')    // 别名
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->find();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '存在该宿舍!';

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '该宿舍不存在!';

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

        // $parameter = ['department', 'grade', 'start_time', 'end_time', 'dorm_id', 'rand_num'];
        // dorm_id, rand_num是列表
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
        } else if (empty($_POST['dorm_id'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入宿舍id！';
            return json($return_data);
        } else if (empty($_POST['rand_num'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入随机数！';
            return json($return_data);
        }


        // 先查看是否有这个时间段的记录，有则删除
        $where = array();
        $where['start_time'] = $_POST['start_time'];
        $where['end_time'] = $_POST['end_time'];
        Db::table('record')->where($where)->delete();


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
            $return_data['msg'] = '确认成功!';
            // $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '没有可确认的抽签结果!';

            return json($return_data);
        }
    }

    /**
     * 显示抽签结果
     */
    public function displayResults()
    {
        // $parameter = ['department', 'grade', 'start_time'];
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
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->select();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '显示抽签结果!';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '暂无抽签结果!';

            return json($return_data);
        }
    }

    /**
     * 显示当前的抽签结果
     */
    public function displayCurrentResults()
    {
        // $parameter = ['department', 'grade'];
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
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->where('end_time', '> time', $now)
            ->select();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '显示抽签结果!';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '暂无抽签结果!';

            return json($return_data);
        }
    }

    /**
     * 显示最近一次的抽签结果
     */
    public function displayRecentResults()
    {
        // $parameter = ['department', 'grade'];
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
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];

        // 先找到本系、本年级的id最大的开始时间和结束时间
        $recentTime = Db::table('record')
            ->field('r.id, start_time, end_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->where('deleted', 0)
            ->order('r.id desc')
            ->find();

        // 再用这个时间去找和它同一批的数据
        $result = Db::table('record')
            ->field('d.dorm_num, r.rand_num, r.start_time, r.end_time')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->where('start_time', $recentTime['start_time'])
            ->where('end_time', $recentTime['end_time'])
            ->where('deleted', 0)
            ->distinct(true)   // 返回唯一不同的值
            ->select();


        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '显示抽签结果!';
            $return_data['data'] = $result;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '暂无抽签结果!';

            return json($return_data);
        }
    }

    /**
     * 获取宿舍数量
     */
    public function getNumber()
    {
        // $parameter = ['department', 'grade'];
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
        }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];

        $boys = $girls = array();
        $boys = Db::table('dorm')
            ->alias('d')    // 别名
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->where('s.sex', '男')
            ->count('d.id');

        $girls = Db::table('dorm')
            ->alias('d')    // 别名
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->where('s.sex', '女')
            ->count('d.id');

        if ($boys + $girls) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '成功返回宿舍数量!';
            $return_data['data']['boys'] = $boys;
            $return_data['data']['girls'] = $girls;

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '该系暂无宿舍，请导入!';

            return json($return_data);
        }
    }
}
