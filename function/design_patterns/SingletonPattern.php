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
        <li class="breadcrumb-item active">设计模式</li>
        <li class="breadcrumb-item active"><span class="mobile_hide">Singleton Pattern：</span>单例模式
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
                        <p class="card-text">确保某一个类只有一个实例，而且自行实例化并向整个系统提供这个实例。</p>
                    </div>
                </div>
                <div class="card border-primary mb-3">
                    <div class="card-header">代码示例</div>
                    <div class="card-body text-primary">
                        <pre>
public class Singleton {
    private static final Singleton singleton = new Singleton();
    //限制产生多个对象
     private Singleton(){
     }
    //通过该方法获得实例对象
    public static Singleton getSingleton(){
        return singleton;
    }
    //类中其他方法，尽量是static
    public static void doSomething(){
    }
}
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
