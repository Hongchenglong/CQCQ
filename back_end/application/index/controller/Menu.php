<?php
namespace app\index\controller;

use \think\Db;

class Menu extends BaseController
{
    public function menu(){
		return $this->fetch();
	}
}