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
        .family_name {
            position: absolute;
            top: 16px;
            left: 23px;
            width: 20px;
            line-height: 20px;
        }

        .family_text {
            font-family: '楷体';
            position: absolute;
            bottom: 15px;
            right: 25px;
            width: 20px;
            line-height: 15px;
            color: #fff;
            font-size: 14px;
        }
    </style>
    <script>
        var g_my_family_info_list = undefined; // g_my_family_info_list[family_id] = user_right;
        var g_current_page = 1;
        var g_count_per_page = 5;
        var formModal_div = undefined;
        $(function () {
            formModal_div = $("#formModal");
            set_user_login_ui();
        });

        function set_user_login_ui() {
            if ($.cookie('user_id')) { // 已登陆
                get_my_family_list();
                $(".logout_show").hide();
                $(".login_show").show();
            } else { // 未登陆
                $(".login_show").hide();
                $(".logout_show").show();
                family_search()
            }
        }

        function new_family_callback(result, family_id) {
            if (result) { // 创建族谱成功
                $(".form_error_message").hide();
                $.post("./local_logic.php", {
                    type: "create_family_callback",
                    family_id: family_id,
                    user_id: $.cookie("user_id")
                }, function () {
                    get_my_family_list();
                    formModal_div.modal('hide');
                });
            } else {
                $(".form_error_message").show();
            }
        }

        function get_my_family_list() {
            g_my_family_info_list = {};
            $("#user_info").html("");
            $.post("./local_logic.php", {
                type: "get_my_family_list",
                user_id: $.cookie("user_id")
            }, function (result) {
                var html = "";
                var my_family_list = eval("(" + result + ")");
                $.each(my_family_list, function (idx, family_info) {
                    g_my_family_info_list[family_info.family_id] = family_info.user_right;
                    if (parseInt(family_info.user_right) >= 0) {
                        var family_explain = "点击进入";
                        var click_enter_class = "click_enter_family";
                        var family_image = "show_family.jpg";
                        if (parseInt(family_info.user_right) == 0) {
                            family_explain = "审核中";
                            family_image = "show_family_check.jpg";
                            click_enter_class = "";
                        }
                        var surfix = "族谱";
                        if (family_info.surname.length == 1) {
                            surfix = "氏" + surfix;
                        }
                        html += "<div family_id='" + family_info.family_id + "' family_name='" + family_info.name + "' family_surname='" + family_info.surname + "' class='d-inline-block mr-2 mt-2 " + click_enter_class + "'>";
                        html += "<div style='position: relative;'>";
                        html += "<span class='family_name'>" + family_info.surname + surfix + "</span>";
                        html += "<span class='family_text'>" + family_explain + "</span>";
                        html += "<img class='img-thumbnail' src='./image/" + family_image + "' style='width: 120px; height: 120px;'>";
                        html += "</div>";
                        html += "</div>";
                    }
                });
                html += "<img class='img-thumbnail mt-2' src='./image/add_family.jpg' style='width: 120px; height: 120px;' data-toggle='modal'data-target='#formModal' onclick='get_input_form_html(family_forms);'>";
                $("#user_info").html(html);
                // 点击进入族谱管理界面
                $(".click_enter_family").click(function () {
                    var family_id = $(this).attr("family_id");
                    var family_name = $(this).attr("family_name");
                    var family_surname = $(this).attr("family_surname");
                    $.cookie("family_id", family_id);
                    $.cookie("family_name", family_name);
                    $.cookie("family_surname", family_surname);
                    $.cookie("user_right", g_my_family_info_list[family_id]);
                    $.post("./local_logic.php", {
                        type: "init_family_menu",
                        user_right: $.cookie("user_right")
                    }, function (family_menu) {
                        parent.menu_change(family_menu);
                        parent.$("#family_name").html(family_name);
                        parent.$("#sub_frame").attr("src", "./family_user.php");
                    });
                });
                family_search();
            });
        }

        function family_search(search_type) {
            $("#family_list").html("");
            var search_text = $.trim($("#search_text").val());
            var previous_disable = "";
            var next_disable = "";
            var condition = " order by create_date desc limit " + (g_current_page - 1) * g_count_per_page + "," + g_count_per_page;
            var sub_condition = "";
            var sql = "select family.*, loginName from family, family_user where family.create_user_id=family_user.id";
            var count_sql = "select count(id) as count from family where 1=1";
            if (search_type == "person_name") {
                sub_condition = " and family.name like '%" + search_text + "%'";
                condition = sub_condition + condition;
            } else if (search_type == "family_name") {
                sub_condition = " and family.surname like '%" + search_text + "%'";
                condition = sub_condition + condition;
            }
            count_sql += sub_condition;
            sql += condition;

            $.post("./local_logic.php", {
                type: "get_family_list",
                count_sql: count_sql,
                sql: sql
            }, function (result) {
                var family_list = eval("(" + result + ")");
                var html = "";
                var page_nav_html = "";
                var margin_style = "";
                $.each(family_list.data_list, function (idx, itm) {
                    var surfix = "族谱";
                    if (itm.surname.length == 1) {
                        surfix = "氏" + surfix;
                    }
                    html += "<li class='list-group-item flex-column align-items-start family_list_item pl-5 pr-2 py-3'>";
                    html += "<span class='show_family_span bg-info text-white'>" + itm.surname + surfix + "</span>";
                    if ($.cookie('user_id') != "") {
                        margin_style = "mr-4";
                        var intId = parseInt(itm.id);
                        if (typeof(g_my_family_info_list[intId]) == "undefined") {
                            html += "<span family_id='" + itm.id + "' class='apply_family_span bg-primary text-white apply_family_action'>申请入谱</span>";
                        } else if (parseInt(g_my_family_info_list[intId]) == 0) {
                            html += "<span family_id='" + itm.id + "'  class='apply_family_span bg-warning text-white rollback_family_action'>撤回申请</span>";
                        } else if (parseInt(g_my_family_info_list[intId]) == -1) {
                            html += "<span class='apply_family_span bg-secondary text-white'>申请被拒</span>";
                        } else if (parseInt(g_my_family_info_list[intId]) == -2) {
                            html += "<span class='apply_family_span bg-secondary text-white'>已被劝退</span>";
                        } else {
                            html += "<span class='apply_family_span bg-secondary text-white'>已入该谱</span>";
                        }

                    }
                    html += "<h6>【谱名】" + itm.name + "</h6>";
                    html += "<div class='d-flex justify-content-end " + margin_style + "'>";
                    html += "<small>由【" + itm.loginName + " 】创建于【" + itm.create_date + " 】</small>";
                    html += "</div>";
                    html += "</li>";
                });
                var page_count = parseInt(family_list.count / g_count_per_page);
                if (family_list.count % g_count_per_page > 0) {
                    page_count++;
                }
                if (g_current_page == 1) {
                    previous_disable = " disabled";
                }
                if (g_current_page >= page_count) {
                    next_disable = " disabled";
                }
                page_nav_html += "<li class='page-item" + previous_disable + "'><span class='page-link'>Previous</span></li>";
                for (let i = 1; i <= page_count; i++) {
                    var active = "";
                    if (i == parseInt(g_current_page)) {
                        active = " active";
                    }
                    page_nav_html += "<li class='page-item" + active + "'><a class='page-link' href='#'>" + i + "</a></li>";
                }
                page_nav_html += "<li class='page-item" + next_disable + "'><a class='page-link' href='#'>Next</a></li>";
                $("#family_pagination").html(page_nav_html);
                $("#family_list").html(html);

                $(".page-item").click(function () {
                    if ($(this).hasClass("disabled")) {
                        return;
                    }
                    var page = $(this).text();
                    if (page == "Previous") {
                        g_current_page = g_current_page - 1;
                    } else if (page == "Next") {
                        g_current_page = g_current_page + 1;
                    } else {
                        g_current_page = parseInt(page);
                    }
                    family_search(search_type);
                });

                $(".apply_family_action").click(function () {
                    $.post("./local_logic.php", {
                        type: "apply_family_action",
                        family_id: $(this).attr("family_id"),
                        user_id: $.cookie("user_id")
                    }, function () {
                        get_my_family_list();
                        family_search();
                    });
                });

                $(".rollback_family_action").click(function () {
                    $.post("./local_logic.php", {
                        type: "rollback_family_action",
                        family_id: $(this).attr("family_id"),
                        user_id: $.cookie("user_id")
                    }, function () {
                        get_my_family_list();
                        family_search();
                    });
                });
            });
        }
    </script>
    <title>族谱网</title>
