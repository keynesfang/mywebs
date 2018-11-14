<?php
require_once("./function/DBOP.php");
$dbop = new DB();
$req_type = $_REQUEST['req_type'];

if ($req_type == "login") {
    $code = $_REQUEST['code'];
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx63e23c9d69dc4b69&secret=b9c7d6af251f392079ac27e1dd56a9d0&js_code=" . $code . "&grant_type=authorization_code";

    $res = file_get_contents($url); //获取文件内容或获取网络请求的内容
    $result = json_decode($res);
    $wx_result = array();
    if ($result->openid) {
        $wx_result["openid"] = $result->openid;
        $nickName = $_REQUEST['nickName'];
        $gender = $_REQUEST['gender'];
        $avatarUrl = $_REQUEST['avatarUrl'];
        $latitude = $_REQUEST['latitude'];
        $longitude = $_REQUEST['longitude'];
        $initdate = date("Y-m-d");
        $fieldArr = array("openid" => $result->openid, "nickName" => $nickName, "gender" => $gender, "avatarUrl" => $avatarUrl, "latitude" => $latitude, "longitude" => $longitude, "initdate" => $initdate, "lastdate" => $initdate);
        $login_type = add_user($dbop, $result->openid, $fieldArr);
        if ($login_type == "update") {
            $user_info = $dbop->get_one("select * from wx_user where openid='$result->openid'");
            $wx_result["is_pos_share"] = $user_info["is_pos_share"];
        }
    } else {
        $wx_result["openid"] = "openid_error";
    }
    echo json_encode($wx_result);
}

if ($req_type == "share_position") {
    $tableName = "wx_user";
    $openid = $_REQUEST['openid'];
    $is_pos_share = $_REQUEST['is_pos_share'];
    $fieldArr = array("is_pos_share" => $is_pos_share);
    $dbop->update($tableName, $fieldArr, "openid='$openid'");
}

if ($req_type == "get_around") {
    $openid = $_REQUEST['openid'];
    $users_info = $dbop->get_all("select * from wx_user where openid<>'$openid' and is_pos_share='on'");
    echo json_encode($users_info);
}

function add_user($dbop, $openid, $fieldArr)
{
    $tableName = "wx_user";
    $result = $dbop->get_all("select * from $tableName where openid='$openid'");
    if (count($result) > 0) {
        return "update";
    } else {
        $dbop->insert($tableName, $fieldArr);
        return "add";
    }
}