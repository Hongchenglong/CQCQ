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
        $parameter = ['numOfBoys', 'numOfGirls', 'department', 'grade'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        $numOfBoys = $_POST['numOfBoys'];
        $numOfGirls = $_POST['numOfGirls'];

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];


        $boy = Db::table('dorm')
            ->field('dorm.id, dorm_num')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('sex', '男')
            ->orderRaw('rand()')
            ->limit($numOfBoys)
            ->select();
        $girl = Db::table('dorm')
            ->field('dorm.id, dorm_num')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->where('sex', '女')
            ->orderRaw('rand()')
            ->limit($numOfGirls)
            ->select();

        if ($girl && $boy) {

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
            $return_data['data']['dorm'] = array_merge_recursive($boy, $girl);

            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '抽签失败';

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
        $parameter = ['block', 'room', 'department', 'grade'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // // 查询条件
        // $where = array();
        // $where['grade'] = $_POST['grade'];
        // $where['department'] = $_POST['department'];
        // $amount = $_POST['amount'];

        // dump($_POST['block']);
        // for ($i = 0; $i < $amount; $i++) {

        //     $where['dorm_num'] = $_POST['block'][$i] . '#' . $_POST['room'][$i];
        //     $result = Db::table('dorm')
        //         ->field('dorm.id, dorm_num')   // 指定字段
        //         ->alias('d')    // 别名
        //         ->join('student s', 's.id = d.student_id')
        //         ->where($where)
        //         ->find();

        //     dump($result);

        // }

        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['dorm_num'] = $_POST['block'] . '#' . $_POST['room'];

        $result = Db::table('dorm')
            ->field('dorm.id, dorm_num')   // 指定字段
            ->alias('d')    // 别名
            ->join('student s', 's.id = d.student_id')
            ->where($where)
            ->find();   // 查询单个数据

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '指定成功';
            $return_data['data']['dorm_num'] = $result['dorm_num'];
            $return_data['data']['rand_num'] = rand(1, 10000);    // [1, 10000]的随机数

            $data = array();
            $data['dorm_id'] = $result['id'];
            $data['rand_num'] = $return_data['data']['rand_num'];
            Db::table('record')->insert($data);

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
     * 重新抽取
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
            $return_data['error_code'] = 1;
            $return_data['msg'] = '没有可删除的宿舍';

            return json($return_data);
        }
    }

    /**
     * 确认抽签结果
     */
    public function verifyResults()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['department', 'grade', 'start_time', ];
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
            ->setField('record.confirmed', 1);

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
