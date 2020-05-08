<?php

namespace app\index\controller;

use think\Db;
use think\Validate;
use \think\Request;
use \think\File;

class Record extends BaseController
{
    /**
     * 提交照片
     */
    public function uploadPhoto()
    {
        $parameter = array();
        $parameter = ['id', 'dorm_id', 'file'];
        foreach ($parameter as $key => $value) {
            if (!empty($_POST[$value]) || !empty($_FILES[$value])) {
            } else {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                return json($return_data);
            }
        }

        $user = Db('record')
            ->where(['id' => $_POST['id']])
            ->find();

        if (
            (strtotime(date('Y-m-d H:i:s', time())) < strtotime($user['start_time'])) //早于
            || (strtotime(date('Y-m-d H:i:s', time())) > strtotime($user['end_time'])) //晚于
        ) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '不在查寝时间！';
            return json($return_data);
        } else {
            $result = Db('dorm')
                ->field('dorm_id')
                ->alias('d')
                ->join('record r', 'r.dorm_id = d.id')
                ->join('student s', 's.id = d.student_id')
                ->find();

            $where = array();
            $where['id'] = $_POST['dorm_id'];
            $result = Db('dorm')
                ->where($where)
                ->find();

            if (!$result) {
                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = '您不在查寝名单中！';
                return json($return_data);
            }
        }

        $type = array("gif", "jpeg", "jpg", "png", "bmp");  // 允许上传的图片后缀
        $temp = explode(".", $_FILES['file']['name']);  // 拆分获取图片名
        $extension = $temp[count($temp) - 1];     // 获取文件后缀名

        if (in_array($extension, $type) && $_FILES["file"]["size"] < 5242880) {

            if ($_FILES["file"]["error"] > 0) {

                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = '文件上传错误！';
                return json($return_data);
            } else {
                $day = date('Y-m-d');
                $new_file_name = $day . '_' . $_POST['id'];
                $new_name = $new_file_name . '.' . $extension; //新文件名
                $path = 'upload/' . $new_name;        //upload为保存图片目录
                if (file_exists("upload/" . $path)) {   //判断是否存在该文件

                    $return_data = array();
                    $return_data['error_code'] = 4;
                    $return_data['msg'] = '文件已存在！';
                    return json($return_data);
                } else {
                    // 如果不存在该文件则将文件上传到 upload 目录下（将临时文件移动到 upload 下以新文件名命名）
                    // move_uploaded_file($_FILES['file']['tmp_name'], "upload/" . $day . '/' . $new_name);

                    //本地测试
                    $file = request()->file('file');
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'upload' . DS . $day, $new_name);
                    // print_r($info);

                    // 上传到数据库
                    $uploadTime = date('Y-m-d H:i:s', time());

                    $data = array('photo' => "upload/" . $day . '/' . $new_name, 'upload_time' => $uploadTime);
                    $result = Db('record')->where(['id' => $_POST['id']])->setField($data);

                    $return_data = array();
                    $return_data['error_code'] = 0;
                    $return_data['msg'] = '文件上传成功！';
                    $return_data['data']['id'] = $_POST['id'];
                    $return_data['data']['photo'] = 'upload/' . $day . '/' . $new_name;
                    $return_data['data']['upload_time'] = $uploadTime;
                    return json($return_data);
                }
            }
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '文件格式错误！';
            return json($return_data);
        }
    }

    /**
     * 上传头像
     */
    public function uploadFaceUrl()
    {
        $parameter = array();
        $parameter = ['id', 'file'];
        foreach ($parameter as $key => $value) {
            if (!empty($_POST[$value]) || !empty($_FILES[$value])) {
            } else {
                $return_data = array();
                $return_data['error_code'] = 1;
                $return_data['msg'] = '参数不足: ' . $value;
                return json($return_data);
            }
        }

        $type = array("gif", "jpeg", "jpg", "png", "bmp");  // 允许上传的图片后缀
        $temp = explode(".", $_FILES['file']['name']);  // 拆分获取图片名
        $extension = $temp[count($temp) - 1];     // 获取文件后缀名

        if (in_array($extension, $type) && $_FILES["file"]["size"] < 5242880) {

            if ($_FILES["file"]["error"] > 0) {
                $return_data = array();
                $return_data['error_code'] = 3;
                $return_data['msg'] = '文件上传错误！';
                return json($return_data);
            } else {
                $new_file_name = $_POST['id']; //取名为id
                $new_name = $new_file_name . '.' . $extension; //新文件名
                $path = 'face_url/' . $new_name;        //upload为保存图片目录
                if (file_exists("face_url/" . $path)) {   //判断是否存在该文件
                    $return_data = array();
                    $return_data['error_code'] = 4;
                    $return_data['msg'] = '文件已存在！';
                    return json($return_data);
                } else {

                    //本地测试
                    $file = request()->file('file');
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'face_url', $new_name);
                    // print_r($info);

                    // 上传到数据库
                    if (Db('student')->where(['id' => $_POST['id']])->find()) {
                        $result = Db('student')->where(['id' => $_POST['id']])->setField('face_url', "face_url/" . $new_name);
                    } else {
                        $result = Db('counselor')->where(['id' => $_POST['id']])->setField('face_url', "face_url/" . $new_name);
                    }
                    $return_data = array();
                    $return_data['error_code'] = 0;
                    $return_data['msg'] = '修改成功！';
                    $return_data['data']['id'] = $_POST['id'];
                    $return_data['data']['face_url'] = 'face_url/' . $new_name;
                    return json($return_data);
                }
            }
        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '文件格式错误！';
            return json($return_data);
        }
    }
}
