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
    <script src='../../lib/form_creator.js'></script>
    <script src='../../lib/form_operator.js'></script>
    <script src='../../lib/common.js'></script>
    <script src='./js/family_forms.js'></script>
    <style>
    </style>
    <script>
        $(function () {
            $(".show_user_action").click(function () {
                var user_type = $(this).attr("user_type");
                var _this = this;
                $.post("./local_logic.php", {
                    type: "get_user_by_type",
                    family_id: $.cookie("family_id"),
                    user_right: $.cookie("user_right"),
                    user_type: user_type
                }, function (user_info_html) {
                    $("#user_" + user_type).html(user_info_html);
                    $(_this).parent().next().show(500);
                });
            });
        });

        function change_user_type(user_id, user_type) {
            $.post("./local_logic.php", {
                type: "change_user_type",
                family_id: $.cookie("family_id"),
                user_id: user_id,
                user_right: $.cookie("user_right"),
                user_type: user_type
            }, function () {
                location.reload();
            });
        }
    </script>
    <title>族谱网</title>
</head>
<body><!--class="family_bkgd"-->
<div class="container mt-2">
    <div class="row w-100 m-0">
        <div class="col-md-3 p-0 my-2">
            <div class="card">
                <img class="card-img-top" src="./image/hua1.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-primary">族谱创建者</h5>
                    <p class="card-text">创建该族谱的用户；拥有最高权限。</p>
                    <a class="text-white btn btn-primary w-100 text-center show_user_action" user_type="5">查看详情</a>
                </div>
                <div class="card-body none-display border-top border-info">
                    <h5 id="user_5" class="card-title"></h5>
                    <p class="card-text">创建者权限：分配与取消管理员；通过或拒绝其他用户入谱申请；修改族谱相关信息。</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-0 my-2">
            <div class="card">
                <img class="card-img-top" src="./image/hua2.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-primary">修谱委员会</h5>
                    <p class="card-text">由创建者指定，可以修改族谱相关信息。为修谱委员会成员。</p>
                    <a class="text-white btn btn-primary w-100 text-center show_user_action" user_type="4">查看详情</a>
                </div>
                <div id="user_4" class="none-display">
                </div>
            </div>
        </div>
        <div class="col-md-3 p-0 my-2">
            <div class="card">
                <img class="card-img-top" src="./image/hua3.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-primary">族谱浏览者</h5>
                    <p class="card-text">可以登陆到族谱中，只具备查看相关信息的权限。</p>
                    <a class="text-white btn btn-primary w-100 text-center show_user_action" user_type="1">查看详情</a>
                </div>
                <div id="user_1" class="none-display">
                </div>
            </div>
        </div>
        <div class="col-md-3 p-0 my-2">
            <div class="card">
                <img class="card-img-top" src="./image/hua4.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-primary">族谱申请者</h5>
                    <p class="card-text">申请进入本族谱的用户。创建者可以同意或拒绝该用户的申请。</p>
                    <a class="text-white btn btn-primary w-100 text-center show_user_action" user_type="0">查看详情</a>
                </div>
                <div id="user_0" class="none-display">
                </div>
            </div>
        </div>
        <div class="col-md-6 p-0 my-2">
            <div class="card">
                <img class="card-img-top" src="./image/hua5.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-primary">被拒绝的申请者</h5>
                    <p class="card-text">申请进入本族谱，但被拒绝的用户。</p>
                    <a class="text-white btn btn-primary w-100 text-center show_user_action" user_type="-1">查看详情</a>
                </div>
                <div id="user_-1" class="none-display">
                </div>
            </div>
        </div>
        <div class="col-md-6 p-0 my-2">
            <div class="card">
                <img class="card-img-top" src="./image/hua6.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-primary">被踢出族谱的用户</h5>
                    <p class="card-text">曾经在本族谱，但被踢出的用户。</p>
                    <a class="text-white btn btn-primary w-100 text-center show_user_action" user_type="-2">查看详情</a>
                </div>
                <div id="user_-2" class="none-display">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
