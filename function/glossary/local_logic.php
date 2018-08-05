<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_basic_word") {
    $word_type = $_REQUEST['word_type'];
    $sql = "SELECT * FROM eng_word where e_classify='$word_type'";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}

if ($type == "get_word_by_type") {
    $word_type = $_REQUEST['word_type'];
    $current_word_index = $_REQUEST['current_word_index'];
    $cur_page_word_count = $_REQUEST['cur_page_word_count'];
    $word_type = "eng_" . $word_type;
    $sql = "SELECT id, word FROM $word_type limit $current_word_index, $cur_page_word_count";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}



