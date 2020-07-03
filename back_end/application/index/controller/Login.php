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
			Session::set('id', $data['id']);
			Session::set('username', $data['username']);
			Session::set('password', $data['password']);
			$this->redirect('home/home');
		} else {
			$this->error("用户名或密码错误", url('login/index'));
		}
	}
}
