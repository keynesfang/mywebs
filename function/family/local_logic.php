<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

function get_family_info($dbop, $family_type, $family_id)
{
    $_SESSION[$family_type . "_info"] = "";
    if ($family_id != "") {
        $sql = "select * from family where id='$family_id'";
        $data_list = query_sql_get_data($dbop, $sql);
        if ($data_list) {
            $_SESSION[$family_type . "_info"] = $data_list[0];
        }
    }
}

if ($type == "get_family_list") {
    $sql = $_REQUEST['sql'];
    $count_sql = $_REQUEST['count_sql'];
    $data_array = array();
    $data_array["count"] = query_sql_get_data($dbop, $count_sql)[0]["count"];
    $data_array["data_list"] = query_sql_get_data($dbop, $sql);
    echo json_encode($data_array);
}

if ($type == "user_regist_callback") {
    $user_id = $_REQUEST['user_id'];
    $sql = "select * from family_user where id='$user_id'";
    $loginName = query_sql_get_data($dbop, $sql)[0]["loginName"];
    echo $loginName;
}

if ($type == "get_my_family_list") {
    $user_id = $_REQUEST['user_id'];
    $sql = "select family_user_right.user_right as user_right, family.id as family_id, family.surname as surname, family.name as name from family_user_right, family where family_user_right.user_id='$user_id' and family_user_right.family_id=family.id";
    $my_family_list = query_sql_get_data($dbop, $sql);
    echo json_encode($my_family_list);
}
// user_right: 5 为创建者 4 为管理者 1为普通权限  0 为申请中 -1为撤回申请 -2为申请被拒绝 -3为被拉黑

if ($type == "create_family_callback") {
    $family_id = $_REQUEST['family_id'];
    $user_id = $_REQUEST['user_id'];
    $fields_value_array = array("family_id" => $family_id, "user_id" => $user_id, "user_right" => 5);
    add_record_to_database($dbop, "family_user_right", $fields_value_array);
}

if ($type == "apply_family_action") {
    $family_id = $_REQUEST['family_id'];
    $user_id = $_REQUEST['user_id'];
    $fields_value_array = array("family_id" => $family_id, "user_id" => $user_id, "user_right" => 0);
    add_record_to_database($dbop, "family_user_right", $fields_value_array);
}

if ($type == "rollback_family_action") {
    $family_id = $_REQUEST['family_id'];
    $user_id = $_REQUEST['user_id'];
    $result = delete_record_from_database($dbop, "family_user_right", "family_id='$family_id' and user_id='$user_id'");
    echo $result;
}

if ($type == "init_normal_menu") {
    $html = "<li class='nav-item active'><a class='nav-link' href='#' link='./login.php'>首页</a></li>";
    $html .= "<li class='nav-item'><a class='nav-link' href='#' link='./chinese_surname.php'>百家姓</a></li>";
    echo $html;
}

if ($type == "init_family_menu") {
    $user_right = (int)$_REQUEST['user_right'];
    $html = "<li class='nav-item'><a class='nav-link' href='#' link='./login.php'>首页</a></li>";
    if ($user_right > 0) {
        $html .= "<li class='nav-item active'><a class='nav-link' href='#' link='./family_user.php'>族谱用户</a></li>";
        $html .= "<li class='nav-item'><a class='nav-link' href='#' link='./family_generation2.php'>家族字辈</a></li>";
    }
    if ($user_right > 1) {
        $html .= "<li class='nav-item'><a class='nav-link' href='#' link='./family_person_management.php'>族人管理</a></li>";
        $html .= "<li class='nav-item'><a class='nav-link' href='#' link='./add_person_in_family2.php'>族谱管理</a></li>";
    }
    if ($user_right > 0) {
        $html .= "<li class='nav-item'><a class='nav-link' href='#' link='./family_browse.php'>族谱一览</a></li>";
    }
    echo $html;
}

if ($type == "change_user_type") {
    $family_id = $_REQUEST['family_id'];
    $user_id = $_REQUEST['user_id'];
    $user_right = (int)$_REQUEST['user_right'];
    $user_type = $_REQUEST['user_type'];
    if ($user_right == 5) { // 当前用户为创建者时，才能执行该操作
        $user_right_arr = array("user_right" => $user_type);
        modify_sql_get_data($dbop, "family_user_right", $user_right_arr, "family_id='$family_id' and user_id='$user_id'");
    }
}

