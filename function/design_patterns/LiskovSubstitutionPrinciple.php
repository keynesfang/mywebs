<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-4.0.0/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../../lib/font-awesome-4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='../../css/common.css'>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/popper.min.js'></script>
    <script src='../../lib/bootstrap-4.0.0/js/bootstrap.min.js'></script>
    <script src='../../lib/common.js'></script>
    <title>Design Patterns</title>
    <script>
        $(function () {
        });
    </script>
</head>
<body>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">设计原则</li>
        <li class="breadcrumb-item active"><span class="mobile_hide">Liskov Substitution Principle：</span>里氏替换原则
        </li>
    </ol>
</nav>
<div class="container-fluid mt-2 max_page_width">
    <div class="row">
        <div class="col-12 mb-3">
            <div id="page_content">
                <div class="card border-primary mb-3">
                    <div class="card-header">定义</div>
                    <div class="card-body text-primary">
                        <h5 class="card-title">所有引用基类的地方必须能透明地使用其子类的对象</h5>
                        <p class="card-text">
                            只要父类能出现的地方子类就可以出现，而且替换为子类也不会产生任何错误或异常，使用者可能根本就不需要知道是父类还是子类。但是，反过来就不行了，有子类出现的地方，父类未必就能适应。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
