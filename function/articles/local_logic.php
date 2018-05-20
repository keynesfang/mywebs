<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "show_article") {
    $article_id = $_REQUEST['article_id'];
    $sql = "select * from g_articles where id='$article_id'";
    $data_obj = query_sql_get_data2($dbop, $sql);
    $viewcount = $data_obj["viewcount"] = $data_obj["viewcount"] + 1;
    modify_sql_get_data($dbop, "g_articles", ["viewcount" => $viewcount], "id='$article_id'");
    echo json_encode($data_obj);
}