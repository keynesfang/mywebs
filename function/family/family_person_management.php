<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link href="../../lib/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <link rel='stylesheet' type='text/css' href='../../css/common.css'>
    <title>家谱网</title>
</head>
<body><!--class="family_bkgd"-->
<div class="container mt-3">
    <div class="row">
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">增加家族成员</h4>
            <form id="input_form" class="needs-validation" novalidate=""></form>
            <div class="d-flex justify-content-end mt-4">
                <button onclick="add_person();" class="btn btn-primary person_add">提交人员信息</button>
                <span class="person_modify none-display">
                    <button id="person_modify_btn" data-toggle='modal' data-target='#formModal' class="btn btn-primary">
                        修改人员信息
                    </button>
                    <button onclick="do_not_modify();" class="btn btn-secondary ml-2">放弃修改</button>
                </span>
            </div>
        </div>
        <div class="col-md-4 order-md-2">
            <h4 class="mb-3">家庭成员列表</h4>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#person_not_in" role="tab" aria-selected="true">未入谱</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#person_in" role="tab" aria-selected="false">已入谱</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="person_not_in" role="tabpanel">
                </div>
                <div class="tab-pane fade" id="person_in" role="tabpanel"></div>
            </div>
        </div>
    </div>
</div>
<script src='../../lib/jquery-3.2.1.min.js'></script>
<script src='../../lib/popper.min.js'></script>
<script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
<script src='../../lib/jquery.cookie.js'></script>
<script src='../../lib/conflict.js'></script>
<script src='../../lib/common.js'></script>
<script src='../../lib/form_creator.js'></script>
<script>
    var g_person_info_list = {};
    var person_info = {
        firstName: {
            conflict: {valueIsNull: "firstName"},
            row: {
                line: "start", // 输出 <div class='row'>
                style: "col-md-6 mb-3",
                label: {text: "姓氏", optional: false},
                group: {},
                input: {type: "text", placeholder: "姓氏"},
                invalid: {style: "invalid-feedback", text: "【姓】不能为空！"}
            },
            show_line: "same_line"
        },
        lastName: {
            conflict: {valueIsNull: "lastName"},
            row: {
                line: "end", // 输出 <div class='row'> 对应的 </div>
                style: "col-md-6 mb-3",
                label: {text: "名字", optional: false},
                group: {},
                input: {type: "text", placeholder: "名字"},
                invalid: {style: "invalid-feedback", text: "【名】不能为空！"}
            },
            show_line: "same_line"
        },
        country: {
            row: {
                line: "start", // 输出 <div class='row'>
                style: "col-md-6 mb-3",
                label: {text: "国籍", optional: false},
                group: {},
                input: {type: "select", options: ["中国", "唐朝", "宋朝", "元朝", "明朝", "清朝"]},
                invalid: {style: "invalid-feedback", text: "请选择正确的国籍哦！"}
            },
            show_line: "same_line"
        },
        sex: {
            row: {
                line: "",
                style: "col-md-2 mb-3",
                label: {text: "性别", optional: false},
                group: {},
                input: {type: "select", options: ["男性", "女性"]},
                invalid: {style: "invalid-feedback", text: "请选择一个性别！"}
            },
            show_line: "same_line"
        },
        tel: {
            row: {
                line: "",
                style: "col-md-4 mb-3",
                label: {text: "联系方式", optional: true},
                group: {},
                input: {type: "text", placeholder: "联系电话"},
                invalid: {style: "invalid-feedback", text: "无效的联系方式！"}
            },
            show_line: "same_line"
        },
        b_date: {
            row: {
                line: "",
                style: "col-md-4 mb-3",
                label: {text: "出生日期", optional: true},
                group: {},
                input: {type: "date"},
                invalid: {style: "invalid-feedback", text: "【出生日期】格式不正确！"}
            },
            show_line: "same_line"
        },
        d_date: {
            row: {
                line: "", // 输出 <div class='row'> 对应的 </div>
                style: "col-md-4 mb-3",
                label: {text: "死亡日期", optional: true},
                group: {},
                input: {type: "date"},
                invalid: {style: "invalid-feedback", text: "【死亡日期】格式不正确！"}
            },
            show_line: "same_line"
        },
        is_lover: {
            row: {
                line: "end", // 输出 <div class='row'> 对应的 </div>
                style: "col-md-4 mb-3",
                label: {text: "人员属性", optional: false},
                group: {},
                input: {type: "select", options: ["本家", "配偶", "外戚"]},
                invalid: {style: "invalid-feedback", text: "【是否配偶】不能为空！"}
            },
            show_line: "same_line"
        },
        career: {
            row: {
                line: "",
                style: "mb-3",
                label: {text: "职业", optional: true},
                group: {img: "oi-briefcase"},
                input: {type: "text", placeholder: "现在从事的职业"},
                invalid: {style: "invalid-feedback", text: "职业信息还没有输入哦！"}
            },
            show_line: "same_line"
        },
        meaning: {
            row: {
                line: "",
                style: "mb-3",
                label: {text: "姓名寓意", optional: true},
                group: {img: "oi-badge"},
                input: {type: "text", placeholder: "描述姓名寓意"},
                invalid: {style: "invalid-feedback", text: "请输入有效的地址格式！"}
            },
            show_line: "other_line"
        },
        email: {
            row: {
                line: "",
                style: "mb-3",
                label: {text: "邮箱", optional: true},
                group: {img: "oi-envelope-closed"},
                input: {type: "text", placeholder: "you@example.com"},
                invalid: {style: "invalid-feedback", text: "请描述姓名的寓意！"}
            },
            show_line: "other_line"
        },
        address: {
            row: {
                line: "",
                style: "mb-3",
                label: {text: "现居地址", optional: true},
                group: {img: "oi-home"},
                input: {type: "text", placeholder: "现在居住的地址"},
                invalid: {style: "invalid-feedback", text: "居住地址还没有输入哦！"}
            },
            show_line: "other_line"
        }
    };
    $(function () {
        var html = person_Info_Input_Form_Html();
        $("#input_form").html(html);
        get_family_person_list_not_in();
        get_family_person_list_in();
    });

    function do_not_modify() {
        $(".person_info").val("");
        $("#country").val("中国");
        $("#sex").val("男性");
        $("#is_lover").val("本家");
        $(".person_add").show();
        $(".person_modify").hide();
    }

    // 获取不在家族谱内人员列表
    function get_family_person_list_not_in() {
        $.post("./local_logic.php", {
            type: "get_family_person_list_not_in",
            family_id: $.cookie("family_id")
        }, function (result) {
            var person_list = eval("(" + result + ")");
            var html = get_family_person_list_html("not in", person_list);
            $("#person_not_in").html(html);
            list_person_click();
        });
    }

    // 获取在家族谱内人员列表
    function get_family_person_list_in() {
        $.post("./local_logic.php", {
            type: "get_family_person_list_in",
            family_id: $.cookie("family_id")
        }, function (result) {
            var person_list = eval("(" + result + ")");
            var html = get_family_person_list_html("in", person_list);
            $("#person_in").html(html);
            list_person_click();
        });
    }

    function list_person_click() {
        $(".list_person").click(function () {
            var id = $(this).attr("p_id");
            var person_info = g_person_info_list[id];
            $.each(person_info, function (attr, value) {
                $("#" + attr).val(value);
            });
            var modify_msg = "确认修改【" + person_info.firstName + person_info.lastName + "】的信息吗？";
            $("#person_modify_btn").attr("onclick", "get_confirm_form_html(\"人员删除\", \"" + modify_msg + "\", \"modify_person\", \"" + id + "\");");
            $(".person_add").hide();
            $(".person_modify").show();
        });
    }

    function get_family_person_list_html(person_type, person_list) {
        var html = "<ul class='list-unstyled drop_person_right h-100'>";
        var delete_html = "";
        $.each(person_list, function (idx, person_info) {
            g_person_info_list[person_info.id] = person_info;
            var p_name = person_info.firstName + person_info.lastName;
            var backColorStyle = "user_header_media_female";
            var personTypeStyle = "";
            var image_url = "./image/female.jpg";
            if (person_info.sex == "男性") {
                backColorStyle = "user_header_media_male";
                image_url = "./image/male.jpg";
            }
            if (person_info.is_lover == "外戚") {
                personTypeStyle = "user_header_media_mother";
            }
            if (person_info.is_lover == "配偶") {
                personTypeStyle = "user_header_media_lover";
            }
            if (!person_info.b_date) {
                person_info.b_date = "不详";
            }
            var delete_msg = "确认从系统中删除【" + p_name + "】吗？";
            if (person_type == "not in") {
                delete_html = "<a href='#' p_id='" + person_info.id + "' data-toggle='modal' data-target='#formModal' onclick='get_confirm_form_html(\"人员删除\", \"" + delete_msg + "\", \"delete_person\", \"" + person_info.id + "\");'><span class='oi oi-circle-x float-right'></span></a>";
            }
            html += "<div p_id='" + person_info.id + "' class='list_person media my-1 " + backColorStyle + "'>";
            html += "<img class='rounded-circle user_header_img' src='" + image_url + "' alt='头像'>";
            html += "<span style='width: 20px;' class='text-center text-white " + personTypeStyle + "'>" + person_info.is_lover + "</span>";
            personTypeStyle = "";
            var other_info = "";
            if (person_info.d_date) {
                personTypeStyle = "person_dead";
                other_info = "故于：" + person_info.d_date;
            }
            html += "<div class='media-body p-1 ml-2 " + personTypeStyle + "'>";
            html += delete_html;
            html += "<h6 class='mt-1'>" + p_name + "</h6>";
            html += "<span style='font-size: 14px;'>生日：" + person_info.b_date + "<span class='ml-2'>" + other_info + "</span></span>";
            html += "</div>";
            html += "</div>";
        });
        html += "</ul>";
        return html;
    }

    function person_Info_Input_Form_Html() {
        var html = "";
        for (var input_id in person_info) {
            if (typeof(person_info[input_id].row) != "undefined") {
                var row = person_info[input_id].row;
                // 生成输入表单的HTML代码
                if (row.line == "start") {
                    html += "<div class='row'>";
                }
                html += "<div class='" + row.style + "'>";
                html += "<label for='" + input_id + "'>" + row.label.text;
                if (row.label.optional) {
                    html += " <span class='text-muted'>(可选)</span>";
                }
                html += "</label>";
                if (!isEmptyObject(row.group)) {
                    html += "<div class='input-group'>";
                    html += "<div class='input-group-prepend'>";
                    html += "<span class='input-group-text'><span class='oi " + row.group.img + "'></span></span>";
                    html += "</div>";
                }
                if (row.input.type == "text") {
                    var default_value = "";
                    if (row.label.text == "姓氏") {
                        default_value = $.cookie("family_surname");
                    }
                    html += "<input type='" + row.input.type + "' class='form-control person_info' id='" + input_id + "' placeholder='" + row.input.placeholder + "' value='" + default_value + "'>";
                } else if (row.input.type == "date") {
                    html += "<input type='" + row.input.type + "' class='form-control person_info' id='" + input_id + "'>";
                } else {
                    html += "<select class='custom-select d-block w-100 person_info' id='" + input_id + "'>";
                    for (let c in row.input.options) {
                        html += "<option value='" + row.input.options[c] + "'>" + row.input.options[c] + "</option>";
                    }
                    html += "</select>";
                }

                html += "<div class='" + row.invalid.style + "'>" + row.invalid.text + "</div>";
                if (!isEmptyObject(row.group)) {
                    html += "</div>";
                }
                html += "</div>";
                if (row.line == "end") {
                    html += "</div>";
                }
            }
        }
        return html;
    }
    function get_person_info_from_form() {
        var has_conflict = false;
        var form_values = {};
        $.each($(".person_info"), function (idx, itm) {
            var id = $(itm).attr("id");
            var cur_value = $.trim($(itm).val());
            form_values[id] = cur_value;
            var _this = this;
            if (!isEmptyObject(person_info[id].conflict)) {
                $.each(person_info[id].conflict, function (idx2, itm2) {
                    if (conflict[idx2](_this)) { // 调用对应的禁则判断函数 True 表禁则 false 表没禁则
                        $("#" + itm2).addClass("is-invalid");
                        has_conflict = true;
                    } else {
                        $("#" + itm2).removeClass("is-invalid");
                    }
                })
            }
        });
        if (has_conflict) {
            return false;
        }
        form_values["family_id"] = $.cookie("family_id");
        return form_values;
    }
    function add_person() {
        var form_values = get_person_info_from_form();
        if (form_values) {
            $.post("../common_logic.php", {
                type: "add_record_to_database",
                tableName: "family_person",
                fields_value_array: form_values
            }, function (result) {
                if (!isNaN(result)) {
                    location.reload();
                } else {
                    alert("录入失败！")
                }
            });
        }
    }
    function delete_person(id) {
        var sql = "id='" + id + "'";
        $.post("../common_logic.php", {
            type: "delete_record_from_database",
            tableName: "family_person",
            sql: sql
        }, function () {
            get_family_person_list_not_in();
            $("#formModal").click();
        });
    }
    function modify_person(id) {
        var condition = "id='" + id + "'";
        var form_values = get_person_info_from_form();
        if (form_values) {
            $.post("../common_logic.php", {
                type: "modify_sql_get_data",
                tableName: "family_person",
                fieldArr: form_values,
                condition: condition
            }, function () {
                window.location.reload();
            });
        }
        $("#formModal").click();
    }
</script>
<div id="formModal" class="modal mt-5" tabindex="-1" role="dialog"></div>
</body>
</html>
