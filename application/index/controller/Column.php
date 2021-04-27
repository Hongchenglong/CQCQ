<?php
namespace app\index\controller;

use \think\Db;
use \think\Session;

class Column extends BaseController
{
    public function index() {
		return $this->fetch();
	}

	//退出清空记录
	public function out()
    {
		Session::clear();
		$this->redirect("/cqcq/public/index.php/index/login/index");
	}
}