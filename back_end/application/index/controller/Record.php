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
        //$parameter = ['grade', 'department', 'dorm_id', 'file'];
        // 输入判断
        if (empty($_POST['dorm_id'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入宿舍id！';
            return json($return_data);
        } else if (empty($_FILES['file'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请选择照片！';
            return json($return_data);
        } else if (empty($_POST['grade'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入年级！';
            return json($return_data);
        } else if (empty($_POST['department'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入系！';
            return json($return_data);
        }

        // 先找到本系、本年级的id最大的开始时间和结束时间
        $recentId = Db('record')
            ->alias('r')    // 别名
            ->field('r.start_time, r.end_time')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where(['grade' => $_POST['grade'], 'department' => $_POST['department']])
            ->order('r.id desc')
            ->find();

        // 判断该用户宿舍是否存在该时间段
        $record = Db('record')
            ->field('r.id, r.dorm_id')
            ->alias('r')    // 别名
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.id = d.student_id')
            ->where([
                'grade' => $_POST['grade'], 'department' => $_POST['department'],
                'start_time' => $recentId['start_time'], 'end_time' => $recentId['end_time'],
                'r.dorm_id' => $_POST['dorm_id']
            ])
            ->select();

        if (
            (strtotime(date('Y-m-d H:i:s', time())) < strtotime($recentId['start_time'])) //早于
            || (strtotime(date('Y-m-d H:i:s', time())) > strtotime($recentId['end_time'])) //晚于
        ) {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '不在查寝时间！';
            return json($return_data);
        } else {
            if (!$record) {
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
                $return_data['error_code'] = 4;
                $return_data['msg'] = '文件上传错误！';
                return json($return_data);
            } else {
                $day = date('Y-m-d');
                $new_file_name = $day . '_' . $_POST['dorm_id'];
                $new_name = $new_file_name . '.' . $extension; //新文件名
                $path = 'upload/' . $new_name;        //upload为保存图片目录
                if (file_exists("upload/" . $path)) {   //判断是否存在该文件

                    $return_data = array();
                    $return_data['error_code'] = 5;
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
                    $result = Db('record')->where(['id' => $record['id']])->setField($data);

                    $return_data = array();
                    $return_data['error_code'] = 0;
                    $return_data['msg'] = '文件上传成功！';
                    $return_data['data']['id'] = $record['id'];
                    $return_data['data']['photo'] = 'upload/' . $day . '/' . $new_name;
                    $return_data['data']['upload_time'] = $uploadTime;
                    return json($return_data);
                }
            }
        } else {
            $return_data = array();
            $return_data['error_code'] = 6;
            $return_data['msg'] = '文件格式错误！';
            return json($return_data);
        }
    }

    /**
     * 上传头像
     */
    public function uploadFaceUrl()
    {
        // $parameter = ['id', 'file'];
        // 输入判断
        if (empty($_POST['id'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请输入id！';
            return json($return_data);
        } else if (empty($_FILES['file'])) {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '请选择照片！';
            return json($return_data);
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
