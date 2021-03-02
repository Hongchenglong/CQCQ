<?php

namespace app\index\controller;

use app\index\model\Instructor;
use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
use \think\Validate;

class User extends BaseController
{
    public function user()
    {
        return $this->fetch();
    }

    public function user_setting()
    {
        return $this->fetch();
    }
    public function user_password()
    {
        return $this->fetch();
    }
    //获取数据库信息
    public function get_trinfo(){
        $id = Request::instance()->post('id');
        $instructor = new Instructor();
        $tr_data = $instructor->where('id', $id)->find();

        $data = [
            'email' => $tr_data['email'],
            'phone' => $tr_data['phone'],
            'grade' => $tr_data['grade'],
            'department' => $tr_data['department'],
        ];
        return json($data);
    }
    // 基本资料
    public function setting()
    {
        $data = input('post.');
        $instructor = new Instructor();
        $result = $instructor->allowField(true)->save($data, ['id'=>$data['id']]);

        if ($result) {
            echo "<script language=\"JavaScript\">\r\n";
            echo " alert(\"修改成功\");\r\n";
            echo " history.back();\r\n";
            echo "</script>";
        } else {
            echo "<script language=\"JavaScript\">\r\n";
            echo " alert(\"修改失败，信息未发生更改\");\r\n";
            echo " history.back();\r\n";
            echo "</script>";
        }
    }

    // 修改密码
    public function passwd()
    {
        $id = Request::instance()->post('id');
        $old_password = md5(Request::instance()->post('old_password'));
        $new_password = md5(Request::instance()->post('new_password'));
        $again_password = md5(Request::instance()->post('again_password'));
        $where = ['id' => $id];
        $data_id = Db::table('cq_instructor')->where($where)->find();
        if ($old_password == $data_id['password']) {
            if ($new_password == $again_password) {
                $result = Db::table('cq_instructor')
                    ->where([
                        'id'  => $id
                    ])
                    ->update([
                        'password' => $new_password
                    ]);
                echo "<script language=\"JavaScript\">\r\n";
                echo " alert(\"修改成功\");\r\n";
                echo " history.back();\r\n";
                echo "</script>";
            } else {
                echo "<script language=\"JavaScript\">\r\n";
                echo " alert(\"密码不一致\");\r\n";
                echo " history.back();\r\n";
                echo "</script>";
            }
        } else {
            echo "<script language=\"JavaScript\">\r\n";
            echo " alert(\"旧密码错误\");\r\n";
            echo " history.back();\r\n";
            echo "</script>";
        }
    }
}
