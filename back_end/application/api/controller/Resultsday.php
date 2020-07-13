<?php

namespace app\api\controller;

class Resultsday
{
    public function getDay()
    {
        // $parameter = ['department', 'grade', 'start_time', 'end_time'];
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

        $where = array();
        $where['s.grade'] = $_POST['grade'];
        $where['s.department'] = $_POST['department'];
        $where['r.deleted'] = 0;

        $day = Db('record')
            ->alias('r')    // 别名
            ->field('r.start_time')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->distinct(true)
            ->select();
        
        $day = array_column($day, 'start_time');
        foreach($day as $k => $v){
            $day[$k] = explode(' ', $day[$k])[0];
        }
        
        $day = array_values(array_unique($day));

        $return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '输出记录日期';
        $return_data['data']['day'] = $day;
        return json($return_data);

    }
}
