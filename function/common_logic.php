<?php
session_start();
ini_set('memory_limit', '128M');
$type = $_REQUEST['type'];
require_once("DBOP.php");
$dbop = new DB();

function set_session_info($session_info)
{
    foreach ($session_info as $name => $value) {
        $_SESSION[$name] = $value;
    }
}

function get_session_info($session_info_info_struct)
{
    $session_info = array();
    foreach ($session_info_info_struct as $name => $value) {
        $session_info[$name] = $_SESSION[$name];
    }
    return $session_info;
}

function session_operation($method, $session_info) {
    if ($method == "logout") {
        session_destroy();
        echo "";
    } else {
        if ($method == "init") {
            if (isset($_SESSION['init'])) {
                $session_info = get_session_info($session_info);
            } else {
                $_SESSION['init'] = "yes";
                set_session_info($session_info);
                $session_info =  "set_success";
            }
        } else if ($method == "set_info") {
            set_session_info($session_info);
            $session_info =  "set_success";
        } else if ($method == "get_info") {
            $session_info = get_session_info($session_info);
        }
        return $session_info;
    }
}

if ($type == "session_operation") {
    $method = $_REQUEST['method'];
    $session_info = $_REQUEST['session_info'];
    $session_info = session_operation($method, $session_info);
    echo json_encode($session_info);
}

function query_sql_get_data($dbop, $sql)
{
    $data_list = array();
    $result = $dbop->get_all($sql);
    if (count($result) > 0) {
        foreach ($result as $item => $value) {
            array_push($data_list, $value);
        }
    }
    return $data_list;
}

function query_sql_get_data2($dbop, $sql)
{
    $result = $dbop->get_one($sql);
    return $result;
}

// $condition: a='b' and c='d'
function  modify_sql_get_data($dbop, $tableName, $fieldArr, $condition) {
    $result = $dbop->update($tableName, $fieldArr, $condition);
    return $result;
}

function add_record_to_database($dbop, $table_name, $fields_value_array) {
    $result = $dbop->insert($table_name, $fields_value_array);
    if ($result) {
        echo $dbop->insert_id();
    } else {
        echo "fail";
    }
}

function delete_record_from_database($dbop, $tableName, $sql) {
    $result = $dbop->delete($tableName, $sql); // a='b' and c='d'
    return $result;
}

if ($type == "login") {
    $user = $_REQUEST['user'];
    if ($user != "FJ") {
        $_SESSION['login'] = "err";
        echo "fail";
    } else {
        $_SESSION['login'] = "success";
        echo "success";
    }
}

if ($type == "add_record_to_database") {
    $table_name = $_REQUEST['tableName'];
    $fields_value_array = $_REQUEST['fields_value_array']; // fields_value_array[a] = b
    $result = $dbop->insert($table_name, $fields_value_array);
    if ($result) {
        echo $dbop->insert_id();
    } else {
        echo "fail";
    }
}

if ($type == "delete_record_from_database") {
    $tableName = $_REQUEST['tableName'];
    $sql = $_REQUEST['sql'];
    $result = $dbop->delete($tableName, $sql); // a='b' and c='d'
    if ($result) {
        echo "success";
    } else {
        echo "fail";
    }
}

if ($type == "query_sql_get_data") {
    $data_list = array();
    $sql = $_REQUEST['sql'];
    $result = $dbop->get_all($sql);
    if (count($result) > 0) {
        foreach ($result as $item => $value) {
            array_push($data_list, $value);
        }
    }
    echo json_encode($data_list);
}



if ($type == "query_sql_get_data2") {
    $data_list = array();
    $sql = $_REQUEST['sql'];
    $result = $dbop->get_all($sql);
    echo json_encode($result);
}

if ($type == "modify_sql_get_data") {
    $tableName = $_REQUEST['tableName'];
    $fieldArr = $_REQUEST['fieldArr'];
    $condition = $_REQUEST['condition']; // a='b' and c='d'
    $result = $dbop->update($tableName, $fieldArr, $condition);
    if ($result) {
        echo "success";
    } else {
        echo "fail";
    }
}

if ($type == "eng_word_translate") {
    $word = $_REQUEST['word'];
    $url = "https://fanyi.youdao.com/openapi.do?keyfrom=keynes&key=1134658851&type=data&doctype=json&version=1.1&q=" . $word;
    $result = file_get_contents($url);
    echo $result;
}
