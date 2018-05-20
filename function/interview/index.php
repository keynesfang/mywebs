<?php
session_start();
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
        var question = {
            "姓名_name": "",
            "性别_sex": ["男", "女"],
            "学历_education": ["专科", "本科"],
            "意向_purpose": ["开发", "测试", "都可"],
            "日语_jpn": ["不会", "一般_1", "不错_2"],
            "英语_eng": ["不会", "一般_1", "不错_2"],
            "技术方向_ability": "",
            "技术水平_level": ["皮毛", "一般_1", "不错_2"],
            "表达能力_express": ["一般_1", "较好_2"],
            "创新能力_innovate": ["一般_1", "较好_2"],
            "性格_nature": ["内向_1", "活泼_2"],
            "颜值_appearance": ["普通", "较好", "逆天"],
            "其它_comment": ""
        };
        $(function () {
            var content_html = "";
            for (let item in question) {
                var name = item.split("_")[0];
                var id = item.split("_")[1];
                content_html += "<div class='aspect'>";
                content_html += "<div class='title'>";
                content_html += name;
                content_html += "</div>";
                content_html += "<div class='content'>";
                if (typeof(question[item]) == "string") {
                    content_html += "<input id='" + id + "' type='text' style='padding-left: 5px; width: 100%; background-color: #000;'>"
                } else {
                    for (let option in question[item]) {
                        let width_ratio = parseInt(100 / question[item].length);
                        if (option == 0) {
                            content_html += "<div style='display: inline-block; width:" + width_ratio + "%;'><input checked type='radio' value='" + question[item][option] + "' name='" + id + "' style='background-color: #000; margin-right: 5px;'>" + question[item][option].split("_")[0] + "</div>";
                        } else {
                            content_html += "<div style='display: inline-block; width:" + width_ratio + "%;'><input type='radio' value='" + question[item][option] + "' name='" + id + "' style='background-color: #000; margin-right: 5px;'>" + question[item][option].split("_")[0] + "</div>";
                        }
                    }
                }
                content_html += "</div>";
                content_html += "</div>";
            }
            content_html += "<div class='aspect'>";
            content_html += "<button onclick='save_data();' style='width: 100%; color: #000; height: 50px;'>提 交</button>";
            content_html += "</div>";
            $("#basic").html(content_html);
        });

        function save_data() {
            var score = 0;
            var info = {};
            for (let item in question) {
                var value = "";
                var id = item.split("_")[1];
                if (typeof(question[item]) == "string") {
                    value = $("#" + id).val();
                } else {
                    value = $("input[name='" + id + "']:checked").val().split("_");
                    if (value.length == 2) {
                        score += parseInt(value[1]);
                    }
                    value = value[0];
                }
                info[id] = value;
            }
            score = parseInt(score / 12 * 100);
            var date = new Date();
            info["dodate"] = date.toLocaleDateString();
            info["score"] = score;
            $.post("../common_logic.php", {
                type: "add_record_to_database",
                tableName: "interview",
                fields_value_array: info
            }, function(result)
            {
                if(!isNaN(result)) {
                    location.reload();
                } else {
                    alert("录入失败！")
                }
            });
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
<div id='app' style='width: 100%;'>
    <div id='title' style='padding: 5px; box-sizing: border-box; text-align: right; margin-right: 1%; font-size: 16px;'>
        <span style="margin-right: 20px;"><a style="font-weight: bold; color: #f2dede;" href="./rank.php">面试详情</a></span>
        <span style="margin-right: 20px;">面试要点</span>
        <span><a href="/index.html">返回首页</a></span>
    </div>
    <div id="basic">
    </div>
</div>
</body>
</html>
