<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <link rel='stylesheet' type='text/css' href='../../css/common.css'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/popper.min.js'></script>
    <script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../lib/jquery.md5.js'></script>
    <script src='../../lib/common.js'></script>
    <script src='../../lib/conflict.js'></script>
    <script src='../../lib/form_creator.js'></script>
    <script src='../../lib/form_operator.js'></script>
    <script src='../../lib/jquery.cookie.js'></script>
    <script src='./js/family_data.js'></script>
    <script src='./js/family_forms.js'></script>
    <script>
        var sub_frame_div = undefined;
        var formModal_div = undefined;
        var logout_btn = undefined;
        $(function () {
            sub_frame_div = $("#sub_frame");
            formModal_div = $("#formModal");
            logout_btn = $("#logout_btn");
            sub_frame_div.css("padding-top", $("#nav_bar").outerHeight());
            init_page_cookie();
            set_normal_menu();
            set_user_login_ui();
        });

        function menu_change(menu_html) {
            $("#family_menu").html(menu_html);
            regist_menu_click();
        }

        function set_normal_menu() {
            $.post("./local_logic.php", {
                type: "init_normal_menu"
            }, function (normal_menu) {
                $("#family_name").html("族谱网");
                $.cookie("family_id", "");
                $.cookie("family_name", "");
                $.cookie("user_right", "");
                menu_change(normal_menu);
                $("#sub_frame").attr("src", "./login.php");
            });
        }

        function regist_menu_click() {
            $(".nav-link").click(function () {
                $(".nav-item").removeClass("active");
                $(this).parent().addClass("active");
                var link = $(this).attr("link");
                if (link == "./login.php") {
                    set_normal_menu();
                } else {
                    $("#sub_frame").attr("src", link);
                }
                $("#navbarSupportedContent").collapse('hide');
            });
        }

        function user_regist_callback(result, user_id) {
            if (result) {
                $.cookie('user_id', user_id);
                $.post("./local_logic.php", {
                    type: "user_regist_callback",
                    user_id: user_id
                }, function (user_name) {
                    $.cookie('user_name', user_name);
                    location.reload();
//                    set_user_login_ui();
//                    sub_frame.window.set_user_login_ui();
//                    formModal_div.modal('hide');
                });
            } else {
                $(".form_error_message").show();
            }
        }

        function page_login_callback(result, user_info) {
            if (result) {
                user_info = user_info[0];
                $.cookie('user_id', user_info.id);
                $.cookie('user_name', user_info.loginName);
                set_user_login_ui();
                location.reload();
//                sub_frame.window.set_user_login_ui();
//                formModal_div.modal('hide');
            } else {
                $(".form_error_message").show();
            }
        }

        function user_logout() {
            clear_page_cookie();
            set_user_login_ui();
            set_normal_menu();
            sub_frame.window.set_user_login_ui();
        }

        function set_user_login_ui() {
            if ($.cookie('user_id')) { // 已登陆
                $(".logout_show").hide();
                $(".login_show").show();
                logout_btn.text($.cookie('user_name') + "，注销");
                logout_btn.show();
            } else { // 未登陆
                $(".login_show").hide();
                $(".logout_show").show();
                logout_btn.text("");
                logout_btn.hide();
            }
        }
    </script>
    <title>家谱网</title>
</head>
<body>
<div id="formModal" class="modal mt-5" tabindex="-1" role="dialog"></div>
<iframe id="sub_frame" name="sub_frame" class="border-0 h-100  fixed-top" style="overflow: auto;"></iframe>
<nav id="nav_bar" class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top">
    <span id="family_name" class="navbar-brand">家谱网</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="normal_menu d-inline-block">
            <ul id="family_menu" class="navbar-nav mr-auto"></ul>
        </div>
        <ul class="navbar-nav mr-auto"></ul>
        <div>
            <div class="mr-sm-2 d-inline-block">
                <button class="btn btn-outline-light my-2 my-sm-0 logout_show" data-toggle='modal'
                        data-target='#formModal' onclick='get_input_form_html(login_form);'>登陆
                </button>
                <button class="btn btn-outline-warning my-2 my-sm-0 logout_show" data-toggle='modal'
                        data-target='#formModal' onclick='get_input_form_html(regist_form);'>注册
                </button>
                <button id="logout_btn" class="btn btn-outline-light my-2 my-sm-0 none-display"
                        onclick="user_logout();">注销
                </button>
            </div>
        </div>
    </div>
</nav>
</body>
</html>
