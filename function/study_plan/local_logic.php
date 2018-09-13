<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_sound_mark") {
    $sql = "SELECT * FROM eng_ipa";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}

if ($type == "study_process_add") {
    $condition = $_REQUEST['condition']; // a='b' and c='d'
    $result = $dbop->field_update_itself("eng_user", "study", 1, $condition);
    if ($result) {
        echo "success";
    } else {
        echo "fail";
    }
}


