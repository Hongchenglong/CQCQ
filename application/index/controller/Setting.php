<?php


namespace app\index\controller;


use think\Db;
use app\index\model\Setting as settingModel;

class Setting extends BaseController
{
    public function wxapp() {
        $ret = Db::table('cq_setting')->where('key', 'wxapp')->find();
        $values = json_decode($ret['values'], true);
        $this->assign('values', $values);
        return $this->fetch();
    }
    public function face() {
        $ret = Db::table('cq_setting')->where('key', 'face')->find();
        $values = json_decode($ret['values'], true);
        $this->assign('values', $values);
        $this->assign('update_time', $ret['update_time']);
        return $this->fetch();
    }
    public function sms() {
        $ret = Db::table('cq_setting')->where('key', 'sms')->find();
        $values = json_decode($ret['values'], true);
        $this->assign('values', $values);
        return $this->fetch();
    }
    public function mail() {
        $ret = Db::table('cq_setting')->where('key', 'mail')->find();
        $values = json_decode($ret['values'], true);
        $this->assign('values', $values);
        return $this->fetch();
    }

    public function edit($key) {
        $values = input('post.');
        $data['values'] = json_encode($values);
        $data['update_time'] = date('Y-m-d H:i:s', time());
        $setting = new settingModel();
        $ret = $setting->allowField(true)->save($data, ['key'=>$key]);
        if ($ret) {
            echo "<script>alert(\"修改成功\");history.back();</script>";
        } else {
            echo "<script>alert(\"修改失败\");history.back();</script>";
        }
    }
    public function wxappEdit() {
        $this->edit('wxapp');
    }
    public function faceEdit() {
        $this->edit('face');
    }
    public function smsEdit() {
        $this->edit('sms');
    }
    public function mailEdit()
    {
        $this->edit('mail');
    }
}