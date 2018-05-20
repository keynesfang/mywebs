<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../../lib/font-awesome-4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='../../css/common.css'>
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/popper.min.js'></script>
    <script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../lib/jquery.cookie.js'></script>
    <script src='../../lib/conflict.js'></script>
    <script src='../../lib/form_operator.js'></script>
    <script src='../../lib/common.js'></script>
    <style>
    </style>
    <script>
        $(function () {
            get_family_generation();
        });
        
        function get_family_generation() {
            $.post("./local_logic.php", {
                type: "get_family_generation",
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right")
            }, function (generation_html) {
                $("#generation_div").html(generation_html);
            });
        }
        
        function add_generation() {
            var data = conflict_check("add_generation");
            if(data) {
                var generation = $(".generation").text().split("").join(",");
                generation += "," + data["generation"];
                set_generation(generation);
            }
        }
        
        function modify_generation(self) {
            var index = $(self).attr("index");
            var data = conflict_check("generation" + index);
            var generation = "";
            if(data) {
                $.each($(".generation"), function (idx, itm) {
                    var current_index = $(itm).attr("index");
                    if(current_index == index) {
                        generation += $(".generation" + index).val();
                    } else {
                        generation += $(itm).text();
                    }
                });
                generation = generation.split("").join(",");
                set_generation(generation);
            }
        }

        function delete_generation(self) {
            var index = $(self).attr("index");
            var generation = "";
            $.each($(".generation"), function (idx, itm) {
                var current_index = $(itm).attr("index");
                if(current_index != index) {
                    generation += $(itm).text();
                }
            });
            generation = generation.split("").join(",");
            set_generation(generation);
        }
        
        function set_generation(generation) {
            $.post("./local_logic.php", {
                type: "set_family_generation",
                family_id: $.cookie("family_id"),
                user_right: $.cookie("user_right"),
                generation: generation
            }, function () {
                location.reload();
            });
        }

    </script>
    <title>族谱网</title>
</head>
<body class="family_bkgd">
<div class="container mt-4">
    <div id='generation_div' class="row w-100 m-0">
    </div>
<!--    <div class="row">-->
<!--        <div class="col-md-12">-->
<!--            <table class="table table-dark table-striped table-hover table-responsive">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>字辈</th>-->
<!--                    <th></th>-->
<!--                    <th>Email</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                <tr>-->
<!--                    <td>John</td>-->
<!--                    <td>Doe</td>-->
<!--                    <td>john@example.com</td>-->
<!--                </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--    </div>-->
</div>
</body>
</html>
