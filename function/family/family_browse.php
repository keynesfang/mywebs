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
    <!--    <link rel="stylesheet" href="../../lib/jOrgChart/css/bootstrap.min.css"/>-->
    <link rel="stylesheet" href="../../lib/jOrgChart/css/jquery.jOrgChart.css"/>
    <link rel="stylesheet" href="../../lib/jOrgChart/css/custom.css"/>
    <link rel="stylesheet" href="../../css/common.css"/>
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src="../../lib/jOrgChart/jquery.jOrgChart.js"></script>
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
        .event_content {
            color: #000;
        }
        .card-header {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
    <script>
        var g_click_hidden_sub_nodes = false;
        var g_generation_level = 0;
        jQuery(document).ready(function () {
            var data = {"type": "get_family_person_list_in", "family_id": $.cookie("family_id")};
            $.ajax({
                url: "./local_logic.php",
                type: 'GET',
                dataType: 'JSON',
                data: data,
                success: function (person_list) {
                    var showlist = $("<ul id='org' style='display:none'></ul>");
                    var nodes_dict = {};
                    $.each(person_list, function (idx, person_info) {
                        var parent_id = person_info.parent_id;
                        var pi = get_node_values(person_info);
                        var node = get_node_struct(pi);
                        if (parent_id) {
                            if (typeof(nodes_dict[parent_id]) == "undefined") {
                                nodes_dict[parent_id] = [];
                            }
                            nodes_dict[parent_id].push(node);
                        }
                    });
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
                        dragAndDrop: false //设置是否可拖动
                    });
                    regist_node_click();
                }
            });
        });

        function regist_node_click() {
            $(".node").click(function (e) {
                var sel_person_id = $(this).attr("id");
                var sel_person_name = $(this).children().children().last().text();
                $.cookie("person_id", sel_person_id);
                $.cookie("person_name", sel_person_name);
                $("#person_name").text(sel_person_name);
                $.post("./local_logic.php", {
                    type: "get_family_event",
                    family_id: $.cookie("family_id"),
                    person_id: sel_person_id,
                    user_right: $.cookie("user_right")
                }, function (result) {
                    var family_events = eval("(" + result + ")");
                    var events_html = "";
                    $.each(family_events, function (idx, event) {
                        var id = "event" + event.id;
                        events_html += "<div class='card'>";
                        events_html += "<div class='card-header'>";
                        events_html += "<h5 class='mb-0'>";
                        events_html += "<button class='btn btn-link collapsed' data-toggle='collapse' data-target='#" + id + "' aria-expanded='false' aria-controls='collapseTwo'>";
                        events_html += event.happen_date + " " + event.event_title;
                        events_html += "</button>";
                        events_html += "</h5>";
                        events_html += "</div>";
                        events_html += "<div id='" + id + "' class='collapse event_content' aria-labelledby='headingTwo' data-parent='#accordion'>";
                        events_html += "<div class='card-body'>";
                        events_html += event.event_content;
                        events_html += "</div>";
                        events_html += "</div>";
                        events_html += "</div>";
                    });
                    $("#show_events").html(events_html);
                    $("#accordion").show();
                });
            });
        }

        function get_family_generation() {
            $.post("./local_logic.php", {
                type: "get_family_generation2",
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right")
            }, function (generation) {
                $("#generation").val(generation);
                var generation_html = "";
                generation_html += "<span class='list-group-item list-group-item-action generation_h p-0' style='opacity: 0;'></span>";
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

        function get_node_values(person_info) {
            var pi = {
                person_info: person_info,
                name: "",
                backColor: "#f26a7e",
                personTypeStyle: ""
            };
            if (person_info.sex == "男性") {
                pi.backColor = "#5da7c0";
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
                var li = $("<li value='" + val.id + "'></li>");
                var lover_text = "<span></span><span>";
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
                <span class="text-danger">选择人员看经历</span>
            </h4>
            <div id="accordion" class="none-display">
                <div class="d-flex justify-content-end mb-1">
                    <a class="btn btn-primary" href="./family_add_experience.php">为【<span id="person_name"></span>】增加经历</a>
                </div>
                <div id="show_events"></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>