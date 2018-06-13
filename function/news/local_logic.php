<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_un_detail_news_list") {
    $sql = "SELECT * FROM english_news WHERE mytranslate=1 and detail_author IS NULL order by news_date DESC";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}



