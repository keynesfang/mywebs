<?php
require_once("./function/common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_all_type_article") {
    $data_array = array();
    $sql = "SELECT * FROM g_articles WHERE tp='热门话题' ORDER BY article_date DESC LIMIT 1";
    $data_array["hot"] = query_sql_get_data($dbop, $sql)[0];
    $sql = "SELECT * FROM g_articles WHERE tp='涨知识啦' ORDER BY article_date DESC LIMIT 1";
    $data_array["knowledge"] = query_sql_get_data($dbop, $sql)[0];
    $sql = "SELECT * FROM g_articles WHERE tp='智游人生' ORDER BY article_date DESC LIMIT 1";
    $data_array["game"] = query_sql_get_data($dbop, $sql)[0];
    echo json_encode($data_array);
}