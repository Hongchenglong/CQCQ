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
    public function request_post($url = '', $param = '') 
    {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;
        // 初始化curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // post提交方式
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        // 运行curl
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }

    public function get_token() //获取access_token
    {
        $url = 'https://aip.baidubce.com/oauth/2.0/token';
        $post_data['grant_type']       = 'client_credentials';
        $post_data['client_id']      = 'GCjHu7F1LGrE2Dq1wm19rKGo';
        $post_data['client_secret'] = 'TBLg5ROb7wvpLAk4gIOzM5VhWE2Hv48S';
        $o = "";
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";
        }
        $post_data = substr($o, 0, -1);

        $res = $this->request_post($url, $post_data);
        $res = json_decode($res, true);
        return $res['access_token'];
    }
}
