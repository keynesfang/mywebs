<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'>
    <script src="../../lib/jquery-3.2.1.min.js"></script>
    <script src="../../lib/common.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/interview.css">
    <title>面试</title>
    <script>
        $(function () {
            windowSizeChange("body", 20);
        });
        function login() {
            var user = $("#username").val();
            $.post("../common_logic.php", {
                type: "login",
                user: user
            }, function(result)
            {
                if(result == "success")
                {
                    window.location.href='./index.php';
                }
                else
                {
                    $("#username").val("");
                    $("#username").attr("placeholder", "非法人员");
                    $("#username").addClass("input_err");
                }
            });
        }
    </script>
</head>
<body id="body">
<div data-role="page" style="text-align: center; margin-top: 20%;">
    <h1>人员面试</h1>
    <input type="text" name="username" id="username" placeholder="使用人员" style="width: 80%; padding: 10px; box-sizing: border-box; margin-top: 20px;" /><br>
    <button onclick="login();" style="width: 80%; padding: 10px; border: 2px solid #fff; background-color: #00BBFF; margin: 20px; color: #fff;">进入系统</button>
    <button onclick="top_page();" style="width: 80%; padding: 10px; border: 2px solid #fff; background-color: #00BBFF; margin: 20px; color: #fff;">返回首页</button>
</div>
<div style="position: absolute; bottom: 20px; text-align: center; width: 100%; font-size: 14px;">
    -- 版本：1.0 --
</div>
</body>
</html>
