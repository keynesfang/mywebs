<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/popper.min.js'></script>
    <script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../lib/common.js'></script>
    <script>
        $(function () {
            $(".url-link").click(function () {
                $(".navbar-toggler").click();
                $("#sub_frame").attr("src", $(this).attr("url-link"));
            });
            $("#sub_frame").css("padding-top", $("#nav_bar").outerHeight());
        });
    </script>
    <title>Design Patterns</title>
</head>
<body id="screen">
<iframe id="sub_frame" src="SingleResponsibilityPrinciple.php" class="border-0 w-100 h-100 fixed-top"
        style="overflow: auto;"></iframe>
<nav id="nav_bar" class="navbar navbar-expand-lg navbar-dark bg-warning fixed-top">
    <!-- Navbar content -->
    <a class="navbar-brand" href="#">Design Patterns</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li style="width: 10px;"></li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="enlighten" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    设计原则
                </a>
                <div class="dropdown-menu" aria-labelledby="enlighten">
                    <a class="dropdown-item url-link" href="#" url-link="./SingleResponsibilityPrinciple.php">单一职责原则</a>
                    <a class="dropdown-item url-link" href="#" url-link="./OpenClosedPrinciple.php">开闭原则</a>
                    <a class="dropdown-item url-link" href="#" url-link="./LiskovSubstitutionPrinciple.php">里氏替换原则</a>
                    <a class="dropdown-item url-link" href="#" url-link="./InterfaceSegregationPrinciple.php">接口隔离原则</a>
                    <a class="dropdown-item url-link" href="#" url-link="./DependenceInversionPrinciple.php">依赖倒置原则</a>
                </div>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="enlighten" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    设计模式
                </a>
                <div class="dropdown-menu" aria-labelledby="enlighten">
                    <a class="dropdown-item url-link" href="#" url-link="./SingletonPattern.php">单例模式</a>
                    <a class="dropdown-item url-link" href="#" url-link="./FactoryPattern.php">工厂模式</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>
