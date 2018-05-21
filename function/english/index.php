<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='./css/english.css'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/popper.min.js'></script>
    <script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../lib/fullscreen.js'></script>
    <script src='../../lib/common.js'></script>
    <script>
        var g_full_screen = false;
        $(function () {
            var fulls = $("#fulls");
            fulls.click(function () {
                if (g_full_screen) {
                    exitFullscreen();
                } else {
                    fullscreen();
                }
                g_full_screen = !g_full_screen;
            });
            $(".url-link").click(function () {
                $(".navbar-toggler").click();
                $("#sub_frame").attr("src", $(this).attr("url-link"));
            });
            $("#sub_frame").css("padding-top", $("#nav_bar").outerHeight());
        });
    </script>
    <title>English</title>
</head>
<body id="screen">
<iframe id="sub_frame" src="enlighten/enlighten.php" class="border-0 w-100 h-100 fixed-top"
        style="overflow: auto;"></iframe>
<nav id="nav_bar" class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <!-- Navbar content -->
    <a class="navbar-brand" href="#">English</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li style="width: 60px;"></li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="enlighten" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    启蒙
                </a>
                <div class="dropdown-menu" aria-labelledby="enlighten">
                    <a class="dropdown-item url-link" href="#" url-link="./enlighten/enlighten.php">自然拼读法</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    视频
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item url-link" href="#" url-link="./video/video_list.php?type=grammar">英语语法</a>
                    <a class="dropdown-item url-link" href="#"
                       url-link="./video/video_list.php?type=pronunciation">英语发音</a>
                    <a class="dropdown-item url-link" href="#" url-link="./video/video_list.php?type=thinking">英语思维</a>
                    <a class="dropdown-item url-link" href="#"
                       url-link="./video/video_list.php?type=vocabulary">词汇拓展</a>
                    <a class="dropdown-item url-link" href="#"
                       url-link="./video/video_list.php?type=experience">英语杂谈</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item url-link" href="#" url-link="./video/video_list.php">全部视频</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    单词
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item url-link" href="#" url-link="./word/word_list.php?type=basic">基础词汇</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item url-link" href="#" url-link="./word/video_list.php">每日生词</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<button class="btn btn-secondary fixed-top" style="left: 90px;" onclick="top_page();">首页</button>
<!--<button id="fulls" class="btn btn-secondary fixed-top" style="left: 90px;">全屏</button>-->
</body>
</html>
