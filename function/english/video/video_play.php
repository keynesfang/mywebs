<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <link rel='stylesheet' type='text/css' href='../../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../../../lib/font-awesome-4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='../../../lib/video-js/css/video-js.min.css'>
    <link rel='stylesheet' type='text/css' href='../../../css/common.css'>
    <link rel='stylesheet' type='text/css' href='../css/english.css'>
    <script src='../../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../../lib/common.js'></script>
    <script src='../../../lib/video-js/js/video.min.js'></script>
    <script src='../../../lib/video_js_setting.js'></script>
    <title>English</title>
    <script>
        var player = "";
        var video_area = "";

        $(function () {
            video_area = $("#video_area");
            var title = GetQueryString("title");
            var poster = GetQueryString("poster");
            if (!title) {
                title = "何时坚持，何时放弃";
                poster = "1";
            }
            show_video("video_area", poster, "./resources/", true, "");
        });
    </script>
</head>
<body>
<div class="container-fluid">
    <div class='row'>
        <div id="video_area" class="col-md-12 px-0 align-content-center"></div>
    </div>
</div>
</body>
</html>
