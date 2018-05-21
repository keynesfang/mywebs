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
        <li class="breadcrumb-item active"><span class="mobile_hide">Factory Pattern：</span>工厂模式
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
                        <p class="card-text">分为了【简单工厂模式】，【工厂方法模式】，【】。具体往下看。</p>
                    </div>
                </div>
                <div class="card border-primary mb-3">
                    <div class="card-header">简单工厂模式</div>
                    <div class="card-body text-primary">
                        <p class="card-text">对于简单的工厂模式，其实也可以将其理解成为一个创建对象的工具类。</p>
                        <pre>
// 定义工厂
public class SimpleFactory {

    public Object create(Class&lt;?&gt; clazz) {
        if (clazz.getName().equals(Plane.class.getName())) {
            return createPlane();
        } else if (clazz.getName().equals(Broom.class.getName())) {
            return createBroom();
        }
        return null;
    }

    private Broom createBroom() {
        return new Broom();
    }

    private Plane createPlane() {
        return new Plane();
    }
}

// 测试功能
public class FactoryTest {

    public static void main(String[] args) {
        // 简单工厂模式测试
        SimpleFactory simpleFactory = new SimpleFactory();
        Broom broom = (Broom) simpleFactory.create(Broom.class);
        broom.run();
    }
}
                        </pre>
                    </div>
                </div>
                <div class="card border-primary mb-3">
                    <div class="card-header">工厂方法模式</div>
                    <div class="card-body text-primary">
                        <p class="card-text">工厂方法模式定义了一个创建对象的接口，但由子类决定要实例化哪一个。工厂方法让类把实例化推迟到了子类。</p>
                        <img src="image/FactoryMethodPattern.jpg">
                        <p></p>
                        <pre>
// 定义抽象工厂
public abstract class VehicleFactory {
    public abstract Moveable create();
}

// 定义实体工厂
public class BroomFactory extends VehicleFactory {

    @Override
    public Moveable create() {
        return new Broom();
    }
}

// 定义产品接口
public interface Moveable {
    public void run();
}

// 定义实体产品
public class Broom implements Moveable {

    @Override
    public void run() {
        System.out.println("我是Broom。我在飞...");
    }
}

// 测试功能
public class FactoryTest {
    public static void main(String[] args) {
        // 工厂方法模式测试
        VehicleFactory factory = new BroomFactory();
        Moveable moveable = factory.create();
        moveable.run();
    }
}
                        </pre>
                    </div>
                </div>
                <div class="card border-primary mb-3">
                    <div class="card-header">抽象工厂模式</div>
                    <div class="card-body text-primary">
                        <h5 class="card-title">为创建一组相关或相互依赖的对象提供一个接口，而且无需指定他们的具体类</h5>
                        <p class="card-text">
                            从上面的工厂方法中的结构图中，我们可以看到其中的具体工厂A和B是两个完全独立的。两者除了都是抽象工厂的子类，没有任何其他的交集。但是，如果我们有这样一个需求：具体工厂A和B需要生产一些同类型的不同产品。那么我们就可以试试抽象工厂模式。</p>
                        <img src="image/AbstractFactoryPattern.jpg">
                        <p></p>
                        <pre>
// 定义抽象工厂
public abstract class AbstractFactory {

    public abstract Flyable createFlyable();
    public abstract Moveable createMoveable();
    public abstract Writeable createWriteable();
}

// 定义实体工厂
public class Factory1 extends AbstractFactory {

    @Override
    public Flyable createFlyable() {
        return new Aircraft();
    }

    @Override
    public Moveable createMoveable() {
        return new Car();
    }

    @Override
    public Writeable createWriteable() {
        return new Pen();
    }
}

// 定义抽象产品接口
public interface Flyable {

    public void fly(int height);
}

// 定义实体产品
public class Aircraft implements Flyable {

    @Override
    public void fly(int height) {
        System.out.println("我是一架客运机，我目前的飞行高度为：" + height + "千米。");
    }
}

// 测试功能
public class FactoryTest {

    public static void main(String[] args) {
        AbstractFactory factory = new Factory1();
        Flyable flyable = factory.createFlyable();
        flyable.fly(1589);

        Moveable moveable = factory.createMoveable();
        moveable.run(87.6);

        Writeable writeable = factory.createWriteable();
        writeable.write("Hello World.");
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
