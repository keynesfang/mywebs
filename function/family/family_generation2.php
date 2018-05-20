<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../../lib/font-awesome-4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='../../css/common.css'>
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/popper.min.js'></script>
    <script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../lib/jquery.cookie.js'></script>
    <script src='../../lib/conflict.js'></script>
    <script src='../../lib/form_operator.js'></script>
    <script src='../../lib/common.js'></script>
    <style>
    </style>
    <script>
        $(function () {
            set_generation_title();
            get_family_generation();
        });

        function set_generation_title() {
            $("#generation_title").text($.cookie("family_surname") + "氏字辈");

        }

        function get_family_generation() {
            $.post("./local_logic.php", {
                type: "get_family_generation2",
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right")
            }, function (generation) {
                $("#generation").val(generation);
                var generation_html = "";
                $.each(generation.split(""), function (idx, char) {
                    if ($.trim(char) == "") {
                        return true; // 跳过本次，进行下一次循环。
                    }
                    generation_html += "<div class='first_name_div'>" + char + "</div>";
                });
                $("#generation_div").html(generation_html);
            });
        }

        function set_generation() {
            var generation = $("#generation").val();
            $.post("./local_logic.php", {
                type: "set_family_generation",
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right"),
                generation: generation
            }, function () {
                location.reload();
            });
        }

    </script>
    <title>族谱网</title>
</head>
<!--class="family_bkgd"-->
<body>
<div class="container mt-4">
    <div class="row w-100 m-0">
        <div class="col-sm-12">
            <div class="jumbotron generation_bg" style="padding: 30px 20px 0 20px;">
                <h1 class="display-4 font_kaiti" id="generation_title"></h1>
                <p class="lead">字辈，也叫做字派，是指名字中用于表示家族辈份的字（多为名字中间的字），俗称派。其意蕴为修身齐家，安民治国，吉祥安康，兴旺发达。</p>
                <hr class="my-4">
                <p>请在该框中输入家族的字辈，注意字辈间不要有任何标点。</p>
                <p class="lead">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">字辈</span>
                    </div>
                    <textarea id="generation" class="form-control" aria-label="With textarea"></textarea>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="set_generation();">设定</button>
                    </div>
                </div>
                </p>
            </div>
        </div>
        <div id='generation_div' class="col-sm-12 mb-3" style="text-align:center;">
        </div>
    </div>
</div>
</body>
</html>
