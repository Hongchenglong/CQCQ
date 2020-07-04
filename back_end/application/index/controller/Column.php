<?php
namespace app\index\controller;

use \think\Db;

class Column extends BaseController
{
    public function index(){
		return $this->fetch();
	}
	public function page(){
		$this->redirect('menu/menu');
	}
}