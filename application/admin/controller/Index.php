<?php


namespace app\admin\controller;
use app\admin\model\Instructor;
use think\Controller;
use think\Session;

class Index extends Controller
{
    public function login()
    {
        return $this->fetch();
    }

    public function index()
    {
        return $this->fetch();
    }

    // 检查登录表单
    public function check() {
        $data = input('post.');
        $instructor = new Instructor();
        $result = $instructor->where('id', $data['id'])->find();

        if ($result) {
            if ($result['password'] === md5($data['password'])) {
                Session::set('id', $data['id']);
                Session::set('username', $data['username']);
                Session::set('password', $data['password']);
                Session::set('grade', $data['grade']);
                Session::set('department', $data['department']);
            } else {
                // 密码错误
                $this->error('学工号或密码错误');
                exit();
            }
        } else {
            // 用户不存在
            $this->error('学工号或密码错误');
            exit();
        }
        $this->redirect('Index/index');
    }

    //用户退出登录的方法
    public function logout()
    {
        session(null); // 清空session
//        $this->redirect("/cqcq/public/index.php/admin/index/login");
        $this->redirect('admin/Index/login');
    }
}