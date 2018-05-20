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
    <link rel='stylesheet' type='text/css' href='../css/english.css'>
    <script src='../../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../../lib/popper.min.js'></script>
    <script src='../../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../../lib/common.js'></script>
    <title>English</title>
    <script>
        $(function () {
            var type = GetQueryString("type");
            type = "basic";
            if (!type) {
                top_page_php();
            }
            var sql = "SELECT e_classify, c_classify FROM eng_word WHERE word_type = '" + type + "' group by e_classify";
            $.post("../../common_logic.php", {
                type: "query_sql_get_data",
                sql: sql
            }, function (data) {
                var word_list = eval("(" + data + ")");
                var html = "";
                $.each(word_list, function (idx, itm) {
                    html += "" +
                        "<div class='card'>" +
                        "<div class='card-header'>" +
                        "<h5 class='mb-0'>" +
                        "<button class='btn btn-link word-classify' data-toggle='collapse' data-target='#" + itm.e_classify + "' aria-expanded='false' aria-controls='" + itm.e_classify + "'>" +
                        "基础词汇 - " + itm.c_classify + "(" + itm.e_classify + ")" +
                        "</button>" +
                        "</h5>" +
                        "</div>" +
                        "<div id='" + itm.e_classify + "' class='collapse' aria-labelledby='headingOne' data-parent='#accordion'>" +
                        "<div id='" + itm.e_classify + "_body'  class='card-body p-0'>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                });
                $("#accordion").html(html);
                $(".word-classify").click(function () {
                    var e_classify = $(this).attr("aria-controls");
                    var sql = "SELECT word FROM eng_word WHERE word_type = '" + type + "' and e_classify='" + e_classify + "'";
                    $.post("../../common_logic.php", {
                        type: "query_sql_get_data",
                        sql: sql
                    }, function (data) {
                        var word_list = eval("(" + data + ")");
                        var html = "<ul class='list-group'>";
                        html += "<li class='list-group-item d-flex justify-content-between align-items-center active bg-secondary'>词汇共计：" +
                            "<span class='badge badge-primary badge-pill'>" + word_list.length + "</span></li>";
                        $.each(word_list, function (idx, itm) {
                            html += "" +
                                "<li class='list-group-item list-group-item-action flex-column align-items-start'>" +
                                "<div class='d-flex w-100 justify-content-between'>" +
                                "<h5 class='mb-1'><i class='fa fa-volume-up text-primary' word='" + itm.word + "'></i> " + itm.word + "</h5>" +
                                "<small onclick='eng_word_translate(this, \"" + itm.word + "\")'>查词</small>" +
                                "</div>" +
                                "</li>";
                        });
                        html += "</ul>";
                        $("#" + e_classify + "_body").html(html);
                        $(".fa-volume-up").click(function () {
                            var url = "https://tts.yeshj.com/s/" + $(this).attr("word");
                            $("#play_sound").attr("src", url);
                            $("#play_sound")[0].play();
                        });
                    });
                });
            });
        });

        function eng_word_translate(self, word) {
            $(self).parent().next().remove();
            $.post("../../common_logic.php", {
                type: "eng_word_translate",
                word: word
            }, function (data) {
                var word_translate = eval("(" + data + ")");
                var basic_translate = word_translate["basic"];
                var us_phonetic = "";
                var uk_phonetic = "";
                var explains = "";
                var phonetic = "";
                var html = "";
                if (basic_translate) {
                    us_phonetic = basic_translate["us-phonetic"];
                    uk_phonetic = basic_translate["uk-phonetic"];
                    explains = basic_translate["explains"];
                    if (us_phonetic) {
                        phonetic += "美【" + us_phonetic + "】";
                    }
                    if (uk_phonetic) {
                        phonetic += "英【" + uk_phonetic + "】";
                    }
                } else if(word_translate.translation) {
                    explains = word_translate.translation;
                } else {
                    explains = ["未查到该词翻译！"];
                }
                html += "<div class='card w-100 border-0'>";
                if (phonetic != "") {
                    html += "<div class='card-header px-0'>" + phonetic + "</div>";
                }
                if (explains) {
                    html += "<ul class='list-group list-group-flush'>";
                    $.each(explains, function (idx, itm) {
                        html += "<li class='list-group-item'>" + itm + "</li>";
                    });
                    html += "</ul>";
                }

                html += "</div>";
                $(self).parent().parent().append(html);
            });
        }
    </script>
</head>
<body>
<audio id="play_sound"></audio>
<div>
    <div class="container-fluid">
        <div id='word_list' class="row">
            <div id="accordion" class="w-100">
            </div>
        </div>
    </div>
</div>
</body>
</html>
