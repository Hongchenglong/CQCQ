<?php

namespace app\index\controller;

use \think\Db;

class Dormitory extends BaseController
{



    /**
     * 添加宿舍
     */
    public function insert()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['grade', 'department', 'sex', 'block', 'room'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询宿舍
        $where = array();
        $where['sex'] = $_POST['sex'];
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['dormNumber'] = $_POST['block'] . '#' . $_POST['room'];
        $result = db('dorm')->where($where)->find();
        
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '该宿舍已存在';
            return json($return_data);
        } else {
            db('dorm')->where($where)->insert();
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '添加成功';
            return json($return_data);
        }

    }


    /**
     * 随机抽取宿舍
     */
    public function draw()
    {
        // 校验参数是否存在
        $parameter = array();
        $parameter = ['numOfBoys', 'numOfGirls'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }
        $numOfBoys = $_POST['numOfBoys'];
        $numOfGirls = $_POST['numOfGirls'];

        // query方法用于执行SQL查询操作
        // 获取宿舍所有人数（但暂时没考虑到系别和年级）
        $boy = Db::query("select dormNumber from dorm where sex = '男' order by rand() limit " . $numOfBoys);
        $girl = Db::query("select dormNumber from dorm where sex = '女' order by rand() limit " . $numOfGirls);




        if ($girl && $boy) {
            for ($i = 0; $i < $numOfBoys; $i++) {
                $boy[$i]['randNumber'] = rand(1, 10000);
            }
            for ($i = 0; $i < $numOfGirls; $i++) {
                $girl[$i]['randNumber'] = rand(1, 10000);
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
        $parameter = ['block', 'room'];
        $result = $this->checkForExistence($parameter);
        if ($result) {
            return $result;
        }

        // 查询宿舍
        $where = array();
        $where['dormNumber'] = $_POST['block'] . '#' . $_POST['room'];
        $result = db('dorm')->where($where)->find();

        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '指定成功';
            $return_data['data']['dormNumber'] = $result['dormNumber'];
            $return_data['data']['randNumber'] = rand(1, 10000);    // [1, 10000]的随机数
            return json($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '无此宿舍';

            return json($return_data);
        }
    }
}
