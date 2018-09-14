<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_video_list") {
    $start_index = $_REQUEST['start_index'];
    $page_count = $_REQUEST['page_count'];
    $sql = "SELECT * FROM eng_video LIMIT $start_index, $page_count";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}

if ($type == "get_video_info_by_id") {
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM eng_video where id='$id'";
    $result = $dbop->get_one($sql);
    echo json_encode($result);
}

if ($type == "add_count_by_name") {
    $fieldName = $_REQUEST['fieldName'];
    $condition = $_REQUEST['condition']; // a='b' and c='d'
    $result = $dbop->field_update_itself("eng_video", $fieldName, 1, $condition);
    if ($result) {
        echo "success";
    } else {
        echo "fail";
    }
}



