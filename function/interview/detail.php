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
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='./css/interview.css'>
    <title>面试</title>
    <script>
        $(function () {

        });
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
<div id='app' style='width: 100%;'>
    <div id='title' style='padding: 5px; box-sizing: border-box; text-align: right; margin-right: 1%; font-size: 16px;'>
        <span style="margin-right: 20px;"><a style="font-weight: bold; color: #f2dede;"
                                             href="./index.php">面试录入</a></span>
        <span style="margin-right: 20px;"><a style="font-weight: bold; color: #f2dede;"
                                             href="./rank.php">面试排名</a></span>
        <span>面试详情</span>
    </div>
    <table style="width: 100%;">
        <thead>
        <tr>
            <th>项目</th>
            <th>值</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $id = explode("=", $_SERVER["QUERY_STRING"])[1];
        $result = $dbop->get_one("select * from interview where no=$id");
        $name = $result['name'];
        $sex = $result['sex'];
        $education = $result['education'];
        $purpose = $result['purpose'];
        $jpn = $result['jpn'];
        $eng = $result['eng'];
        $ability = $result['ability'];
        $level = $result['level'];
        $express = $result['express'];
        $innovate = $result['innovate'];
        $nature = $result['nature'];
        $appearance = $result['appearance'];
        $comment = $result['comment'];
        $score = $result['score'];
        echo "<tr>";
        echo "<td>姓名</td>";
        echo "<td>$name</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>性别</td>";
        echo "<td>$sex</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>学历</td>";
        echo "<td>$education</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>意向</td>";
        echo "<td>$purpose</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>日语</td>";
        echo "<td>$jpn</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>英语</td>";
        echo "<td>$eng</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>技术方向</td>";
        echo "<td>$ability</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>技术水平</td>";
        echo "<td>$level</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>表达能力</td>";
        echo "<td>$express</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>创新能力</td>";
        echo "<td>$innovate</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>性格</td>";
        echo "<td>$nature</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>颜值</td>";
        echo "<td>$appearance</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>其它</td>";
        echo "<td>$comment</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>得分</td>";
        echo "<td>$score</td>";
        echo "</tr>";
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
