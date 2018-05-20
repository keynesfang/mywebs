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
        var exercise_words = ["cat", "hat", "rat", "want", "set", "sit", "dog", "note", "bear", "ape", "free", "room", "full", "fool", "beer", "good", "test", "need"];
        var enlighten_course_index = 3;
        var enlighten_info_detail = [
            {tab_id: "tab0", tab_name: "目标", gen_html_func: get_tab0_content_html, content_html: ""},
            {tab_id: "tab1", tab_name: "教学", gen_html_func: get_tab1_content_html, content_html: ""},
            {tab_id: "tab2", tab_name: "练习", gen_html_func: get_tab2_content_html, content_html: ""},
            {
                tab_id: "tab3",
                tab_name: "视频",
                gen_html_func: get_tab3_content_html,
                content_html: "",
                onclick_html: "show_video(\"tab3\", 24, \"../video/resources/\", false, \"myTab\");"
            }
        ];
        $(function () {
            init_enlighten_study_page();
            for (var i = 0; i < enlighten_info_detail.length; i++) {
                set_tab_content_html(i);
            }
        });

        function get_tab0_content_html() {
            var html = "" +
                "<ul class='m-0'>" +
                "<li class='li_line_height'>知道单词是由字母组成的</li>" +
                "<li class='li_line_height'>知道字母可以在单词中的不同位置</li>" +
                "<li class='li_line_height'>知道字母在单词中是可以重复的</li>" +
                "<li class='li_line_height'>知道不是任意字母组合都能成为单词</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "" +
                "<h5><span class='badge badge-success'>1</span> 字母组成单词</h5>" +
                "<p class='line_header_blank'>当把某些字母组合在一起时，就可以变成一个单词，比如：</p>" +
                get_show_word_html("cat", "", "", true) + get_show_word_html("dog", "", "", true) +
                "<h5><span class='badge badge-success'>2</span> 字母在词中的位置</h5>" +
                "<p class='line_header_blank'>同一个字母在不同单词中的位置可以是不一样的。单词的开头，中间或结尾都是有可能的。比如：</p>" +
                get_show_word_html("ape", "a", "") + get_show_word_html("cat", "a", "cat2") + get_show_word_html("zebra", "a") +
                "<h5><span class='badge badge-success'>3</span> 字母是可以重复的</h5>" +
                "<p class='line_header_blank'>同一个字母一个单词中是有可能出现多次的。比如：</p>" +
                get_show_word_html("clock", "c", "") + get_show_word_html("airplane", "a", "") +
                "<h5><span class='badge badge-success'>4</span> 错误的字母组合</h5>" +
                "<p class='line_header_blank'>不是所有的字母组合都是一个正确的单词。比如：【aaa】。所以我们要去记忆那些有意义的单词。</p>";

            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var html = "" +
                "<h5><span class='badge badge-primary'>1</span> 找出单词中的第一个字母</h5>" +
                "<span id='exercise_first_letter'>" + get_exercise_1_html("first_letter") + "</span>" +
                "<h5 class='mt-5'><span class='badge badge-primary'>2</span> 找出单词中的最后一个字母</h5>" +
                "<span id='exercise_last_letter'>" + get_exercise_1_html("last_letter") + "</span>" +
                "<h5 class='mt-5'><span class='badge badge-primary'>3</span> 找出单词中有重复的字母</h5>" +
                "<span id='exercise_repeat_letter'>" + get_exercise_1_html("repeat_letter") + "</span>";
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

        function get_exercise_1_html(exercise_type) {
            var word_index = parseInt((exercise_words.length - 1) * Math.random());
            var word = exercise_words[word_index];
            var answer_id = exercise_type + "answer";
            var result_id = exercise_type + "result";
            var letters = word.split("");
            var answer = letters[0];
            if (exercise_type == "last_letter") {
                answer = letters[letters.length - 1];
            }
            var result = get_unique_array(letters);
            letters = result[0];
            if (exercise_type == "repeat_letter") {
                answer = "-";
                if (result[1].length > 0) {
                    answer = result[1][0];
                } else { // 当前单词没有重复的字母时
                    letters.push(answer); // 把 "-" 放入字母数组中，作为一个选择项输出
                }
            }
            letters = get_random_array(letters);
            var html = "<p class='line_header_blank'>单词： <code id='" + answer_id + "' answer='" + answer + "' class='middle_font_size'>" + word + "</code></p><p class='line_header_blank'>选项： ";
            $.each(letters, function (idx, letter) {
                html += (idx + 1) + ". <kbd class='mr-2 middle_font_size' onclick='do_exercise(this, \"" + exercise_type + "\");'>" + letter + "</kbd>";
            });
            html += "</p>";
            html += "<p id='" + result_id + "'></p>";
            return html;
        }

        function do_exercise(_this, exercise_type) {
            var answer = $(_this).text();
            var right_answer = $("#" + exercise_type + "answer").attr("answer");
            var result_html = " <button class='btn btn-success d-inline' onclick='do_exercise_again(\"" + exercise_type + "\");'>再来一次</button></div>";
            if (answer == right_answer) {
                result_html = "<div class='line_header_blank'>好棒！获得 <i class='fa fa-trophy fa-2x d-inline' style='color:#e7d785;'></i> 一座！" + result_html;
            } else {
                result_html = "<div class='line_header_blank'>抱歉！获得 <i class='fa fa-remove fa-2x d-inline' style='color:red;'></i> 一个！" + result_html;
            }
            $("#" + exercise_type + "result").html(result_html);
        }

        function do_exercise_again(exercise_type) {
            var html = get_exercise_1_html(exercise_type);
            $("#exercise_" + exercise_type).html(html);
        }

        function get_show_word_html(word, key_letter, img, show_letter) {
            var letters = word.split("");
            var html = "<p class='line_header_blank'>";
            var _word = "";
            $.each(letters, function (idx, letter) {
                var text_class = "middle_font_size ";
                if (key_letter == letter) {
                    text_class += "text-danger";
                    _word += "<span onclick='play_sound(\"" + letter + "\", \"play_sound\");'  class='text-danger'>" + letter + "</span>";
                } else {
                    _word += letter;
                }
                if (show_letter) {
                    html += "<kbd onclick='play_sound(\"" + letter + "\", \"play_sound\");' class='" + text_class + "'>" + letter + "</kbd>";
                    if (idx < letters.length - 1) {
                        html += " + "
                    }
                }
            });
            if (show_letter) {
                html += " = ";
            }
            html += "<kbd class='middle_font_size' onclick='play_sound(\"" + word + "\", \"play_sound\");'>" + _word + "</kbd></p>";
            if (typeof(img) != "undefined" && img != "") {
                word = img;
            }
            html += "<p><img class='word_image w-100' src='../image/" + word + ".jpg' height='150'>";
            return html;
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
