<?php

namespace app\api\controller;

use \think\Db;
use \think\Exception;

class Usertest extends BaseController
{
    public function index()
    {
        $url = "https://api.weixin.qq.com/sns/jscode2session";
        // 参数
        $params = array();
        $params['appid'] = 'wx8d1d67d42a68281f';
        $params['secret'] = '587d0b9eace3cdf1e21fe5684b644e50';
        $params['js_code'] = $_POST['code'];
        $params['grant_type'] = 'authorization_code';
        $params['id'] = $_POST['id'];

        // 微信API返回的session_key 和 openid
        $arr = $this->httpCurl($url, $params, 'POST');
        $arr = json_decode($arr, true);

        // 判断是否成功
        if (isset($arr['errcode']) && !empty($arr['errcode'])) {
            return json(['error_code' => '2', 'message' => $arr['errmsg'], "result" => null]);
        }
        $openid = $arr['openid'];
        $session_key = $arr['session_key'];

        // 从数据库中查找是否有该openid
        $is_openid = Db::table('counselor')->where('openid', $openid)->find();

        // 如果openid存在，更新openid_time,返回登录成功信息及手机号
        if ($is_openid) {
            // openid存在，先判断openid_time,与现在的时间戳相比，如果相差大于4个小时，则则返回登录失败信息，使客户端跳转登录页，如果相差在四个小时之内，则更新openid_time，然后返回登录成功信息及手机号；
            // 根据openid查询到所在条数据
            $data = Db::table('counselor')->where('openid', $openid)->find();

            // 计算openid_time与现在时间的差值
            $time = time() - $data['openid_time'];
            $time = $time / 3600;

            // 如果四个小时没更新过，则登陆态消失，返回失败，重新登录
            if ($time > 4) {
                return json(['error_code' => '0', 'message' => '登录失败',]);
            } else {
                // 根据手机号更新openid时间
                $update = Db::table('counselor')->where('openid', $openid)->update(['openid_time' => time()]);

                // 判断是否更新成功
                if ($update) {
                    return json(['error_code' => '1', 'message' => '登录成功', 'id' => $data['id']]);
                } else {
                    return json(['error_code' => '0', 'message' => '登录失败']);
                }
            }

            // openid不存在时
        } else {
            // dump($id);
            // 如果openid不存在, 判断手机号是否为空
            if (isset($id) && !empty($id)) {
                // 如果不为空，则说明是登录过的，就从数据库中找到手机号，然后绑定openid，+时间
                // 登录后,手机号不为空，则根据手机号更新openid和openid_time
                $update = Db::table('counselor')
                    ->where('id', $id)
                    ->update([
                        'openid'  => $openid,
                        'openid_time' => time(),
                    ]);

                if ($update) {
                    return json(['error_code' => '1', 'message' => '登录成功',]);
                }
            } else {
                // 如果也为空，则返回登录失败信息，使客户端跳转登录页
                return json(['error_code' => '0', 'message' => '读取失败',]);
            }
        }
    }

    // 后台登录方法
    public function login()
    {
        // 获取到前台传输的手机号
        $id = $_POST['id'];

        // 判断数据库中该手机号是否存在
        $is_id = Db::table('counselor')->where('id', $id)->find();
        if (isset($is_id) && !empty($is_id)) {
            // 登录时，数据库中存在该手机号，则更新openid_time
            $update = Db::table('counselor')
                ->where('id', $id)
                ->update([
                    'openid_time' => time(),
                ]);

            if ($update) {
                return json(['error_code' => '1', 'message' => '登录成功',]);
            }
        } else {
            $data = [
                "id" => $id,
                "password" => '81dc9bdb52d04dc20036dbd8313ed055'

            ];

            // 如果数据库中不存在该手机号，则进行添加
            // Db::table('counselor')->insert($data);
        }
        return json(['error_code' => '1', 'message' => '登录成功',]);
    }

    /**
     * 根据微信API获取sessionkey和openid的方法
     */
    function httpCurl($url, $params, $method = 'GET', $header = array(), $multi = false)
    {
        date_default_timezone_set('PRC');
        $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header,
            CURLOPT_COOKIESESSION  => true,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_COOKIE
            => session_name() . '=' . session_id(),
        );

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                // $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                // 链接后拼接参数  &  非？
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }

        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) throw new Exception('请求发生错误：' . $error);
        return  $data;
    }
}
