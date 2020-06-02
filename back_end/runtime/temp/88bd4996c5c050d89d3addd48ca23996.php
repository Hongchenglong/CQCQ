<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"E:\phpstudy_pro\WWW\CQCQ\back_end\public/../application/index\view\user\user_password.html";i:1594364403;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>修改密码</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/cqcq/back_end/public/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/cqcq/back_end/public/css/public.css" media="all">
    <style>
        .layui-form-item .layui-input-company {
            width: auto;
            padding-right: 10px;
            line-height: 38px;
        }
    </style>
</head>

<body>
    <div class="layuimini-container" style="height:310px;">
        <div class="layuimini-main">
            <form class="layui-form layuimini-form " action="index.php?s=index/user/passwd" method="post"
                enctype="multipart/form-data">

                <div class="layui-form layuimini-form">
                    <div style="font-size:5px;visibility:hidden" >
                        <label class="layui-form-label">管理账号</label>
                        <div class="layui-input-block">
                            <input type="text" name="id" value="" class="layui-input" readonly="readonly"
                                style="width: 65%; border: none;">

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">旧的密码</label>
                        <div class="layui-input-block">
                            <input type="password" name="old_password" lay-verify="required" lay-reqtext="旧的密码不能为空"
                                placeholder="请输入旧的密码" value="" class="layui-input" style="width:50%">
                            <tip>填写自己账号的旧的密码。</tip>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label required">新的密码</label>
                        <div class="layui-input-block">
                            <input type="password" name="new_password" lay-verify="required" lay-reqtext="新的密码不能为空"
                                placeholder="请输入新的密码" value="" class="layui-input" style="width:50%">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label required">新的密码</label>
                        <div class="layui-input-block">
                            <input type="password" name="again_password" lay-verify="required" lay-reqtext="新的密码不能为空"
                                placeholder="请输入新的密码" value="" class="layui-input" style="width:50%">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="saveBtn">确认保存</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/cqcq/back_end/public/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
    <script src="/cqcq/back_end/public/js/lay-config.js?v=1.0.4" charset="utf-8"></script>
    <script>
        var user = window.localStorage.name;
        document.getElementsByName("id")[0].value = user;
        layui.use(['form', 'miniTab'], function () {
            var form = layui.form,
                layer = layui.layer,
                miniTab = layui.miniTab;

            // 监听提交
            form.on('submit(saveBtn)', function (data) {
                var index = layer.alert(JSON.stringify(data.field), {
                    title: '最终的提交信息'
                }, function () {
                    layer.close(index);
                    miniTab.deleteCurrentByIframe();
                });
            });

        });   
    </script>
</body>

</html>