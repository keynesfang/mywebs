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



