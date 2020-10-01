<?php

namespace app\api\controller;

use \think\Db;
use \think\Exception;

class User extends BaseController
{
    /**
     * 用户登录
     * @return [type] [description]
     */
    public function login()
    {
        // $parameter = ['id', 'password'];
        // 输入判断
        if (empty($_POST['id'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入用户id！';
            return json($return_data);
        } else if (empty($_POST['password'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入密码！';
            return json($return_data);
        }
        $where['id'] = $_POST['id'];

        // 先从辅导员表中查询，若不存在从学生表中查询
        $user = Db::table('counselor')
            ->where($where)
            ->find();
        if ($user) $user['user'] = 'counselor';

        if (empty($user)) {
            $user = Db::table('student')
                ->where($where)
                ->find();
            if ($user) $user['user'] = 'student';
        }
        // 如果查询到该用户
        if ($user) {
            // 如果密码不等
            if (md5($_POST['password']) != $user['password']) {
                $return_data = array();
                $return_data['error_code'] = 2;
                $return_data['msg'] = '您输入的账号或密码不正确';

                return json($return_data);
            } else {
                unset($user['password']);   // 删除密码
                $return_data = array();
                $return_data['error_code'] = 0;
                $return_data['msg'] = '登录成功';
                $return_data['data'] = $user;

                return json($return_data);
            }
        } else {
            // 用户不存在
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '您输入的账号或密码不正确';

            return json($return_data);
        }
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

    /**
     * 微信登录
     * @return [type] [description]
     */
    public function wxLogin()
    {
        if (empty($_POST['code'])) {
            return json(['error_code' => '1', 'msg' => '请输入code！']);
        }
        $url = "https://api.weixin.qq.com/sns/jscode2session";

        $params = $this->wx_openid($_POST['code']);

        // 微信API返回的session_key 和 openid
        $arr = $this->httpCurl($url, $params, 'POST');
        $arr = json_decode($arr, true);

        // 判断是否成功
        if (isset($arr['errcode']) && !empty($arr['errcode'])) {
            return json(['error_code' => '2', 'msg' => $arr['errmsg'], "result" => null]);
        }

        $openid = $arr['openid'];
        // $session_key = $arr['session_key'];

        // 从数据库中查找是否有该openid
        // 先从辅导员表中查询，若不存在从学生表中查询
        $user = db('counselor')->where('openid', $openid)->find();
        if ($user) $user['user'] = 'counselor';

        if (empty($user)) {
            $user = db('student')->where('openid', $openid)->find();
            if ($user) $user['user'] = 'student';
        }

        if ($user) {
            unset($user['openid']);  // 删除openid
            unset($user['password']);  // 删除密码
            return json(['error_code' => '0', 'msg' => '登录成功', 'data' => $user]);

        } else {
            // 该微信用户没有绑定账号
            return json(['error_code' => '1', 'msg' => '您没有绑定账号，请登录后在“我的”页面绑定~']);
        }
    }

    /**
     * 微信绑定
     * @return [type] [description]
     */
    public function wxBinding()
    {
        if (empty($_POST['id'])) {
            return json(['error_code' => '1', 'msg' => '请输入用户id！']);
        } else if (empty($_POST['user'])) {
            return json(['error_code' => '1', 'msg' => '请输入用户身份！']);
        } else if (empty($_POST['code'])) {
            return json(['error_code' => '1', 'msg' => '请输入code！']);
        }

        $user = $_POST['user'];
        $unbind = db($user)->where('id', $_POST['id'])->find();

        // 如果数据库中已有openid，则解除绑定
        if (!empty($unbind['openid'])) {
            db($user)->where('id', $_POST['id'])->update(['openid' => null]);
            return json(['error_code' => '0', 'msg' => '解除绑定，您下次登录时需要使用账号密码']);
        }

        $url = "https://api.weixin.qq.com/sns/jscode2session";
        $params = $this->wx_openid($_POST['code']);

        // 微信API返回的session_key 和 openid
        $arr = $this->httpCurl($url, $params, 'POST');
        $arr = json_decode($arr, true);

        // 判断是否成功
        if (isset($arr['errcode']) && !empty($arr['errcode'])) {
            return json(['error_code' => '2', 'msg' => $arr['errmsg'], "result" => null]);
        }
        $openid = $arr['openid'];

        // 插入openid
        $bind = db($user)->where('id', $_POST['id'])->update(['openid' => $openid]);
        if ($bind) {
            return json(['error_code' => '0', 'msg' => '绑定成功']);
        } else {
            // 找不到账号
            return json(['error_code' => '1', 'msg' => '绑定失败']);
        }
    }

    /**
     * 用户注册
     * @return [type] [description]
     */
    public function sign()
    {
        // $parameter = ['username', 'password', 'password_again', 'email', 'phone'];
        // 输入判断
        if (empty($_POST['username'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入昵称！';
            return json($return_data);
        } else if (empty($_POST['password'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入密码！';
            return json($return_data);
        } else if (empty($_POST['password_again'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请再次输入密码！';
            return json($return_data);
        } else if (empty($_POST['email'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入邮箱！';
            return json($return_data);
        } else if (empty($_POST['phone'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入手机号！';
            return json($return_data);
        }

        // 检验两次密码是否输入一致
        if ($_POST['password'] != $_POST['password_again']) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '两次密码不一致!';

            return json($return_data);
        }

        // 检验邮箱、手机号是否已被注册
        // 构造查询条件
        $parameter = array();
        $parameter = ['email', 'phone'];
        foreach ($parameter as $key => $value) {
            $where = array();
            $where[$value] = $_POST[$value];
            $user = db('user')->where($where)->find();
            if ($user) {
                // 如果存在，提示已注册
                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = $value . '已被注册!';

                return json($return_data);
            }
        }


        // 如果尚未注册，则注册
        $data = array();
        $data['username'] = $_POST['username'];
        $data['phone'] = $_POST['phone'];
        $data['email'] = $_POST['email'];
        // 密码经过md5函数加密，得到32位字符串
        $data['password'] = md5($_POST['password']);

        // dump(1);
        // 插入记录并获取自增ID
        $result = db('user')->insertGetId($data);

        // dump($result);
        if ($result) {
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '注册成功';
            $return_data['data']['user_id'] = $result;
            $return_data['data']['username'] = $_POST['username'];
            $return_data['data']['phone'] = $_POST['phone'];
            $return_data['data']['email'] = $_POST['email'];

            return json($return_data);
        } else {
            // 插入数据执行失败
            $return_data = array();
            $return_data['error_code'] = 4;
            $return_data['msg'] = '注册失败!';

            return json($return_data);
        }
    }
}
