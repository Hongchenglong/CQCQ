<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\phpstudy_pro\WWW\CQCQ\public/../application/index\view\record\notsigned.html";i:1625986745;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>CQCQ</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/cqcq/public/static/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/cqcq/public/static/css/public.css" media="all">
    <style>
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
    <div class="layuimini-container">
        <div class="layuimini-main">

            <script type="text/html" id="toolbarDemo">
      
        </script>

            <table class="layui-hide" id="testReload" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
            <a class="layui-btn layui-btn-normal layui-btn-warm layui-btn-xs" 
            style="text-align: center;" lay-event="sign">已签</a>
        </script>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------------------------- -->
    <script src="/cqcq/public/static/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>

    <script>

        layui.use(['form', 'table', 'upload'], function () {

            var $ = layui.jquery,
                form = layui.form,
                table = layui.table,
                upload = layui.upload;

            layer.msg("上一次查寝的未签名单");
            
            // 获取屏幕的宽度
            var documentWidth = $(document).width();  
            //用全局变量存放当前表格中的全部数据
            var table_data = new Array();
            // 存放每页多少个数据
            var table_limit = '';

            table.render({
                elem: '#testReload',
                id: 'testReload',
                url: '/cqcq/public/index.php/index/Record/notSignedList',
                toolbar: '#toolbarDemo',
                defaultToolbar: ['filter', 'exports', 'print', {
                    title: '提示',
                    layEvent: 'LAYTABLE_TIPS',
                    icon: 'layui-icon-tips'
                }],
                cols: [[
                    // { type: "checkbox", width: documentWidth * 50 / 1200 },
                    { field: "id", title: '学号', width: documentWidth * 120 / 1200, sort: true },
                    { field: 'username', width: documentWidth * 100 / 1200, title: '姓名' },
                    { field: 'sex', width: documentWidth * 85 / 1200, title: '性别', sort: true, align: "center" },
                    { field: 'dorm_num', width: documentWidth * 115 / 1200, title: '宿舍', sort: true },
                    { field: 'phone', width: documentWidth * 110 / 1200, title: '手机号' },
                    { field: 'start_time', width: documentWidth * 170 / 1200, title: '开始时间', sort: true },
                    { field: 'end_time', width: documentWidth * 170 / 1200, title: '结束时间', sort: true },
                    { field: 'sign', width: documentWidth * 100 / 1200, title: '签到状态', align: "center"},
                    { field: 'record_id', width: documentWidth * 100 / 1200, hide: true},
                    { title: '操作', maxWidth: documentWidth * 100 / 1200, toolbar: '#currentTableBar', align: "center"}
                ]],
                limits: [3, 5, 10, 20],
                limit: 10,
                page: true,  //开启分页
                first: "首页", //显示首页
                last: "尾页", //显示尾页
                totalRow: true,
                parseData: function (res) { //将原始数据解析成 table 组件所规定的数据，res为从url中get到的数据
                    var result;
                    table_data = res.data;//设置全部数据到全局变量
                    table_limit = this.limit //获取每页多少个数据
                    if (this.page.curr) {
                        result = res.data.slice(this.limit * (this.page.curr - 1), this.limit * this.page.curr);
                    }
                    else {
                        result = res.data.slice(0, this.limit);
                    }
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.msg, //解析提示文本
                        "count": res.count, //解析数据长度
                        "data": result //解析数据列表
                    };
                }
            });

            table.on('tool(currentTableFilter)', function (obj) {
               if (obj.event === 'sign') {
                    layer.confirm('确定消除该学生的未签到记录吗？', function (index) {
                        obj.del();
                        layer.close(index);
                        var student_id = JSON.stringify(obj.data.id);
                        var record_id = JSON.stringify(obj.data.record_id);
                        window.location = "index.php?s=index/record/sign&student_id=" + student_id + "&record_id=" + record_id;
                    });
                }
            });
        });

    </script>

</body>

</html>