<?php
namespace app\index\controller;

use \think\Db;

class Table extends BaseController
{
    public function table(){
		return $this->fetch();
	}
}