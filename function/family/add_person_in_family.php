<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel="stylesheet" href="../../lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--    <link rel="stylesheet" href="../../lib/open-iconic/font/css/open-iconic-bootstrap.css">-->
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-treeview/bootstrap-treeview.min.css'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <title>家谱网</title>
    <style>
        .user_header_media_female {
            background-color: #f26a7e;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }

        .user_header_media_male {
            background-color: #5da7c0;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }

        .user_header_img {
            width: 60px;
            height: 60px;
        }

        .badge {
            float: right;
            display: inline-block;
            min-width: 10px;
            padding: 3px 7px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            background-color: #777;
            border-radius: 10px;
        }
    </style>
</head>
<body class="family_bkgd">
<a id="click_formModal_1" data-toggle='modal' data-target='#formModal'
   onclick='get_notify_form_html("拖动禁止", "配偶与外戚不能添加子节点！");'></a>
<a id="click_formModal_2" data-toggle='modal' data-target='#formModal'
   onclick='get_notify_form_html("拖动禁止", "配偶与外戚不能成为根节点！");'></a>
<div id="formModal" class="modal mt-5" tabindex="-1" role="dialog"></div>
<div id="sub_frame" class="container">
    <div class="row h-100">
        <div class="col-md-8 py-4">
            <h4 class="d-flex justify-content-between align-items-center ml-4 mb-3">
                <span class="text-danger">鼠标拖动人员入谱出谱</span>
            </h4>
            <div id="family_tree"></div>
        </div>
        <div class="col-md-4 my-4">
            <h4 class="d-flex justify-content-between align-items-center ml-4 mb-3">
                <span class="text-danger">待入家谱人员</span>
            </h4>
            <ul id="person_not_in" class="list-unstyled drop_person_right h-100">
            </ul>
        </div>
    </div>
</div>

<script src='../../lib/jquery-3.2.1.min.js'></script>
<script src='../../lib/popper.min.js'></script>
<script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
<script src='../../lib/bootstrap-treeview/bootstrap-treeview.js'></script>
<script src='../../lib/jquery.cookie.js'></script>
<script src='../../lib/form_creator.js'></script>
<script>
    var g_person_info_list = {}; // g_person_info_list[id] = person_info
    var tree_data = [
        {
            text: "",
            tags: [],
            state: {
                expanded: true
            },
            item_attr: {id: "0"},
            nodes: []
        }
    ];
    $(function () {
        tree_data[0].text = $.cookie("family_name");
        var family_name = $.cookie("family_surname");
        var surfix = "族谱";
        if (family_name.length == 1) {
            surfix = "氏" + surfix;
        }
        tree_data[0].tags.push(family_name + surfix);
        init_tree_data();
    });

    function init_tree_data() {
        $.post("./local_logic.php", {
            type: "get_family_person_list_in",
            family_id: $.cookie("family_id")
        }, function (result) {
            var person_list = eval("(" + result + ")");
            var nodes_dict = {};
            $.each(person_list, function (idx, person_info) {
                var id = person_info.id;
                var parent_id = person_info.parent_id;
                g_person_info_list[id] = person_info;
                var person_style = get_person_style_by_id(id);
                var node = get_node_struct(person_style, id, parent_id);
                if (parent_id) {
                    if (typeof(nodes_dict[parent_id]) == "undefined") {
                        nodes_dict[parent_id] = [];
                    }
                    nodes_dict[parent_id].push(node);
                }
            });
            $.each(nodes_dict, function (parent_id, person_node_list) {
                $.each(person_node_list, function (idx, person_node) {
                    if (typeof(nodes_dict[person_node.item_attr.id]) != "undefined") {
                        nodes_dict[parent_id][idx].nodes = nodes_dict[person_node.item_attr.id];
                    }
                });
            });
            if (typeof(nodes_dict[0]) != "undefined") {
                tree_data[0].nodes = nodes_dict[0];
            }
            // 创建人员树数据结构
            // 创建家庭人员树实例
            $('#family_tree').treeview({
                data: tree_data,
                showTags: true,
                nodeInitCallBack: node_item_callback
            });
            node_item_callback(); // 列表拖放函数注册
            get_family_person_list();
            right_item_callback(); // 右侧人员拖放函数注册
        });
    }

    function get_node_struct(ps, id, p_parent_id) {
        var node = {
            text: "",
            tags: [ps.is_lover],
            backColor: ps.backColor,
            item_attr: {
                id: id,
                p_parent_id: p_parent_id,
                p_name: ps.p_name,
                p_b_date: ps.show_info
            }
        };
        return node;
    }

    // 获取不在家族谱内人员列表
    function get_family_person_list() {
        $.post("./local_logic.php", {
            type: "get_family_person_list",
            family_id: $.cookie("family_id")
        }, function (result) {
            var person_list = eval("(" + result + ")");
            var html = get_family_person_list_html(person_list);
            $("#person_not_in").html(html);
            right_item_callback();
        });
    }

    function get_family_person_list_html(person_list) {
        var html = "";
        $.each(person_list, function (idx, person_info) {
            g_person_info_list[person_info.id] = person_info;
            if (parseInt(person_info.parent_id) == -1) {
                html += get_person_right_html(person_info);
            }
        });
        return html;
    }

    function get_person_style_by_id(person_id) {
        var person_info = g_person_info_list[person_id];
        var person_style = {
            p_name: person_info.firstName + person_info.lastName,
            backColorStyle: "user_header_media_female",
            backColor: "#f26a7e",
            personTypeStyle: "",
            personDeadStyle: "",
            image_url: "./image/female.jpg",
            show_info: "生日：",
            is_lover: person_info.is_lover
        };
        if (person_info.sex == "男性") {
            person_style.backColor = "#5da7c0";
            person_style.backColorStyle = "user_header_media_male";
            person_style.image_url = "./image/male.jpg";
        }
        if (person_info.is_lover == "外戚") {
            person_style.personTypeStyle = "user_header_media_mother";
        }
        if (person_info.is_lover == "配偶") {
            person_style.personTypeStyle = "user_header_media_lover";
        }
        if (!person_info.b_date) {
            person_info.b_date = "不详";
        }
        if (person_info.d_date) {
            person_style.personDeadStyle = "person_dead";
            person_info.d_date = "故于：" + person_info.d_date;
        }
        person_style.show_info += person_info.b_date;
        person_style.show_info += "<span class='ml-2'>" + person_info.d_date + "</span>";
        return person_style;
    }

    function get_person_right_html(person_info) {
        var html = "";
        var ps = get_person_style_by_id(person_info.id);
        html += "<div id='p" + person_info.id + "' p_id='" + person_info.id + "' draggable='true' class='list_person media drag_person_right my-1 " + ps.backColorStyle + "'>";
        html += "<img class='rounded-circle user_header_img' src='" + ps.image_url + "' alt='头像'>";
        html += "<span style='width: 20px;' class='text-center text-white " + ps.personTypeStyle + "'>" + person_info.is_lover + "</span>";
        html += "<div class='media-body p-1 ml-2 " + ps.personDeadStyle + "'>";
        html += "<h6 class='mt-1'>" + ps.p_name + "</h6>";
        html += "<span style='font-size: 14px;'>" + ps.show_info + "</span>";
        html += "</div>";
        html += "</div>";
        return html;
    }

    function right_item_callback() {
        // 开始拖
        $(".drag_person_right").on("dragstart", function (e) {
            e.originalEvent.dataTransfer.setData("obj_add", $(this).attr("id"));
        });
        // 拖动中
//        $(".drag_person_right").on("drag", function (e) {
//        });
        // 允许拖到接收元素上空
        $(".drop_person_right").on("dragover", function (e) {
            e.preventDefault();
        });
        // 在接收元素上释放
        $(".drop_person_right").on("drop", function (e) {
            e.preventDefault();
            var id = e.originalEvent.dataTransfer.getData("obj_add");
            if (!isNaN(id)) { // 从树形结构拖动到右侧
                var person = $("#" + id);
                var id = person.attr("id");
                if (typeof(id) == "undefined") {
                    return;
                }
                var node_id = parseInt(person.attr("data-nodeid"));
                var node_list = $("#family_tree").treeview("getChildren", [node_id, {parent: true}]);
                var _this = $(this);
                $.each(node_list, function (idx, itm) {
                    set_person_relationship("-1", itm.id);
                    _this.append(get_person_right_html(g_person_info_list[itm.id]));
                });
                $("#family_tree").treeview("deleteNode", [node_id]);
            } else { // 右侧内部的拖动
                $(this).append($("#" + id));
            }
            right_item_callback();
        });
    }

    function node_item_callback() {
        $(".item-for-drag").attr("draggable", "true");
        $(".node-family_tree").on("dragover", function (e) {
            e.preventDefault();
        });
        $(".item-for-drag").on("dragstart", function (e) {
            e.originalEvent.dataTransfer.setData("obj_add", $(this).attr("id"));
        });
        // 在接收元素上释放
        $(".node-family_tree").on("drop", function (e) {
            var drop_obj_id = $(this).attr("id");
            e.preventDefault();
            var id = e.originalEvent.dataTransfer.getData("obj_add");
            var person = $("#" + id);
            var drag_obj_is_from_tree = true;
            if (!isNaN(id)) {
                id = parseInt(id);
            } else {
                id = person.attr("id");
                id = id.substring(1, id.length);
                drag_obj_is_from_tree = false;
            }
            if (parseInt(drop_obj_id) != 0) {
                var drop_obj_is_lover = g_person_info_list[drop_obj_id].is_lover;
                if (drop_obj_is_lover == "配偶" || drop_obj_is_lover == "外戚") { // 配偶与外戚 不允许被添加子结点
                    $("#click_formModal_1").click();
                    return false;
                }
            } else {
                var drap_obj_is_lover = g_person_info_list[id].is_lover;
                if (drap_obj_is_lover == "配偶" || drap_obj_is_lover == "外戚") { // 配偶与外戚 不允许被添加到根结点
                    $("#click_formModal_2").click();
                    return false;
                }
            }
            if (drag_obj_is_from_tree) { // 表示树形结构内部拖动
                return false; // 暂时不开发在树形结构内部拖动。因为如把父节点往子节点上拖会造成死锁
                var node_id = parseInt(person.attr("data-nodeid"));
                var p_parent_id = parseInt($(this).attr("id"));
                var p_parent_node_id = parseInt($(this).attr("data-nodeid"));
                var node = $("#family_tree").treeview("getNode", node_id);
                set_person_relationship(p_parent_id, id);
                $("#family_tree").treeview("deleteNode", [node_id]);
                $("#family_tree").treeview("addNode", [p_parent_node_id, {node: node}]);
            } else { // 表示从右侧拖动到树形结构上
                var ps = get_person_style_by_id(id);
                var p_parent_id = parseInt($(this).attr("id"));
                var p_parent_node_id = parseInt($(this).attr("data-nodeid"));
                set_person_relationship(p_parent_id, id);

                var node = {
                    text: "",
                    tags: [ps.is_lover],
                    backColor: ps.backColor,
                    item_attr: {
                        id: id,
                        p_parent_id: p_parent_id,
                        p_name: ps.p_name,
                        p_b_date: ps.show_info
                    }
                };
                $("#family_tree").treeview("addNode", [p_parent_node_id, {node: node}]);
                person.remove();
            }
        });
    }

    function set_person_relationship(parent_id, person_id) {
        $.post("./local_logic.php", {
            type: "set_person_relationship",
            parent_id: parent_id,
            person_id: person_id,
            user_right: $.cookie("user_right")
        });
    }
</script>
</body>
</html>
