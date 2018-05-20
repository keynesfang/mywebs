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
    <script src='../../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../../lib/popper.min.js'></script>
    <script src='../../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../../lib/common.js'></script>
    <script src='../../../lib/video-js/js/video.min.js'></script>
    <script src='../../../lib/video_js_setting.js'></script>
    <script src='./enlighten.js'></script>
    <link rel='stylesheet' type='text/css' href='../css/english.css'>
    <title>English</title>
    <style>
        .li_line_height {
            margin-bottom: 10px;
        }
    </style>
    <script>
        var enlighten_course_index = 2;
        var enlighten_info_detail = [
            {tab_id: "tab0", tab_name: "目标", gen_html_func: get_tab0_content_html, content_html: ""},
            {tab_id: "tab1", tab_name: "教学", gen_html_func: get_tab1_content_html, content_html: ""},
            {tab_id: "tab2", tab_name: "练习", gen_html_func: get_tab2_content_html, content_html: ""},
            {
                tab_id: "tab3",
                tab_name: "视频",
                gen_html_func: get_tab3_content_html,
                content_html: "",
                onclick_html: "show_video(\"tab3\", 22, \"../video/resources/\", false, \"myTab\");"
            }
        ];
        $(function () {
            init_enlighten_study_page();
            for (var i = 0; i < enlighten_info_detail.length; i++) {
                set_tab_content_html(i);
            }
            regist_sound_word();
        });

        function get_tab0_content_html() {
            var html = "" +
                "<ul class='m-0'>" +
                "<li class='li_line_height'>学会唱视频中的儿歌</li>" +
                "<li class='li_line_height'>了解每个字母的基本发音</li>" +
                "<li class='li_line_height'>能发出简单单词的读音</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "" +
                "<h5><span class='badge badge-success'>1</span> 名字音</h5>" +
                "<p class='line_header_blank'>每个字母单独说时，有一个发音，这个音称之为字母的<code>名字音</code>。如：<kbd><span class='sound_word'>C</span></kbd>, <kbd><span class='sound_word'>A</span></kbd>, <kbd><span class='sound_word'>T</span></kbd>。</p>" +
                "<h5><span class='badge badge-success'>2</span> 音素音</h5>" +
                "<p class='line_header_blank'>字母组合起来说时，与单独说时发的单是不同的，这个音称之为字母的<code>音素音</code>。如：</span></p>" +
                get_show_word_html("cat") +
                "<h5 class='mt-4'><span class='badge badge-success'>3</span> 看视频学音素</h5>" +
                "<p class='line_header_blank'>通过观看与学唱视频中的动画内容，让孩子掌握每个字母对应的音素音是什么。</p>";
            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var html = "" +
                "<h5><span class='badge badge-primary'>1</span> 发出单词的读音</h5>" +
                "<p class='line_header_blank'>孩子学会每个字母对应的单词音后，让孩子尝试发出以下单词的读音</p>" +
                get_show_word_html("cat") + get_show_word_html("hat") + get_show_word_html("map") + get_show_word_html("ten") + get_show_word_html("send");
            enlighten_info_detail[2].content_html = html;
        }

        function get_tab3_content_html() {
            enlighten_info_detail[3].content_html = "";
        }

        function set_tab_content_html(tab_index) {
            var tab_id = "tab" + tab_index;
            enlighten_info_detail[tab_index].gen_html_func();
            $("#" + tab_id).html(enlighten_info_detail[tab_index].content_html);
        }

        function get_show_word_html(word) {
            var html = "<div class='card w-100 bg-primary p-1 mt-1' style='max-width: 350px;' onclick='set_bg_color(this); play_sound(\"" + word + "\", \"play_sound\", set_bg_color, this);'>" +
                "<img class='card-img-top' src='../image/" + word + ".jpg'>" +
                "<div class='card-body p-0'>" +
                "<p class='card-text text-center'><span style='position: absolute; left: 5px;'></span>" + "<kbd class='middle_font_size'>" + word + "</kbd></p>" +
                "</div>" +
                "</div>";
            return html;
        }

        function set_bg_color(_this) {
            var element = $(_this);
            if (element.hasClass("bg-primary")) {
                element.removeClass("bg-primary");
                element.addClass("bg-success");
            } else {
                element.removeClass("bg-success");
                element.addClass("bg-primary");
            }
        }
    </script>
</head>
<body>
<audio id="play_sound"></audio>
<nav id="enlighten_study_nav" aria-label="breadcrumb"></nav>
<div class="container-fluid mt-2 max_page_width">
    <div class="row">
        <div class="col-12 mb-3">
            <div id="page_content">
            </div>
        </div>
    </div>
</div>
</body>
</html>
