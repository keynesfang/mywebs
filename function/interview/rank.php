<?php
session_start();
require_once("../DBOP.php");
$dbop = new DB();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/common.js'></script>
    <script src='../../lib/bootstrap-3.3.7/js/bootstrap.min.js'></script>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='./css/interview.css'>
    <title>面试</title>
    <script>
        var select_id = "";
        $(function () {
            var dialog_html = confirm_dialog_html();
            $("#dlg").html(dialog_html);
        });

        function delete_record(no_in_database) {
            select_id = no_in_database;
            $('#confirm_dlg').modal();
        }

        function do_action() {
            if (select_id != "") {
                $.post("../common_logic.php", {
                        type: "delete_record_from_database",
                        tableName: "interview",
                        sql: "no='" + select_id + "'"
                    },
                    function () {
                        location.reload();
                    }
                );
            }
        }
    </script>
</head>
<body id='body'>
<?php
if (!isset($_SESSION['login']) or $_SESSION['login'] != 'success') {
    echo <<<HTML
	<SCRIPT type=text/javascript> <!-- 
		window.location.href='./login.php'; //--> 
		</script>
HTML;
}
?>
<div id="dlg"></div>
<div id='app' style='width: 100%;'>
    <div id='title' style='padding: 5px; box-sizing: border-box; text-align: right; margin-right: 1%; font-size: 16px;'>
        <span style="margin-right: 20px;"><a style="font-weight: bold; color: #f2dede;"
                                             href="./index.php">面试录入</a></span>
        <span>面试排名</span>
    </div>
    <table style="width: 100%;">
        <thead>
        <tr>
            <th>排名</th>
            <th>姓名</th>
            <th>意向</th>
            <th>分数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $dbop->get_all("select * from interview");
        $no = 1;
        foreach ($result as $i => $value) {
            $id = $result[$i]['no'];
            $name = $result[$i]['name'];
            $purpose = $result[$i]['purpose'];
            $score = $result[$i]['score'];
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td><a style='color: gold; font-weight: bold;' href='./detail.php?id=$id'>$name</a></td>";
            echo "<td>$purpose</td>";
            echo "<td>$score</td>";
            echo "<td><span onclick='delete_record($id);'>删除</span></td>";
            $no = $no + 1;
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
