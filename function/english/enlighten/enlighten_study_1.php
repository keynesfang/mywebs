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
            line-height: 60px;
        }

        .li_line_height {
            margin-bottom: 10px;
        }
    </style>
    <script>
        var letter_count_per_page = 4; // 每页练习显示的字母数。
        var current_letter_index = 0; // 用于记录在练习时（顺序取字母时），当前的字母在alphabet数组中的下标。
        var enlighten_course_index = 1;
        var enlighten_info_detail = [
            {tab_id: "tab0", tab_name: "目标", gen_html_func: get_tab0_content_html, content_html: ""},
            {tab_id: "tab1", tab_name: "教学", gen_html_func: get_tab1_content_html, content_html: ""},
            {tab_id: "tab2", tab_name: "练习", gen_html_func: get_tab2_content_html, content_html: ""},
            {
                tab_id: "tab3",
                tab_name: "视频",
                gen_html_func: get_tab3_content_html,
                content_html: "",
                onclick_html: "show_video(\"tab3\", 23, \"../video/resources/\", false, \"myTab\");"
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
                "<li class='li_line_height'>学会<code>说</code>26个英文字母</li>" +
                "<li class='li_line_height'>学会<code>认</code>26个英文字母</li>" +
                "<li>能分清26个英文字母的大小写</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "<h5><span class='badge badge-success'>1</span> 点字母学发音</h5><div class='row px-3'>";
            for (var i = 0; i < alphabet.length; i++) {
                html += "<div class='col-3 p-1 text-center'><span class='badge badge-secondary alphabet_size w-100' onclick='set_bg_color(this); play_sound(\"" + alphabet[i] + "\", \"play_sound\", set_bg_color, this);'><ruby>" + alphabet[i].toUpperCase() + " " + alphabet[i] + "<rt>" + (i + 1) + "</tr></ruby></span></div>";
            }
            html += "</div>";
            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var letter_model = $("#letter_model").is(":checked");
            var exercise_letter_index = undefined;
            var random_checked = "";
            if (letter_model) {
                random_checked = "checked";
                exercise_letter_index = get_letter_index_by_random();
            } else {
                exercise_letter_index = get_letter_index_by_order();
            }
            var html = "<h5><span class='badge badge-primary'>1</span> 找出字母对应的大小写</h5><div id='exercise_element' class='row px-3' style='height: 136px;'>";

            var exercise_letter_array = [];
            for (var i = 0; i < letter_count_per_page; i++) {
                exercise_letter_array.push(alphabet[exercise_letter_index[i]]);
                exercise_letter_array.push(alphabet[exercise_letter_index[i]].toUpperCase());
            }
            // console.log(exercise_letter_array);
            exercise_letter_array = get_random_array(exercise_letter_array);
            $.each(exercise_letter_array, function (idx, itm) {
                html += "<div class='col-3 p-1 text-center'><span class='exercise_letter badge badge-secondary alphabet_size w-100' style='line-height: 45px;'>" + itm + "</span></div>";
            });
            html += "</div><div class='row d-flex justify-content-end mt-2 px-3'>";
            html += "<div class='form-check mt-2'><input type='checkbox' class='form-check-input' id='letter_model' " + random_checked + ">";
            html += "<label class='form-check-label' for='letter_model'>随机选取字母</label>";
            html += "</div>";
            html += "<a class='btn btn-primary ml-2' href='#' onclick='set_tab_content_html(2);'>换一批</a></div>";
            enlighten_info_detail[2].content_html = html;
        }

        function get_tab3_content_html() {
            enlighten_info_detail[2].content_html = "";
        }

        function set_tab_content_html(tab_index) {
            var tab_id = "tab" + tab_index;
            enlighten_info_detail[tab_index].gen_html_func();
            $("#" + tab_id).html(enlighten_info_detail[tab_index].content_html);
            if (tab_index == 2) { // tab为练习时
                $(".exercise_letter").click(function () {
                    if ($(this).hasClass("badge-secondary")) { // 由灰色，到绿色
                        var last_letter_element = "";
                        var last_select_letter = "";
                        $.each($(".badge-success"), function (idx, itm) {
                            // 如果代码执行到这里，表示本次点击为第2个绿色点击。
                            last_letter_element = $(itm);
                            last_select_letter = last_letter_element.text(); // 把之前已选择的字母进行赋值
                        });
                        if (last_select_letter == "") { // 如果之前的字母为空，则表示该次是第一次选择字母
                            $(this).removeClass("badge-secondary");
                            $(this).addClass("badge-success");
                        } else { // 进行2次选择的字母比较
                            var this_select_letter = $(this).text();
                            if (this_select_letter.toUpperCase() == last_select_letter.toUpperCase()) { // 两次选择的字母相同
                                $(this).parent().remove();
                                last_letter_element.parent().remove();
                                var exercise_element = $("#exercise_element");
                                if (exercise_element.html() == "") {
                                    exercise_element.html("<span class='w-100 border-primary bg-info' style='line-height: 136px; text-align:center;'>答对啦！获得金奖杯 <i class='fa fa-trophy fa-2x' style='color:#e7d785;'></i> 一座！</span>");
                                }
                            } else {
                                last_letter_element.removeClass("badge-success");
                                last_letter_element.addClass("badge-secondary");
                            }
                        }
                    } else {
                        $(this).removeClass("badge-success");
                        $(this).addClass("badge-secondary");
                    }
                });
            }
        }

        function set_bg_color(_this) {
            var element = $(_this);
            if (element.hasClass("badge-secondary")) {
                element.removeClass("badge-secondary");
                element.addClass("badge-success");
            } else {
                element.removeClass("badge-success");
                element.addClass("badge-secondary");
            }
        }

        function get_letter_index_by_random() {
            alphabet_index = get_random_array(alphabet_index);
            var letter_index_by_random = [];
            for (var i = 0; i < letter_count_per_page; i++) {
                letter_index_by_random.push(alphabet_index[i]);
            }
            return letter_index_by_random;
        }

        function get_letter_index_by_order() {
            var letter_index_by_order = [];
            for (var i = 0; i < letter_count_per_page; i++) {
                letter_index_by_order.push(current_letter_index);
                current_letter_index++;
                if (current_letter_index > 25) {
                    current_letter_index = 0;
                }
            }
            return letter_index_by_order;
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
