<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' type='text/css' href='/lib/bootstrap-3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='/lib/font-awesome-4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='/css/common.css'>
    <script src='/lib/jquery-3.2.1.min.js'></script>
    <script src='/lib/popper.min.js'></script>
    <script src='/lib/bootstrap-3.3.7/js/bootstrap.min.js'></script>
    <script src='/lib/common.js'></script>
    <script src="/lib/form_operator.js"></script>
    <script>
        $(function () {
        });

        function add_event() {
            var data_arr = {};
            data_arr["title"] = $.trim($("#article_title").val());
            data_arr["article_date"] = $.trim($("#article_date").val());
            data_arr["tp"] = $.trim($("#article_type").val());
            data_arr["descript"] = ($("#article_discript").val());
            data_arr["content"] = ($("#editor").val());
            insertDataToDB("g_articles", data_arr, add_event_callback);
        }

        function load_event() {
            var id = $("#article_id").val();
            var sql = "select * from g_articles where id='" + id + "'";
            $.post("/function/common_logic.php", {
                type: "query_sql_get_data",
                sql: sql
            }, function (result) {
                var d = eval("(" + result + ")");
                $("#article_title").val(d[0].title);
                $("#article_date").val(d[0].article_date);
                $("#article_type").val(d[0].tp);
                $("#article_discript").val(d[0].descript);
                $("#editor").val(d[0].content);
                console.log(d);
            });
        }

        function modify_event() {
            var id = $("#article_id").val();
            var condition = "id='" + id + "'";
            var data_arr = {};
            data_arr["title"] = $.trim($("#article_title").val());
            data_arr["article_date"] = $.trim($("#article_date").val());
            data_arr["tp"] = $.trim($("#article_type").val());
            data_arr["descript"] = ($("#article_discript").val());
            data_arr["content"] = ($("#editor").val());

            $.post("/function/common_logic.php", {
                type: "modify_sql_get_data",
                tableName: "g_articles",
                fieldArr: data_arr,
                condition: condition
            }, function () {
                giveup();
            });
        }

        function add_event_callback() {
            giveup();
        }

        function giveup() {
            location.reload();
        }
    </script>
    <title>新增文章</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div>
                <div class="form-group">
                    <label for="happen_date">文章日期</label>
                    <input type="date" class="form-control" id="article_date">
                </div>
                <div class="form-group">
                    <label for="article_title">文章标题</label>
                    <input type="text" class="form-control" id="article_title" placeholder="建议10字以内概括事件">
                </div>
                <div class="form-group">
                    <label for="article_type">文章类型</label>
                    <select class="form-control" id="article_type">
                        <option value="热门话题">热门话题</option>
                        <option value="涨知识啦">涨知识啦</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="article_discript">文章描述</label>
                    <input type="text" class="form-control" id="article_discript">
                </div>
                <div class="form-group">
                    <label for="editor">文章链接</label>
                    <input type="text" class="form-control" id="editor">
                </div>
                <button class="btn btn-primary" style="float: right; margin-bottom: 20px;" onclick="add_event();">提交
                </button>
                <input type="text" id="article_id" style="width: 50px; height: 50px;">
                <button class="btn btn-primary" style="margin-bottom: 20px;" onclick="load_event();">加载</button>
                <button class="btn btn-primary" style="margin-bottom: 20px;" onclick="modify_event();">修改</button>
                <button class="btn btn-default" style="float: right; margin-right: 20px; margin-bottom: 20px;"
                        onclick="giveup();">放弃
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
