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
    <script src='../../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../../lib/popper.min.js'></script>
    <script src='../../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../../lib/common.js'></script>
    <link rel='stylesheet' type='text/css' href='../css/english.css'>
    <title>English</title>
    <script>
        $(function () {
            var type = GetQueryString("type");
            var sql = "select * from eng_video";
            if (type) {
                sql += " where kind = '" + type + "'";
            }
            $.post("../../common_logic.php", {
                type: "query_sql_get_data",
                sql: sql
            }, function (data) {
                var video_list = eval("(" + data + ")");
                var html = "";
                $.each(video_list, function (idx, itm) {
                    html += "" +
                        "<div class='col-md-4 px-0 mb-2'>" +
                        "<div class='card w-100' style='width: 18rem;'>" +
                        "<img class='card-img-top' src='./resources/" + itm.poster + ".png' alt='image'>" +
                        "<div class='card-body'>" +
                        "<h5 class='card-title'>" + itm.title + "</h5>" +
                        "<p class='card-text'>" + itm.abstract + "</p>" +
                        "<a href='#' class='btn btn-secondary'><i class='fa fa-thumbs-o-down fa-lg'></i> 200</a>" +
                        "<a href='#' class='btn btn-warning'><i class='fa fa-thumbs-o-up fa-lg'></i> 300</a>" +
                        "<a href='./video_play.php?title=" + itm.title + "&poster=" + itm.poster + "' class='btn btn-primary float-right'>播放</a>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                });
                $("#video_list").html(html);
            });
        });
    </script>
</head>
<body>
<div>
    <div class="container-fluid">
        <div id='video_list' class="row">

        </div>
    </div>
</div>
</body>
</html>
