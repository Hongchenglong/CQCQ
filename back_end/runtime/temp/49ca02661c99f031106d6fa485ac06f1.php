<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpstudy_pro\WWW\CQCQ\back_end\public/../application/index\view\table\add.html";i:1595413180;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/cqcq/back_end/public/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/cqcq/back_end/public/css/public.css" media="all">
    <style>
        body {
            background-color: #ffffff;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <meta charset="UTF-8">
    <form class="layui-form layuimini-form" action="index.php?s=index/table/add_user" method="post"
        enctype="multipart/form-data">
        <div class="layui-form-item">
            <label class="layui-form-label required">学号</label>
            <div class="layui-input-block">
                <input type="number" name="id" lay-verify="required" lay-reqtext="学号不能为空" placeholder="请输入学号" value=""
                    class="layui-input" style="width: 65%;" oninput="if(value.length>9)value=value.slice(0,2)">
                <!-- <tip>填写宿舍号。</tip> -->
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="男" title="男" checked="">
                <input type="radio" name="sex" value="女" title="女">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="username" lay-verify="required" lay-reqtext="用户名不能为空" placeholder="请输入用户名"
                    value="" class="layui-input" style="width: 65%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" lay-verify="required" lay-reqtext="密码不能为空" placeholder="请输入密码"
                    value="" class="layui-input" style="width: 65%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="email" name="email" placeholder="请输入邮箱" value="" class="layui-input" style="width: 65%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-block">
                <input type="number" name="phone" placeholder="请输入手机号码" value="" class="layui-input"
                    style="width: 65%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">年级</label>
            <div class="layui-input-block">
                <input type="number" name="grade" lay-verify="required" lay-reqtext="年级不能为空" placeholder="请输入年级"
                    value="" class="layui-input" style="width: 65%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">系别</label>
            <div class="layui-input-block">
                <input type="text" name="department" lay-verify="required" lay-reqtext="系别不能为空" placeholder="请输入系别"
                    value="" class="layui-input" style="width: 65%;">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label required">宿舍号</label>
            <div class="layui-input-block">
                <input type="text" name="dorm" lay-verify="required" lay-reqtext="宿舍号不能为空" placeholder="请输入宿舍号" value=""
                    class="layui-input" style="width: 65%;">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn"
                    style="margin-left: 30%;">确认添加</button>
            </div>
        </div>
    </form>
    <script src="/cqcq/back_end/public/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
    <script>
        layui.use(['form'], function () {
            var form = layui.form,
                layer = layui.layer,
                $ = layui.$;

            //监听提交
            form.on('submit(saveBtn)', function (data) {
                var index = layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                }, function () {
                    // 关闭弹出层
                    layer.close(index);
                    var iframeIndex = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(iframeIndex);
                });

                // return false;  // 不提交
            });

        });
    </script>
</body>

</html>