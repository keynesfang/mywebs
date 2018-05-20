<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>族谱网</title>
    <meta name="keywords" content="族谱网"/>
    <meta name="description" content="族谱网"/>

    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel="stylesheet" href="../../lib/jOrgChart/css/jquery.jOrgChart.css"/>
    <link rel="stylesheet" href="../../lib/jOrgChart/css/custom.css"/>
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <script src="../../lib/jOrgChart/jquery.min.js"></script>
    <script src="../../lib/jOrgChart/jquery.jOrgChart.js"></script>
    <script src="../../lib/jOrgChart/jquery-ui.min.js"></script>
    <script src='../../lib/jquery.cookie.js'></script>
    <script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <style>
        .node {
            box-sizing: content-box;
        }

        table {
            border-collapse: inherit;
        }

        .jOrgChart {
            padding: 0;
            margin: 0;
        }
    </style>
    <script>
        var g_generation_level = 0;
        var g_current_drag_id = "";
        var g_person_info_list = {}; // g_person_info_list[id] = person_info
        jQuery(document).ready(function () {
            var data = {"type": "get_family_person_list", "family_id": $.cookie("family_id")};
            $.ajax({
                url: "./local_logic.php",
                type: 'GET',
                dataType: 'JSON',
                data: data,
                success: function (person_list) {
                    var showlist = $("<ul id='org' style='display:none'></ul>");
                    var nodes_dict = {};
                    var person_right_html = "";
                    $.each(person_list, function (idx, person_info) {
                        g_person_info_list[person_info.id] = person_info;
                        if (parseInt(person_info.parent_id) != -1) { // 已在族谱中的族人
                            var parent_id = person_info.parent_id;
                            var pi = get_node_values(person_info);
                            var node = get_node_struct(pi);
                            if (parent_id) {
                                if (typeof(nodes_dict[parent_id]) == "undefined") {
                                    nodes_dict[parent_id] = [];
                                }
                                nodes_dict[parent_id].push(node);
                            }
                        } else { // 未在族谱中的族人，生成对应的HTML
                            person_right_html += get_person_right_html(person_info);
                        }
                    });
                    $("#person_not_in").html(person_right_html);
                    $.each(nodes_dict, function (parent_id, person_node_list) {
                        $.each(person_node_list, function (idx, person_node) {
                            if (typeof(nodes_dict[person_node.id]) != "undefined") {
                                nodes_dict[parent_id][idx].children = nodes_dict[person_node.id];
                            }
                        });
                    });
                    var family_name = $.cookie("family_surname");
                    var surfix = "族谱";
                    if (family_name.length == 1) {
                        surfix = "氏" + surfix;
                    }
                    var tree_data = [
                        {
                            id: 0,
                            name: family_name + surfix,
                            pid: "",
                            is_lover: "",
                            children: []
                        }
                    ];
                    if (typeof(nodes_dict[0]) != "undefined") {
                        tree_data[0].children = nodes_dict[0];
                    }
                    g_generation_level = 0;
                    showall(tree_data, showlist);
                    get_family_generation();
                    $("#chart").append(showlist);
                    $("#org").jOrgChart({
                        chartElement: '#chart',//指定在某个dom生成jorgchart
                        dragAndDrop: true //设置是否可拖动
                    });
                    regist_right_obj_drag_drop_event();
                    regist_left_obj_drag_drop_event();
                }
            });
        });

        function get_family_generation() {
            $.post("./local_logic.php", {
                type: "get_family_generation2",
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right")
            }, function (generation) {
                $("#generation").val(generation);
                var generation_html = "";
                generation_html += "<span class='list-group-item list-group-item-action generation_h p-0' style=''></span>";
                generation_html += "<span class='list-group-item list-group-item-action generation_blank'>&nbsp;</span>";
                $.each(generation.split(""), function (idx, char) {
                    if (idx > (g_generation_level - 1)) {
                        return false;
                    }
                    if ($.trim(char) == "") {
                        return true; // 跳过本次，进行下一次循环。
                    }
                    generation_html += "<span class='list-group-item list-group-item-action generation_h p-0'>" + char + "</span>";
                    generation_html += "<span class='list-group-item list-group-item-action generation_blank'>&nbsp;</span>";
                });
                $("#generation_div").html(generation_html);
            });
        }

        function get_person_right_html(person_info) {
            var html = "";
            var ps = get_node_values(person_info);
            html += "<div id='" + person_info.id + "' draggable='true' class='list_person media drag_person_right my-1 " + ps.backColorStyle + "'>";
            html += "<img class='rounded-circle user_header_img' src='" + ps.image_url + "' alt='头像'>";
            html += "<span style='width: 20px;' class='text-center text-white " + ps.personTypeStyle + "'>" + person_info.is_lover + "</span>";
            html += "<div class='media-body p-1 ml-2'>";
            html += "<h6 class='m-0 mr-2' style='line-height: 50px;'>" + ps.name + "</h6>";
            html += "</div>";
            html += "</div>";
            return html;
        }

        function get_node_values(person_info) {
            var pi = {
                person_info: person_info,
                name: "",
                backColor: "#f26a7e",
                personTypeStyle: "",
                backColorStyle: "user_header_media_female",
                image_url: "./image/female.jpg"
            };
            if (person_info.sex == "男性") {
                pi.backColor = "#5da7c0";
                pi.backColorStyle = "user_header_media_male";
                pi.image_url = "./image/male.jpg";
            }
            if (person_info.is_lover == "外戚") {
                pi.personTypeStyle = "user_header_media_mother";
            }
            if (person_info.is_lover == "配偶") {
                pi.personTypeStyle = "user_header_media_lover";
            }
            pi.name = person_info.firstName + person_info.lastName;
            return pi;
        }

        function get_node_struct(pi) {
            var node = {
                id: pi.person_info.id,
                name: pi.name,
                pid: pi.person_info.parent_id,
                is_lover: pi.person_info.is_lover,
                backColor: pi.backColor,
                personTypeStyle: pi.personTypeStyle,
                children: []
            };
            return node;
        }

        function showall(menu_list, parent) {
            g_generation_level += 1;
            $.each(menu_list, function (index, val) {
                var li = $("<li value='" + val.id + "'></li><span>");
                var lover_text = "<span></span>";
                if (val.is_lover != "本家") {
                    lover_text = "<span class='px-1 " + val.personTypeStyle + "' style='position: absolute; top: 0; left: 0'>" + val.is_lover + "</span><span>";
                }
                li.append("<div style='background-color: " + val.backColor + ";'>" + lover_text + val.name + "</span></div>");
                if (val.children.length > 0) {
                    li.append("<ul></ul>").appendTo(parent);
                    //递归显示
                    showall(val.children, $(li).children().eq(1));
                } else {
                    li.appendTo(parent);
                }
            });
        }

        function regist_right_obj_drag_drop_event() {
            $(".drag_person_right").draggable({
                cursor: 'move',
                distance: 40,
                helper: 'clone',
                opacity: 0.8,
                revert: 'invalid',
                revertDuration: 100,
                snap: 'div.node.expanded',
                snapMode: 'inner',
                stack: 'div.node'
            });
            $('#person_not_in').droppable({
                accept: '.node',
                activeClass: 'drag-active',
                hoverClass: 'drop-hover'
            });
            // 开始拖
            $(".drag_person_right").on("dragstart", function (e) {
                g_current_drag_id = e.currentTarget.id;
            });
            // 在接收元素上释放
            $("#person_not_in").on("drop", function (e) {
                e.preventDefault();
                if (parseInt(g_current_drag_id) == 0) {
                    init_family_list();
                } else {
                    var node_table = $("#" + g_current_drag_id).parent().parent().parent().parent();
                    var node_list = node_table.children().find("div[id]");
                    var person_list = [];
                    $.each(node_list, function (idx, node) {
                        person_list.push(node.id);
                    });
                    set_person_list_relationship(person_list);
                }
            });
        }

        function regist_left_obj_drag_drop_event() {
            // 开始拖
            $(".node").on("dragstart", function (e) {
                g_current_drag_id = e.currentTarget.id;
            });
            $(".node").on("drop", function (e) {
                e.preventDefault();
                var p_parent_id = $(this).attr("id");
                set_person_relationship(p_parent_id, g_current_drag_id);
            });
        }

        function init_family_list() {
            $.post("./local_logic.php", {
                type: "init_family_list",
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right")
            }, function () {
                location.reload();
            });
        }

        function set_person_list_relationship(person_id_list) {
            $.post("./local_logic.php", {
                type: "set_person_list_relationship",
                family_id: $.cookie("family_id"),
                person_id_list: person_id_list,
                user_right: $.cookie("user_right")
            }, function () {
                location.reload();
            });
        }

        function set_person_relationship(parent_id, person_id) {
            $.post("./local_logic.php", {
                type: "set_person_relationship",
                parent_id: parent_id,
                person_id: person_id,
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right")
            }, function () {
                location.reload();
            });
        }
    </script>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-1" style="min-width: 80px;">
            <div id="generation_div" class="list-group">
            </div>
        </div>
        <div class="col-7">
            <div id="chart" class="orgChart"></div>
        </div>
        <div class="col-md-4">
            <h4 class="d-flex justify-content-between align-items-center ml-4 mb-3">
                <span class="text-danger">待入家谱人员</span>
            </h4>
            <ul id="person_not_in" class="list-unstyled drop_person_right h-100">
            </ul>
        </div>
    </div>
</div>
</body>
</html>