</head>
<body><!--class="family_bkgd"-->
<div id="formModal" class="modal mt-1" tabindex="-1" role="dialog"></div>
<div class="container">
    <div class="row w-100 m-0">
        <!--搜索-->
        <div class="col-md-12 mb-2 p-0">
            <div class="mt-3 w-100">
                <div class="input-group w-100">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary" id="basic-addon1"><i
                                class="fa fa-search fa-lg text-white"></i></span>
                    </div>
                    <input id="search_text" type="text" class="form-control" placeholder="按谱名或姓氏搜索"
                           aria-label="Text input with dropdown button">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">搜索类型
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="family_search('family_name');">搜谱名</a>
                            <div role="separator" class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="family_search('person_name');">搜姓氏</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 w-100 user_flag">
                中华有情，认祖归宗
            </div>
            <div class="row my-3">
                <div class="col-md-8">
                    <h6 class="text-primary login_show"><i class="fa fa-user fa-lg"></i> 我能查看的族谱</h6>
                    <div id="user_info" class="mb-3 login_show"></div>
                    <h6 class="text-primary"><i class="fa fa-reorder fa-lg"></i> 最新建谱一览</h6>
                    <ul id="family_list" class="mt-3 list-group list-group-flush">
                    </ul>
                    <nav class="my-3 d-flex justify-content-end">
                        <ul id="family_pagination" class="pagination"></ul>
                    </nav>
                </div>
                <div class="col-md-4">
                    <h6 class="text-primary"><i class="fa fa-book fa-lg"></i> 族谱趣事</h6>
                    <div class="border-secondary bg-info p-1 img-thumbnail my-3">
                        <div class="pl-3">
                            <details>
                                <summary class="text-white border-0 none-outline">中华族谱的来历</summary>
                                <div class="explain_words">
                                    族谱：又称家谱、宗谱等。是一种以表谱形式，记载一个家族的世系繁衍及重要人物事迹的书。
                                    皇帝的家谱称玉牒，如新朝玉牒、皇宋玉牒。它以记载父系家族世系、人物为中心，由正史中的帝王本纪及王侯列传、年表等演变而来。
                                </div>
                            </details>
                            <details class="mt-2">
                                <summary class="text-white border-0 none-outline">族谱中记录的那些事</summary>
                                <div class="explain_words">
                                    谱、族谱，是一个家族的生命史。它不仅记录着该家族的来源、迁徙的轨迹，还包罗了该家族生息、繁衍、婚姻、文化、族规、家约等历史文化的全过程。
                                </div>
                            </details>
                        </div>
                    </div>
                    <h6 class="text-primary"><i class="fa fa-book fa-lg"></i> 族谱小知识</h6>
                    <div class="border-secondary bg-info p-1 img-thumbnail my-3">
                        <div class="pl-3">
                            <details>
                                <summary class="text-white border-0 none-outline">什么是字辈</summary>
                                <div class="explain_words">
                                    字辈：由族中某位或某几位有威望者讨论，或者很正式的召开修族谱大会决定。排行形式或取之经书中某句，或现写的对联，或类诗体，或记庭的特征等，可以循环用。
                                    经常是用完之后在续族谱时再写。一般说来，每代男丁姓名中间那个字就是排行诗中的，女子可不用。字辈可用于明确辈份，确认同姓分支之间的关系。如果碰到对方使用相同的排行，可增加异地同姓者之间的亲切感。
                                </div>
                            </details>
                            <details class="mt-2">
                                <summary class="text-white border-0 none-outline">什么是族谱中的谱号</summary>
                                <div class="explain_words">
                                    谱号：可以是家谱的堂号、房号、支派号。是家族文化重要的组成部分。
                                    因古代同姓族人多聚族而居，往往数世同堂，或同一姓氏的支派、分房集中居住于某一处或相近数处庭堂、宅院之中，堂号就成为某一同族人的共同徽号。
                                    堂号也含有祠堂名号之含义，是表明一个家族源流世系，区分族属、支派的标记。
                                </div>
                            </details>
                            <details class="mt-2">
                                <summary class="text-white border-0 none-outline">什么是族谱中的地望</summary>
                                <div class="explain_words">
                                    地望：又称郡望，是名门大族（即汉末开始出现的门阀士族）所特有的标志其身份的籍贯。如弘农杨氏，汝南袁氏，琅邪王氏，陈郡谢氏等。 主要用于标题一个姓氏或家族的发祥地与望出地。
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</body>
</html>
