<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "add_content_for_grammar") {
    $tableName = "g_grammar";
    $fieldArr = $_REQUEST['fieldArr'];
    $result = $dbop->insert($tableName, $fieldArr);
}

if ($type == "get_content_for_grammar") {
    $ty = $_REQUEST['ty'];
    $idx = $_REQUEST['idx'];
    $sql = "SELECT * FROM g_grammar where ty='$ty' and idx='$idx'";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}

if ($type == "upt_content_for_grammar") {
    $tableName = "g_grammar";
    $fieldArr = $_REQUEST['fieldArr'];
    $condition = $_REQUEST['condition']; // a='b' and c='d'
    $result = $dbop->update($tableName, $fieldArr, $condition);
}



