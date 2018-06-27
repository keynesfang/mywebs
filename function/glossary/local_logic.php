<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_basic_word") {
    $sql = "SELECT * FROM eng_word order by e_classify";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}



