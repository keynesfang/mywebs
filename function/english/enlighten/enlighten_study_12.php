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
    <script src='../js/english.js'></script>
    <script src='./enlighten.js'></script>
    <link rel='stylesheet' type='text/css' href='../css/english.css'>
    <title>English</title>
    <style>
        .li_line_height {
            margin-bottom: 10px;
        }
    </style>
    <script>
        var enlighten_course_index = 12;
        var words = {
            peek: "e",
            greet: "e",
            vacuum: "u"
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
                onclick_html: "show_video(\"tab3\", 35, \"../video/resources/\", false, \"myTab\");"
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
                "<li class='li_line_height'>双元音单词规则</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "<h5><span class='badge badge-success'>1</span> 发音规则</h5>" +
                "<ul>" +
                "<li>当一个单词中的有双元音（两个相同字母的元音）时；</li>" +
                "<li>双元音发长元音；</li>" +
                "<li>如果双元音字母是<code class='sound_word'> O </code>时，则不遵循该规则。</li>" +
                "</ul>";
            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var html = "<h5 class='mb-3'><span class='badge badge-primary'>1</span> 先尝试发音再听记单词</h5>";
            $.each(words, function (word, key_letter) {
                html += show_word_for_tab1(word, key_letter);
            });
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

        function show_word_for_tab1(word, key_letter) {
            var html = "";
            var word_html = "";
            var letters = word.split("");
            var first_vowel_idx = "";
            $.each(letters, function (idx, letter) {
                if (letter == key_letter) {
                    word_html += "<code>" + letter + "</code>";
                    first_vowel_idx = idx;
                } else {
                    word_html += letter;
                }
            });
            html += "<div class='card w-100 bg-primary p-1 mt-1' style='max-width: 350px;' onclick='set_bg_color(this); play_sound(\"" + word + "\", \"play_sound\", set_bg_color, this);'>" +
                "<img class='card-img-top' src='../image/" + word + ".jpg'>" +
                "<div class='card-body p-0'>" +
                "<p class='card-text text-center'>" + "<kbd class='middle_font_size'>" + word_html + "</kbd></p>" +
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
