<?php

namespace app\index\controller;

use app\index\model\Instructor;
use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

header("content-type:text/html; charset=utf-8");

class Login extends Controller
{
	public function index()
	{
		return $this->fetch();
	}

	public function valid()
	{
        $data = input('post.');
        $where = ['id' => $data['id'], 'password' => md5($data['password'])];
        $instructor = new Instructor();
        $result = $instructor->where($where)->find();
        if (!empty($result)) {
            Session::set('id', $result['id']);
            Session::set('username', $result['username']);
            Session::set('password', $result['password']);
            Session::set('grade', $result['grade']);
            Session::set('department', $result['department']);
			$this->redirect('/cqcq/public/index.php/index/column'); // 注意不能是index/column/index
		} else {
			$this->error("用户名或密码错误", url('index/login/index'));
		}

	}
}
