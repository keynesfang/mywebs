<?php
require_once("../common_logic.php");
$type = $_REQUEST['type'];

if ($type == "add_message_to_database") {
    $fields_value_array = $_REQUEST['fields_value_array']; // fields_value_array[a] = b
    $result = $dbop->insert("eng_message", $fields_value_array);
    if ($result) {
        echo $dbop->insert_id();
    } else {
        echo "fail";
    }
}



