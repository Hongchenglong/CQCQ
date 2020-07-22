<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"E:\phpstudy_pro\WWW\CQCQ\back_end\public/../application/index\view\welcome\test.html";i:1595314584;}*/ ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>TEST</title>
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1"
    />
    <link rel="stylesheet" href="/cqcq/back_end/public/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/cqcq/back_end/public/css/public.css" media="all">
    <style>
      .all {
        margin-left: 25px;
        background-color: white;
        width: 1040px;
        border: 1px solid lightgray;
        border-radius: 10px;
        padding: 15px 20px;
      }
      td.hide {
        display: none;
      }
    </style>
  </head>

  <body>
    <div class="all">
      <ul class="layui-timeline" name="records"></ul>
    </div>

    <script
      src="/cqcq/back_end/public/lib/layui-v2.5.5/layui.js"
      charset="utf-8"
    ></script>
    <script src="/cqcq/back_end/public/lib/jquery-3.4.1/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
      layui.use(["jquery", "laypage"], function () {
        var $ = layui.jquery;
        var laypage = layui.laypage;

        $.ajax({
          type: "POST",
          url: "index.php?s=index/welcome/test_time",
          async: false,
          success: function (msg) {
            let bd = document.getElementsByName("records")[0];

            if (msg.count == 0) {
              let li = document.createElement("li");
              let i = document.createElement("i");
              let div1 = document.createElement("div");
              let div2 = document.createElement("div");

              li.className = "layui-timeline-item";
              i.className = "layui-icon layui-timeline-axis";
              div1.className = "layui-timeline-content layui-text";
              div2.className = "layui-timeline-title";

              i.innerHTML = "&#xe63f;";
              div2.innerHTML = msg.data;

              div1.appendChild(div2);
              li.appendChild(i);
              li.appendChild(div1);
              bd.appendChild(li);
              
            } else {
              for (var k = 0; k < msg.count; k++) {
                let li = document.createElement("li");
                let i = document.createElement("i");
                let div1 = document.createElement("div");
                let div2 = document.createElement("div");

                li.className = "layui-timeline-item";
                i.className = "layui-icon layui-timeline-axis";
                div1.className = "layui-timeline-content layui-text";
                div2.className = "layui-timeline-title";

                i.innerHTML = "&#xe63f;";
                div2.innerHTML =
                  msg.data[k].start_time +
                  " ~ " +
                  msg.data[k].end_time.split(" ")[1];

                $.ajax({
                  type: "POST",
                  url: "index.php?s=index/welcome/test_dorm",
                  async: false,
                  data: {
                    start_time: msg.data[k].start_time,
                    end_time: msg.data[k].end_time,
                  },
                  success: function (msg) {
                    console.log(msg);

                    let table = document.createElement("table");
                    let thead = document.createElement("thead");
                    let tr = document.createElement("tr");
                    let th1 = document.createElement("th");
                    let th2 = document.createElement("th");
                    let th3 = document.createElement("th");

                    table.className = "layui-table";
                    table.id = "table1";

                    th1.innerHTML = "宿舍";
                    th2.innerHTML = "学号";
                    th3.innerHTML = "签到情况";

                    tr.appendChild(th1);
                    tr.appendChild(th2);
                    tr.appendChild(th3);
                    thead.appendChild(tr);
                    table.appendChild(thead);
                    div2.appendChild(table);

                    for (var m = 0; m < msg.count; m++) {
                      let tr = document.createElement("tr");
                      let td2 = document.createElement("td");
                      let td3 = document.createElement("td");

                      var c = 1;
                      for (var n = m + 1; n < msg.count; n++) {
                        if (msg.data[m].dorm_num == msg.data[n].dorm_num) {
                          c++;
                          msg.data[n].dorm_num = "same";
                        }
                      }

                      if (msg.data[m].dorm_num != "same") {
                        let td1 = document.createElement("td");
                        td1.innerHTML = msg.data[m].dorm_num;
                        td1.rowSpan = c;
                        tr.appendChild(td1);
                        td1.style.fontWeight = "normal";
                      }

                      td2.innerHTML = msg.data[m].id;
                      if (msg.data[m].sign == 0) {
                        td3.innerHTML = "未签到";
                        td3.style.color = "red";
                      } else {
                        td3.innerHTML = "已签到";
                        td3.style.color = "#46A9FF";
                      }

                      td2.style.fontWeight = "normal";
                      td3.style.fontWeight = "normal";

                      tr.appendChild(td2);
                      tr.appendChild(td3);
                      table.appendChild(tr);
                    }
                  },
                });
                div1.appendChild(div2);
                li.appendChild(i);
                li.appendChild(div1);
                bd.appendChild(li);
              }
            }
          },
        });
      });
    </script>
  </body>
</html>
