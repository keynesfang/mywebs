<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_un_detail_news_list") {
    $sql = "SELECT id, title, news_date FROM english_news WHERE mytranslate=1 and detail_author IS NULL order by news_date DESC";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}

if ($type == "get_news_detail") {
    $news_id = $_REQUEST['news_id'];
    $sql = "SELECT * FROM english_news WHERE id='$news_id'";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}

if ($type == "add_explain_for_news") {
    $tableName = "english_news";
    $fieldArr = $_REQUEST['fieldArr'];
    $condition = $_REQUEST['condition']; // a='b' and c='d'
    $result = $dbop->update($tableName, $fieldArr, $condition);
    if ($result) {
        echo "success";
    } else {
        echo "fail";
    }
}



