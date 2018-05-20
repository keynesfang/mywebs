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
        var temp_words = [];
        var vowel_type = ["长元音", "短元音"];
        var words = {
            a: {
                "长元音": ["ape", "lake", "gate"],
                "短元音": ["apple", "axe", "sack"]
            },
            e: {
                "长元音": ["eat", "eel", "feet"],
                "短元音": ["echo", "nest", "egg"]
            },
            i: {
                "长元音": ["ice", "kite", "bite"],
                "短元音": ["insect", "bird", "panic"]
            },
            o: {
                "长元音": ["oak", "lonely", "potatoes"],
                "短元音": ["mop", "off", "ostrich"]
            },
            u: {
                "长元音": ["ukulele", "UFO", "unite"],
                "短元音": ["under", "up", "ugly"]
            }
        };
        var enlighten_course_index = 5;
        var enlighten_info_detail = [
            {tab_id: "tab0", tab_name: "目标", gen_html_func: get_tab0_content_html, content_html: ""},
            {tab_id: "tab1", tab_name: "教学", gen_html_func: get_tab1_content_html, content_html: ""},
            {tab_id: "tab2", tab_name: "练习", gen_html_func: get_tab2_content_html, content_html: ""},
            {
                tab_id: "tab3",
                tab_name: "视频",
                gen_html_func: get_tab3_content_html,
                content_html: "",
                onclick_html: "show_video(\"tab3\", 28, \"../video/resources/\", true, \"myTab\");"
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
                "<li class='li_line_height'>弄清什么是长元音与短元音</li>" +
                "<li class='li_line_height'>学会几个长元音短元音单词</li>" +
                "<ul>";
            enlighten_info_detail[0].content_html = html;
        }

        function get_tab1_content_html() {
            var html = "<h5><span class='badge badge-success'>1</span> 长元音与短元音</h5>" +
                "<ul>" +
                "<li>当元音字母在一个单词中的发音（<code>音素音</code>）与该字母的<code>名字音</code>相同时，这个音就叫作<code>长元音</code>；</li>" +
                "<li>当元音字母在一个单词中的发音（<code>音素音</code>）与该字母的<code>名字音</code>不同时，这个音就叫作<code>短元音</code>。</li>" +
                "</ul>";
            html += "<h5 class='mt-3'><span class='badge badge-success'>2</span> 长短元音单词集</h5>" +
                "<ul class='nav nav-tabs' id='myTab' role='tablist'>" +
                "<li class='nav-item'><a class='nav-link active' data-toggle='tab' href='#a' role='tab' aria-controls='home' aria-selected='true'>A</a></li>" +
                "<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#e' role='tab'>E</a></li>" +
                "<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#i' role='tab'>I</a></li>" +
                "<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#o' role='tab'>O</a></li>" +
                "<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#u' role='tab'>U</a></li>" +
                "</ul>" +
                "<div class='tab-content' id='myTabContent'>" +
                "<div class='tab-pane fade show active p-1' id='a' role='tabpanel' aria-labelledby='home-tab'>" +
                show_word_by_dict('a') +
                "</div>" +
                "<div class='tab-pane fade show' id='e' role='tabpanel' aria-labelledby='home-tab'>" +
                show_word_by_dict('e') +
                "</div>" +
                "<div class='tab-pane fade show' id='i' role='tabpanel' aria-labelledby='home-tab'>" +
                show_word_by_dict('i') +
                "</div>" +
                "<div class='tab-pane fade show' id='o' role='tabpanel' aria-labelledby='home-tab'>" +
                show_word_by_dict('o') +
                "</div>" +
                "<div class='tab-pane fade show' id='u' role='tabpanel' aria-labelledby='home-tab'>" +
                show_word_by_dict('u') +
                "</div>" +
                "</div>";
            enlighten_info_detail[1].content_html = html;
        }

        function get_tab2_content_html() {
            var html = "<h5><span class='badge badge-primary'>1</span> 判断元音是长元音或短元音</h5><span id='exercise_element'>";
            html += show_exercise_for_tab2();
            html += "</span>";
            enlighten_info_detail[2].content_html = html;
        }

        function get_tab3_content_html() {
            enlighten_info_detail[3].content_html = "";
        }

        function replay() {
            temp_words.splice(0, 1);
            $("#exercise_element").html(show_exercise_for_tab2());
        }

        function show_exercise_for_tab2() {
            if (temp_words[0] == "-") {
                var html = "<div class='w-100 border-primary bg-info' style='line-height: 136px; text-align:center;'>通关成功！获得 <i class='fa fa-trophy fa-2x' style='color:#e7d785;'></i> 一座！</div>" +
                    "<div class='d-flex justify-content-end mt-2'><button class='btn btn-primary' onclick='replay();'>重玩一次</button>";
                return html;
            }
            if (temp_words.length == 0) {
                $.each(words, function (vowel, itm) {
                    $.each(itm, function (letter_type, words_arr) {
                        $.each(words_arr, function (idx, word) {
                            word = vowel + "_" + letter_type + "_" + word;
                            temp_words.push(word);
                        });
                    });
                });
            }
            var random_index = parseInt(Math.random() * (temp_words.length - 1));
            var random_word_info = temp_words[random_index].split("_");
            temp_words.splice(random_index, 1);
            if (temp_words.length == 0) {
                temp_words.push("-");
            }
            var random_word = random_word_info[2];
            var word_html = "";
            var letters = random_word.split("");
            $.each(letters, function (idx, letter) {
                if (letter.toUpperCase() == random_word_info[0].toUpperCase()) {
                    word_html += "<code>" + letter + "</code>";
                } else {
                    word_html += letter;
                }
            });
            var long_vowel = false;
            var short_vowel = false;
            if (random_word_info[1] == "长元音") {
                long_vowel = true;
            } else {
                short_vowel = true;
            }
            var html = "<div class='card w-100 bg-primary p-1 mt-1' style='max-width: 350px;'>" +
                "<img class='card-img-top' src='../image/" + random_word + ".jpg' onclick='play_sound(\"" + random_word + "\", \"play_sound\");'>" +
                "<div class='card-body p-0'>" +
                "<p class='card-text text-center'><button class='btn btn-success ml-1' style='position: absolute; left: 0;' onclick='judge_exercise_result(this, " + long_vowel + ");return false;'>长元音</button>" + "<kbd class='middle_font_size' onclick='play_sound(\"" + random_word + "\", \"play_sound\");'>" + word_html + "</kbd><button onclick='judge_exercise_result(this, " + short_vowel + ");' class='btn btn-success mr-1' style='position: absolute; right: 0;'>短元音</button></p>" +
                "</div>" +
                "</div>";
            return html;
        }

        function judge_exercise_result(_this, result) {
            if (result) {
                $("#exercise_element").html(show_exercise_for_tab2());
            } else {
                var self = $(_this);
                self.removeClass("btn-success");
                self.addClass("btn-danger");
            }
        }

        function set_tab_content_html(tab_index) {
            var tab_id = "tab" + tab_index;
            enlighten_info_detail[tab_index].gen_html_func();
            $("#" + tab_id).html(enlighten_info_detail[tab_index].content_html);
        }

        function show_word_by_dict(vowel) {
            var html = "";
            var word_info = words[vowel];
            $.each(word_info, function (type, word_arr) {
                $.each(word_arr, function (idx, word) {
                    html += show_word_for_tab1(word, vowel, type);
                })
            });
            return html;
        }

        function show_word_for_tab1(word, keyword, type) {
            var html = "";
            var letters = word.split("");
            var word_html = "";
            $.each(letters, function (idx, letter) {
                if (letter == keyword) {
                    word_html += "<code>" + letter + "</code>";
                } else {
                    word_html += letter;
                }
            });
            html += "<div class='card w-100 bg-primary p-1 mt-1' style='max-width: 350px;' onclick='set_bg_color(this); play_sound(\"" + word + "\", \"play_sound\", set_bg_color, this);'>" +
                "<img class='card-img-top' src='../image/" + word + ".jpg'>" +
                "<div class='card-body p-0'>" +
                "<p class='card-text text-center'><span style='position: absolute; left: 5px;'>" + type + ":</span>" + "<kbd class='middle_font_size'>" + word_html + "</kbd></p>" +
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
