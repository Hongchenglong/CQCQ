<?php

namespace app\index\controller;
use think\Db;
use think\Validate;
class Change
{
    /**
     * 修改信息
     */
    public function changeInfomation()
    {
        //实例化数据表
        $dorm = Db('dorm');
        $user = Db('user');

        //修改年级
        //验证规则（年级）
        $vgrade = new Validate([
           ['grade' , 'require|number' , '年级必须|年级必须是数字'],
        ]);

        //验证年级
        if(!$vgrade->check($_POST)){
            dump($vgrade->getError());
        }else{
            dump('Success!');
        };

        //更新年级
        $res = $dorm->where([
            'id' => 1
        ])->setField('grade', $_POST['grade']);
        dump($res);


        // 修改系
        // 验证规则（系）
        $vdepartment = new Validate([
           ['department' , 'require|max:32' , '系必须|系最多不能超过32字符'],
        ]);

        //验证系
        if(!$vdepartment->check($_POST)){
            dump($vdepartment->getError());
        }else{
            dump('Success!');
        };

        //更新系
        $res = $dorm->where([
            'id' => 1
        ])->setField('department',$_POST['department']);
        dump($res);


        // 修改宿舍号
        // 验证规则（宿舍号）
        $vdormNumber = new Validate([
           ['dormNumber' , 'require|max:16' , '宿舍号必须|宿舍号最多不能超过16字符'],
        ]);

        //验证宿舍号
        if(!$vdormNumber->check($_POST)){
            dump($vdormNumber->getError());
        }else{
            dump('Success!');
        };

        //更新宿舍号
        $res = $dorm->where([
            'id' => 1
        ])->setField('dormNumber',$_POST['dormNumber']);
        dump($res);
    }
}