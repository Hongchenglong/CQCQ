<?php

namespace app\api\controller;

class Record extends BaseController
{
    /**
     * 提交照片
     */
    public function uploadPhoto()
    {
        //$parameter = ['grade', 'department', 'dorm_num', 'rand_num', 'start_time', 'end_time', 'file'];
        // 输入判断

        if (empty($_POST['grade'])) {
            return json(['error_code' => 1, 'msg' => '请输入年级！']);
        } else if (empty($_POST['department'])) {
            return json(['error_code' => 1, 'msg' => '请输入系！']);
        } else if (empty($_POST['start_time'])) {
            return json(['error_code' => 1, 'msg' => '请输入开始时间！']);
        } else if (empty($_POST['end_time'])) {
            return json(['error_code' => 1, 'msg' => '请输入结束时间！']);
        } else if (empty($_FILES['file'])) {
            return json(['error_code' => 1, 'msg' => '请选择照片！']);
        } else if (empty($_POST['dorm_num'])) {
            return json(['error_code' => 1, 'msg' => '请输入宿舍号！']);
        } else if (empty($_POST['rand_num'])) {
            return json(['error_code' => 1, 'msg' => '请输入随机号！']);
        }
        // 查询条件
        $where = array();
        $where['grade'] = $_POST['grade'];
        $where['department'] = $_POST['department'];
        $where['dorm_num'] = $_POST['dorm_num'];
        $where['rand_num'] = $_POST['rand_num'];
        $where['grade'] = $_POST['grade'];
        $where['start_time'] = $_POST['start_time'];
        $where['end_time'] = $_POST['end_time'];

        $record = Db('record')
            ->alias('r')    // 别名
            ->field('r.id')
            ->join('dorm d', 'd.id = r.dorm_id')
            ->join('student s', 's.dorm = d.dorm_num')
            ->where($where)
            ->where('deleted', 0)
            ->find();

        if (!$record) {
            return json(['error_code' => 2, 'msg' => '没有您的查寝记录！']);
        }

        $type = array("gif", "jpeg", "jpg", "png", "bmp");  // 允许上传的图片后缀
        $temp = explode(".", $_FILES['file']['name']);  // 拆分获取图片名
        $extension = $temp[count($temp) - 1];     // 获取文件后缀名
        if (in_array($extension, $type) && $_FILES["file"]["size"] < 5242880) {
            if ($_FILES["file"]["error"] > 0) {
                return json(['error_code' => 4, 'msg' => '文件上传错误！']);
            } else {
                $day = date('Y-m-d');
                $new_file_name = $day . '_' . $record['id'] . '_' . $_POST['rand_num'] . '_' . rand(1000, 10000);
                $new_name = $new_file_name . '.' . $extension; //新文件名
                $path = 'upload/' . $new_name;        //upload为保存图片目录
                if (file_exists("upload/" . $path)) {   //判断是否存在该文件
                    return json(['error_code' => 5, 'msg' => '文件已存在！']);
                } else {
                    // 如果不存在该文件则将文件上传到 upload 目录下（将临时文件移动到 upload 下以新文件名命名）
                    // move_uploaded_file($_FILES['file']['tmp_name'], "upload/" . $day . '/' . $new_name);

                    $where = array();
                    $where['grade'] = $_POST['grade'];
                    $where['department'] = $_POST['department'];
                    $where['dorm_num'] = $_POST['dorm_num'];
                    $where['rand_num'] = $_POST['rand_num'];
                    $where['grade'] = $_POST['grade'];
                    $where['start_time'] = $_POST['start_time'];
                    $where['end_time'] = $_POST['end_time'];

                    $photo = Db('record')
                        ->alias('r')    // 别名
                        ->field('r.photo')
                        ->join('dorm d', 'd.id = r.dorm_id')
                        ->join('student s', 's.dorm = d.dorm_num')
                        ->where($where)
                        ->where('deleted', 0)
                        ->find();

                    if (!empty($photo['photo'])) {
                        unlink($photo['photo']);  // 删除服务器上的照片
                    }

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
            return json(['error_code' => 6, 'msg' => '文件格式错误！']);
        }
    }
}
