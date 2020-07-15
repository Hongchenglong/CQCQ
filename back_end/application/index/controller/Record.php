<?php

namespace app\index\controller;

use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

class Record extends BaseController
{
    public function records()
    {
        return $this->fetch();
    }
    //获取时间日期
    public function get_date()
    {
        Db::connect();
        $record = Db::table('record')
            ->field('start_time, end_time')   // 指定字段
            // ->alias('r')    // 别名
            // ->join('dorm d', 'd.id = r.dorm_id')
            // ->join('student s', 's.dorm = d.dorm_num')
            ->distinct(true)   // 返回唯一不同的值
            ->select();

        if (!empty($record)) {
            $return_data = array();
            rsort($record);  //排序
            $return_data['code'] = 0;
            $return_data['msg'] = '';
            $return_data['data'] = $record;
            $return_data['count'] = count($record);
            return json($return_data);
        } else {
            echo false;
        }
    }
    

    //搜索
    public function search_date()
    {
        $date = Request::instance()->post('date');
        $drecord = Db::table('record')
            ->field('start_time, end_time')
            ->distinct(true)   // 返回唯一不同的值
            ->where('start_time', 'between time', [$date . ' 00:00:00', $date . ' 23:59:59'])
            ->select();
        if (!empty($drecord)) {
            $data = array();
            rsort($drecord);  //排序
            $data['code'] = 0;
            $data['msg'] = '';
            $data['data'] = $drecord;
            $data['count'] = count($drecord);
            return json($data);
        } else {
            return 0;
        }
    }

}