if ($type == "get_user_by_type") {
    $family_id = $_REQUEST['family_id'];
    $user_right = (int)$_REQUEST['user_right'];
    $user_type = (int)$_REQUEST['user_type'];
    $sql = "select family_user.id as id, loginName from family_user_right, family_user where family_id='$family_id' and user_right='$user_type' and family_user_right.user_id = family_user.id";
    $user_list = query_sql_get_data($dbop, $sql);
    $html = "";
    if ((int)$user_type == 5) {
        $html = $user_list[0]["loginName"];
    } else {
        if (count($user_list) < 1) {
            $html .= "<div class='card-body border-top border-info'>";
            $html .= "<h5 class='card-title d-inline-block'>未查到相关人员</h5>";
            $html .= "</div>";
        } else {
            foreach ($user_list as $item => $value) {
                $html .= "<div class='card-body border-top border-info'>";
                $html .= "<h5 class='card-title d-inline-block'>" . $value['loginName'] . "</h5>";
                $user_id = $value['id'];
                if ($user_right == 5 and $user_type == 4) // 登陆者为创建者，查询的为管理员
                {
                    $html .= "<a href='#' class='card-link float-right' onclick='change_user_type(\"$user_id\", \"1\");'>踢出修谱会</a>";
                }
                if ($user_right == 5 and $user_type == 1) // 登陆者为创建者，查询的为管理员
                {
                    $html .= "<a href='#' class='card-link float-right' onclick='change_user_type(\"$user_id\", \"-2\");'>劝退</a>";
                    $html .= "<a href='#' class='card-link float-right mr-2' onclick='change_user_type(\"$user_id\", \"4\");'>入会</a>";
                }
                if ($user_right == 5 and $user_type == 0) // 登陆者为创建者，查询的为申请
                {
                    $html .= "<a href='#' class='card-link float-right' onclick='change_user_type(\"$user_id\", \"-1\");'>拒绝</a>";
                    $html .= "<a href='#' class='card-link float-right mr-2' onclick='change_user_type(\"$user_id\", \"1\");'>同意</a>";
                }
                if ($user_right == 5 and ($user_type == -1 or $user_type == -2)) // 登陆者为创建者，查询的为申请
                {
                    $html .= "<a href='#' class='card-link float-right' onclick='change_user_type(\"$user_id\", \"1\");'>召回</a>";
                }
                $html .= "</div>";
            }
        }
    }
    echo $html;
}

if ($type == "get_family_generation2") {
    $family_id = $_REQUEST['family_id'];
    $sql = "select generation from family where id='$family_id'";
    $generation = query_sql_get_data($dbop, $sql)[0]["generation"];
    echo $generation;
}


if ($type == "get_family_generation") {
    $family_id = $_REQUEST['family_id'];
    $user_right = (int)$_REQUEST['user_right'];
    $sql = "select generation from family where id='$family_id'";
    $generation = query_sql_get_data($dbop, $sql)[0]["generation"];
    $generation_html = "";
    $generation_arr = explode(",", $generation);
    foreach ($generation_arr as $item => $value) {
        if ($value == "") {
            continue;
        }
        if ($user_right > 1) {
            $generation_html .= "<div class='col-md-3 p-0'>";
            $generation_html .= "<div class='card' style='position: relative;'>";
            $generation_html .= "<div class='generation' index='$item'>$value</div>";
            $generation_html .= "<img class='card-img-top' src='./image/generation.jpg' alt='Card image cap'>";
            $generation_html .= "<div class='card-body'>";
            $class_name = "generation" . $item;
            $generation_html .= "<input type='text' class='form-control mb-2 $class_name' field_name='generation' conflict='valueIsNull,valueLengthTooLong' limit_length='1' invalid_feedback='字辈不能为空！_字辈只能是1个字！' placeholder='输入修改字辈'>";
            $generation_html .= "<div class='invalid-feedback'></div>";
            $generation_html .= "<button class='btn btn-outline-danger float-right' index='$item' onclick='delete_generation(this);' type='button'>删除</button>";
            $generation_html .= "<button class='btn btn-outline-primary float-right mr-2' index='$item' onclick='modify_generation(this);' type='button'>修改</button>";
            $generation_html .= "</div>";
            $generation_html .= "</div>";
            $generation_html .= "</div>";
        } else {
            $generation_html .= "<div class='col-md-3 p-0'>";
            $generation_html .= "<div class='card' style='position: relative;'>";
            $generation_html .= "<div class='generation'>$value</div>";
            $generation_html .= "<img class='card-img-top' src='./image/generation.jpg' alt='Card image cap'>";
            $generation_html .= "</div>";
            $generation_html .= "</div>";
        }
    }
    if ($user_right > 1) {
        $generation_html .= "<div class='col-md-3 p-0'>";
        $generation_html .= "<div class='card'>";
        $generation_html .= "<img class='card-img-top' src='./image/generation_new.jpg' alt='Card image cap'>";
        $generation_html .= "<div class='card-body'>";
        $generation_html .= "<input id='new_generation' type='text' class='add_generation form-control mb-2' field_name='generation' conflict='valueIsNull,valueLengthTooLong' limit_length='1' invalid_feedback='字辈不能为空！_字辈只能是1个字！' placeholder='输入新增字辈'>";
        $generation_html .= "<div class='invalid-feedback'></div>";
        $generation_html .= "<button class='btn btn-outline-primary float-right' type='button' onclick='add_generation();'>新增</button>";
        $generation_html .= "</div>";
        $generation_html .= "</div>";
        $generation_html .= "</div>";
    }
    echo $generation_html;
}

