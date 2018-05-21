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
        <li class="breadcrumb-item active"><span class="mobile_hide">Single Responsibility Principle：</span>单一职责原则
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
                        <h5 class="card-title">一个类应该只有一个发生变化的原因</h5>
                        <p class="card-text">
                            一个类，应该只有一个职责。如果一个类有一个以上的职责，这些职责就耦合在了一起。当一个职责发生变化时，可能会影响其它的职责。此原则的核心就是解耦和增强内聚性。</p>
                    </div>
                </div>
                <div class="card border-danger mb-3">
                    <div class="card-header">问题的由来</div>
                    <div class="card-body text-danger">
                        <h5 class="card-title">多职责耦合会影响复用性</h5>
                        <p class="card-text">
                            T负责两个不同的职责：职责P1，职责P2。当由于职责P1需求发生改变而需要修改类T时，有可能会导致原本运行正常的职责P2功能发生故障。也就是说职责P1和P2被耦合在了一起。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
