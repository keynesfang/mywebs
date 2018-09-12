<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "get_sound_mark") {
    $sql = "SELECT * FROM eng_ipa";
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}



