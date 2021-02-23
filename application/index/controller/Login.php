<?php

namespace app\index\controller;

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
		$uaccount = Request::instance()->post('uaccount');
		$password = md5(Request::instance()->post('password'));

		$where = ['id' => $uaccount, 'password' => $password];

		$data = Db('counselor') //比对用户名密码是否正确
			->field('*')
			->where($where)
			->find();
		
		if (!empty($data)) {
			$_SESSION['grade'] = $data['grade'];
			$_SESSION['department'] = $data['department'];
			Session::set('id', $data['id']);
			Session::set('username', $data['username']);
			Session::set('password', $data['password']);
			Session::set('grade', $data['grade']);
			Session::set('department', $data['department']);
			$this->redirect('/cqcq/public/index.php/index/column');
		} else {
			$this->error("用户名或密码错误", url('index/login/index'));
		}

	}
}
