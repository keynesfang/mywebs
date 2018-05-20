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
        .alphabet_size {
            font-size: 20px;
            min-width: 60px;
            height: 60px;
            line-height: 50px;
        }

        .li_line_height {
            margin-bottom: 10px;
        }
    </style>
    <script>
        var enlighten_course_index = 4;
        var enlighten_info_detail = [
            {tab_id: "tab0", tab_name: "目标", gen_html_func: get_tab0_content_html, content_html: ""},
            {tab_id: "tab1", tab_name: "教学", gen_html_func: get_tab1_content_html, content_html: ""},
            {tab_id: "tab2", tab_name: "练习", gen_html_func: get_tab2_content_html, content_html: ""},
            {
                tab_id: "tab3",
                tab_name: "视频",
                gen_html_func: get_tab3_content_html,
                content_html: "",
                onclick_html: "show_video(\"tab3\", 27, \"../video/resources/\", true, \"myTab\");"
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
                "<li class='li_line_height'>元音有哪些字母</li>" +
                "<li class='li_line_height'>元音有哪些特征</li>" +
                "<li class='li_line_height'>辅音有哪些特征</li>" +
                "<li class='li_line_height'>辅音有哪些特征</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "<h5><span class='badge badge-success'>1</span> 英文字母表（蓝色为元音）</h5><div class='row px-3'>";
            for (var i = 0; i < alphabet.length; i++) {
                var bg_style = "badge-secondary";
                if ($.inArray(alphabet[i], vowels) != -1) {
                    bg_style = "badge-primary";
                }
                html += "<div class='col-3 p-1 text-center'><span class='badge " + bg_style + " alphabet_size w-100' onclick='set_bg_color(this); play_sound(\"" + alphabet[i] + "\", \"play_sound\", set_bg_color, this);'>" + alphabet[i].toUpperCase() + "</span></div>";
            }
            html += "</div>";
            html += "<h5 class='mt-3'><span class='badge badge-success'>2</span> 元音的特征</h5>" +
                "<ul>" +
                "<li>当发元音时，声音可以很流畅无阻碍的从嘴里发出；</li>" +
                "<li>字母<code onclick='play_sound(\"y\", \"play_sound\");'> Y </code>有些情况也可以发出元音，所以有时有称为第6元音；</li>" +
                "<li>每个元音字母对应了多个发音。也就是一个元音的<code>名字音</code>对应了多个<code>音素音</code>；</li>" +
                "<li>元音字母在某些情况下也有可能保持沉没，也就是不发音。</li>" +
                "</ul>";
            html += "<h5 class='mt-3'><span class='badge badge-success'>3</span> 辅音的特征</h5>" +
                "<ul>" +
                "<li>当发辅音时，感觉总会被舌头，牙齿或嘴唇的位置所阻挡，不如元音那么流畅；</li>" +
                "<li>每个辅音字母，基本上就对应了1个发音。也就是一个辅音的<code>名字音</code>对应了一个<code>音素音</code>。</li>" +
                "</ul>";
            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var html = "<h5><span class='badge badge-primary'>1</span> 请选出以下字母中的元音</h5><div id='exercise_element' class='row px-3'>";
            html += get_random_letters_html(get_random_letters());
            html += "</div><div class='row d-flex justify-content-end m-0 mt-2 w-100'>";
            html += "<a class='btn btn-primary' href='#' onclick='redo_exercise();'>换一批</a></div>";
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

        function redo_exercise() {
            var html = get_random_letters_html(get_random_letters());
            $("#exercise_element").html(html);
        }

        function get_random_letters_html(letters) {
            var html = "";
            $.each(letters, function (idx, itm) {
                html += "<div class='col-3 p-1 text-center'><span onclick='check_exercise_answer(this);' class='exercise_letter badge badge-secondary alphabet_size w-100' style='line-height: 45px;'>" + itm + "</span></div>";
            });
            return html;
        }

        function check_exercise_answer(_this) {
            var element = $(_this);
            if ($.inArray(element.text().toLowerCase(), vowels) != -1) {
                $("#exercise_element").html("<span class='w-100 border-primary bg-info' style='line-height: 136px; text-align:center;'>答对啦！获得金奖杯 <i class='fa fa-trophy fa-2x' style='color:#e7d785;'></i> 一座！</span>");
            } else {
                if (element.hasClass("badge-secondary")) {
                    element.removeClass("badge-secondary");
                    element.addClass("badge-danger");
                }
            }
        }

        function get_random_letters() {
            var test_letters = [];
            var l_vowels = get_random_array(vowels);
            var l_consonants = get_random_array(consonants);
            test_letters.push(l_vowels[0]);
            for (let i = 0; i < 7; i++) {
                test_letters.push(l_consonants[i]);
            }
            test_letters = get_random_array(test_letters);
            return test_letters;
        }

        function set_bg_color(_this) {
            var original_style = "badge-secondary";
            var element = $(_this);
            if ($.inArray(element.text().toLowerCase(), vowels) != -1) {
                original_style = "badge-primary";
            }
            if (element.hasClass(original_style)) {
                element.removeClass(original_style);
                element.addClass("badge-success");
            } else {
                element.removeClass("badge-success");
                element.addClass(original_style);
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