if ($type == "set_family_generation") {
    $family_id = $_REQUEST['family_id'];
    $user_right = (int)$_REQUEST['user_right'];
    if ($user_right > 1) {
        $generation = array("generation" => $_REQUEST['generation']);
        modify_sql_get_data($dbop, "family", $generation, "id='$family_id'");
    }
}

if ($type == "get_family_person_list") {
    $family_id = $_REQUEST['family_id'];
    $sql = "select * from family_person where family_id='$family_id'";
    $person_list = query_sql_get_data($dbop, $sql);
    echo json_encode($person_list);
}

if ($type == "get_family_event") {
    $family_id = $_REQUEST['family_id'];
    $person_id = $_REQUEST['person_id'];
    $user_right = (int)$_REQUEST['user_right'];
    if ($user_right > 0) {
        $sql = "select * from family_event where family_id='$family_id' and person_id='$person_id'";
        $event_list = query_sql_get_data($dbop, $sql);
        echo json_encode($event_list);
    }
}

if ($type == "get_family_person_list_in") {
    $family_id = $_REQUEST['family_id'];
    $sql = "select * from family_person where family_id='$family_id' and parent_id!=-1";
    $person_list = query_sql_get_data($dbop, $sql);
    echo json_encode($person_list);
}

if ($type == "get_family_person_list_not_in") {
    $family_id = $_REQUEST['family_id'];
    $sql = "select * from family_person where family_id='$family_id' and parent_id=-1";
    $person_list = query_sql_get_data($dbop, $sql);
    echo json_encode($person_list);
}

function set_person_relationship($dbop, $user_right, $parent_id, $person_id, $family_id)
{
    if ($user_right > 1) {
        $user_relationship_arr = array("parent_id" => $parent_id);
        modify_sql_get_data($dbop, "family_person", $user_relationship_arr, "family_id='$family_id' and id='$person_id'");
    }
}

if ($type == "set_person_relationship") {
    $user_right = (int)$_REQUEST['user_right'];
    $parent_id = $_REQUEST['parent_id'];
    $person_id = $_REQUEST['person_id'];
    $family_id = $_REQUEST['family_id'];
    set_person_relationship($dbop, $user_right, $parent_id, $person_id, $family_id);
}

if ($type == "set_person_list_relationship") {
    $user_right = (int)$_REQUEST['user_right'];
    $person_id_list = $_REQUEST['person_id_list'];
    $family_id = $_REQUEST['family_id'];
    $user_relationship_arr = array("parent_id" => -1);
    for ($i = 0; $i < count($person_id_list); $i++) {
        modify_sql_get_data($dbop, "family_person", $user_relationship_arr, "family_id='$family_id' and id='$person_id_list[$i]'");
    }
}

if ($type == "init_family_list") {
    $family_id = (int)$_REQUEST['family_id'];
    $user_right = (int)$_REQUEST['user_right'];
    if ($user_right > 1) {
        $user_relationship_arr = array("parent_id" => -1);
        modify_sql_get_data($dbop, "family_person", $user_relationship_arr, "family_id='$family_id'");
    }
}