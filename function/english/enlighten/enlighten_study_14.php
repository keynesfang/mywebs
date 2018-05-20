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
        var enlighten_course_index = 14;
        var blend_letter = ["able", "augh", "bl", "br", "ch", "ci", "cial", "cian", "ck", "cl", "cr", "ct", "dge", "dis", "dr", "dw", "ed", "ex", "fl", "fr", "ft", "ful", "gh", "gl", "gr", "in", "ing", "ious", "kn", "ld", "le", "lf", "lk", "lm", "lp", "lt", "ly", "ment", "mis", "mp", "nce", "nch", "nd", "ng", "nk", "nse", "nt", "ough", "over", "ph", "pl", "pr", "psy", "pt", "re", "sc", "sh", "shr", "sk", "sl", "sm", "sn", "sp", "spr", "st", "str", "sw", "tch", "th", "thr", "tien", "tion", "tr", "ture", "tw", "un", "wh", "wr"];
        var words = {
            pool: "o",
            fool: "o",
            tool: "o",
            book: "o",
            door: "o"
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
                onclick_html: "show_video(\"tab3\", 37, \"../video/resources/\", false, \"myTab\");"
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
                "<li class='li_line_height'>了解混合字母的概念</li>" +
                "<li class='li_line_height'>记住常用的一些混合字母及发音</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "<h5><span class='badge badge-success'>1</span> 什么是混合字母</h5>" +
                "<ul>" +
                "<li>两个或两个以上的字母组合在一起；</li>" +
                "<li>这些组合在一起的字母以前缀或后缀的形式附加在单词上变成新的单词；</li>" +
                "<li>加上字母组合的新单词有不同的发音与含义。</li>" +
                "</ul>";
            html += "<h5><span class='badge badge-success'>2</span> 混合字母的发音特征</h5>" +
                "<ul>" +
                "<li>在混合字母中，通常你可以听到每个字母的发音；</li>" +
                "<li>如果有多个字母发一个音，我们称之为连字音；</li>" +
                "<li>一个混合字母的发音基本都是固定的，也就是在不同的单词中这几个混合字母的发音也是一样的。</li>" +
                "</ul>";
            html += "<h5><span class='badge badge-success'>3</span> 常见混合字母如下</h5><div id='exercise_element' class='row px-3'>" +
                "<ul><li>因某些混合需要结合单词才能发音，所以下面的混合字母未提供发音功能：</li></ul>" +
                get_blend_letter_html(blend_letter) + "</div>";
            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var html = "<h5 class='mb-3'><span class='badge badge-primary'>1</span> 听发音并记住以下单词</h5>";
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

        function get_blend_letter_html(blend_letter_arr) {
            var html = "";
            $.each(blend_letter_arr, function (idx, word) {
                html += "<div class='col-3 p-1 text-center'><span class='badge badge-secondary alphabet_size w-100' style='line-height: 45px;'>" + word + "</span></div>";
            });
            return html;
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
