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
        var enlighten_course_index = 6;
        var words = {
            middle_y: ["rhyme", "thyme", "symbol", "cymbal"],
            end_y: ["gray_发长元音A", "pay_发长元音A", "celery_发短元音E", "ugly_发短元音E", "cry_发长元音I", "pry_发长元音I"]
        };
        var enlighten_info_detail = [
            {tab_id: "tab0", tab_name: "目标", gen_html_func: get_tab0_content_html, content_html: ""},
            {tab_id: "tab1", tab_name: "教学", gen_html_func: get_tab1_content_html, content_html: ""},
            {tab_id: "tab2", tab_name: "练习", gen_html_func: get_tab2_content_html, content_html: ""},
            {
                tab_id: "tab3",
                tab_name: "视频",
                gen_html_func: get_tab3_content_html,
                content_html: "",
                onclick_html: "show_video(\"tab3\", 29, \"../video/resources/\", false, \"myTab\");"
            }
        ];
        $(function () {
            init_enlighten_study_page();
            for (var i = 0; i < enlighten_info_detail.length; i++) {
                set_tab_content_html(i);
            }
            regist_sound_word("play_sound");
        });

        function get_tab0_content_html() {
            var html = "" +
                "<ul class='m-0'>" +
                "<li class='li_line_height'>了解字母<code class='sound_word'> Y </code>可以发某些元音的音</li>" +
                "<li class='li_line_height'>记住字母<code class='sound_word'> Y </code>相关的一些单词</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "<h5><span class='badge badge-success'>1</span> 字母<code class='sound_word'> Y </code>的自述</h5>" +
                "<ul>" +
                "<li>有时字母<code class='sound_word'> Y </code>可以发<code class='sound_word'> A </code>、<code class='sound_word'> E </code>、<code class='sound_word'> I </code>的音，所以被称为第6元音字母；</li>" +
                "<li>字母<code class='sound_word'> Y </code>具体发什么音，通常根据它旁边的字母与所处单词的位置来决定。</li>" +
                "</ul>";
            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var html = "<h5 class='my-3'><span class='badge badge-primary'>1</span> 记一些<code class='sound_word'> Y </code>的单词</h5>" +
                "<ul class='nav nav-tabs' id='myTab' role='tablist'>" +
                "<li class='nav-item'><a class='nav-link active' data-toggle='tab' href='#middley' role='tab' aria-controls='home' aria-selected='true'>Y 在中间</a></li>" +
                "<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#endy' role='tab'>Y 在结尾</a></li>" +
                "</ul>" +
                "<div class='tab-content' id='myTabContent'>" +
                "<div class='tab-pane fade show active p-1' id='middley' role='tabpanel' aria-labelledby='home-tab'>" +
                show_word_for_tab1("middle_y") +
                "</div>" +
                "<div class='tab-pane fade show' id='endy' role='tabpanel' aria-labelledby='home-tab'>" +
                show_word_for_tab1("end_y") +
                "</div>" +
                "</div>";
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

        function show_word_for_tab1(word_type) {
            var html = "";
            $.each(words[word_type], function (idx, word) {
                var word_html = "";
                var word_info = word.split("_");
                word = word_info[0];
                var letters = word_info[0].split("");
                var explain = "";
                if (typeof(word_info[1]) !== "undefined") {
                    explain = word_info[1] + ":";
                }
                $.each(letters, function (idx, letter) {
                    if (letter.toUpperCase() == "Y") {
                        word_html += "<code>" + letter + "</code>";
                    } else {
                        word_html += letter;
                    }
                });
                html += "<div class='card w-100 bg-primary p-1 mt-1' style='max-width: 350px;' onclick='set_bg_color(this); play_sound(\"" + word + "\", \"play_sound\", set_bg_color, this);'>" +
                    "<img class='card-img-top' src='../image/" + word + ".jpg'>" +
                    "<div class='card-body p-0'>" +
                    "<p class='card-text text-center'><span style='position: absolute; left: 5px;'>" + explain + "</span>" + "<kbd class='middle_font_size'>" + word_html + "</kbd></p>" +
                    "</div>" +
                    "</div>";
            });
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
