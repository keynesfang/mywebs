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
        <li class="breadcrumb-item active"><span class="mobile_hide">Dependence Inversion Principle：</span>依赖倒置原则
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
                        <h5 class="card-title">程序要依赖于抽象接口，不要依赖于具体实现</h5>
                        <p class="card-text">要求对抽象进行编程，不要对实现进行编程，这样就降低了客户与实现模块间的耦合。</p>
                        <ul>
                            <li>模块间的依赖通过抽象发生，实现类之间不发生直接的依赖关系，其依赖关系是通过接口或抽象类产生的；</li>
                            <li>接口或抽象类不依赖于实现类；</li>
                            <li>实现类依赖接口或抽象类。</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
