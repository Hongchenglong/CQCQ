<?php

namespace app\index\controller;

use \think\Db;
use \think\Request;
use \think\Session;

class Table extends BaseController
{
	public function table()
	{
		return $this->fetch();
	}

	public function add()
	{
		return $this->fetch();
	}

	public function edit()
	{
		return $this->fetch();
	}

	public function file()
	{
		return $this->fetch();
	}

	public function file_face()
	{
		return $this->fetch();
	}

	//返回表中所有宿舍信息
	public function informations()
	{
		Db::connect();
		$result = db('Student', [], false)->select();
		sort($result);
		foreach ($result as &$res){
		    if(!$res['face']){
		 		$res['face'] = '否';
		 	}else{
		 		$res['face'] = '是';
		 	}
		 }

		
		if ($result) {
			$return_data = array();
			$return_data['code'] = 0;
			$return_data['msg'] = '';
			$return_data['data'] = $result;
			$return_data['count'] = count($result);
			return json($return_data);
		}
	}

	//根据学号查找宿舍
	public function find_info()
	{
		$id = Request::instance()->post('id');
		// dump($id);
		$where = ['id' => $id];
		$data = Db('Student')
			->field('id,sex,phone,grade,department,dorm,email')
			->where($where)
			->find();
		if (!empty($data)) {
			$return_data = array();
			$return_data['error_code'] = 0;
			$return_data['msg'] = '查找成功！';
			$return_data['data'] = $data;
			return json($return_data['data']);
		} else {
			echo "查无该学号";
		}
	}

	//添加单人信息
	public function add_user()
	{
		$id = Request::instance()->post('id');
		$sex = Request::instance()->post('sex');
		$username = Request::instance()->post('username');
		$password = md5(Request::instance()->post('password'));
		$email = Request::instance()->post('email');
		$phone = Request::instance()->post('phone');
		$grade = Request::instance()->post('grade');
		$department = Request::instance()->post('department');
		$dorm = Request::instance()->post('dorm');

		$where = ['id' => $id];
		$data_id = Db('Student')->where($where)->find();
		$data =
			[
				'id' => $id,
				'sex' => $sex,
				'username' => $username,
				'password' => $password,
				'email' => $email,
				'phone' => $phone,
				'grade' => $grade,
				'department' => $department,
				'dorm' => $dorm,
			];

		if ($data_id) {
			echo "<script language=\"JavaScript\">\r\n";
			echo " alert(\"添加失败，该学号已存在\");\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		} else {
			Db('Student')->insert($data);
			echo "<script language=\"JavaScript\">\r\n";
			echo " alert(\"添加成功\");\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		}
	}

	// 删除用户
	public function delete()
	{
		if (Session::has('id')) {
			$student_id = Request::instance()->get('student_id');
			$students = explode('_', $student_id);
			foreach ($students as $id) {
				Db::table('student')->where('id', $id)->delete();
			}
			echo "<script language=\"JavaScript\">\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		} else {
			$this->error("没有删除权限,请登录", url('/cqcq/back_end/public/index.php/index/table/table'));
		}
	}

	// 更改用户信息
	public function edit_user()
	{
		$id = Request::instance()->post('id');
		$sex = Request::instance()->post('sex');
		$username = Request::instance()->post('username');
		$email = Request::instance()->post('email');
		$phone = Request::instance()->post('phone');
		$grade = Request::instance()->post('grade');
		$department = Request::instance()->post('department');
		$dorm = Request::instance()->post('dorm');

		$result = Db('Student')
			->where(['id'  => $id])
			->update([
				'sex' => $sex,
				'username' => $username,
				'email' => $email,
				'phone' => $phone,
				'grade' => $grade,
				'department' => $department,
				'dorm' => $dorm,
			]);
		if ($result) {
			echo "<script language=\"JavaScript\">\r\n";
			echo " alert(\"更新成功\");\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		}
	}

	//上传，解析csv文件
	public function uploadFile()
	{

		// dump($_FILES["upfile"]);
		if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
			$upfile = $_FILES["upfile"];
			$name = $upfile['name'];
			$tmp_name = $upfile["tmp_name"]; //上传文件的临时存放路径
			move_uploaded_file($tmp_name, $name);
			// dump("上传成功");
		} else {
			// dump("您还没有上传文件");
		}
		if (!file_exists('uploads')) {
			mkdir('uploads');
		}

		$update_id = 0;
		$insert_id = 0;
		$data = [];
		$n = 0;
		$file = fopen($name, 'r');
		while (!feof($file)) {
			if ($n == 0) {
				$n++;
				$head = fgets($file);
				$head = trim($head);
				$head = explode(",", $head);
				$head = mb_convert_encoding($head, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
				// dump($head);
				// dump("--");
			} else {
				$html = fgets($file);
				$html = trim($html);
				$html = explode(",", $html);
				$reutrn_data[$n] = mb_convert_encoding($html, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
				$n++;
			}
		}
		for ($i = 1; $i < $n - 1; $i++) {
			$where = ['id' => $reutrn_data[$i][1]];
			$data_id = Db('Student')->where($where)->find();
			if (!$data_id) {
				$data[] = [
					'id' => $reutrn_data[$i][1],
					'password' => md5($reutrn_data[$i][1]),
					'sex' => $reutrn_data[$i][2],
					'username' => $reutrn_data[$i][0],
					'email' => $reutrn_data[$i][5],
					'phone' => $reutrn_data[$i][4],
					'grade' => $reutrn_data[$i][6],
					'department' => $reutrn_data[$i][7],
					'dorm' => $reutrn_data[$i][3],
				];
				$insert_id = $insert_id + 1;
			} else {
				$result = Db('Student')
					->where(['id'  => $reutrn_data[$i][1]])
					->update([
						'sex' => $reutrn_data[$i][2],
						'username' => $reutrn_data[$i][0],
						'email' => $reutrn_data[$i][5],
						'phone' => $reutrn_data[$i][4],
						'grade' => $reutrn_data[$i][6],
						'department' => $reutrn_data[$i][7],
						'dorm' => $reutrn_data[$i][3],
					]);
				if ($result) {
					$update_id = $update_id + 1;
				}
			}
		}

		$in_result = Db('Student')->insertAll($data);

		if ($in_result && $update_id) {
			echo "<script language=\"JavaScript\">\r\n";
			echo " alert(\"{$insert_id}条信息导入成功，{$update_id}条信息更改成功\");\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		} else if ($in_result) {
			echo "<script language=\"JavaScript\">\r\n";
			echo " alert(\"{$insert_id}条信息导入成功，未有数据被更改\");\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		} else if ($update_id) {
			echo "<script language=\"JavaScript\">\r\n";
			echo " alert(\"{$update_id}条信息替换成功，未新增数据\");\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		} else {
			echo "<script language=\"JavaScript\">\r\n";
			echo " alert(\"导入失败，所有学生信息已全部导入，且未发生更改\");\r\n";
			echo " history.back();\r\n";
			echo "</script>";
		}
		fclose($file);
	}
}
