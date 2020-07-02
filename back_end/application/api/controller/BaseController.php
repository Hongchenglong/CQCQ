<?php

namespace app\api\controller;

use \think\Controller;

// 基础控制器

class BaseController extends Controller
{
    public function _initialize()
    {
    }

    // 检查参数是否存在
    public function checkForExistence($parameter)
    {
        foreach ($parameter as $key => $value) {
            if (empty($_POST[$value])) {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                // print_r(json($return_data));
                return json($return_data);
            }
        }
    }


}
