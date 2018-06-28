<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_basic_word") {
    $word_type = $_REQUEST['word_type'];
    $sql = "SELECT * FROM eng_word where e_classify='$word_type'";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}



