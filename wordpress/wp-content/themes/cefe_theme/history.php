<?php
    /* Template Name: History */
    define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/orders.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/history.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>
    <title>Замовлення</title>

</head>
<body>

<div class="header">
    <div class="search-btn header-btn-style" id="search_orders_btn">
        Пошук
    </div>

    <div class="today-order-btn header-btn-style" id="today_orders_btn">
        Замовлення на сьогодні
    </div>

    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>

<div class="main">

    <div class="search-area">
        <form>
            <span class="label-header">
                Пошук
                <img src="<?php echo PATH?>/images/search.svg" class="search-icon">
            </span>
            <div class="search-date search-block">
                <span class="label">
                    В період
                </span>
                <label>
                    з
                    <input type="date">
                </label>
                <label>
                    по
                    <input type="date">
                </label>
            </div>
        </form>

        <div class="search-worker search-block">
            <span class="label">Робітник</span>
            <input type="text" placeholder="Ім'я робітника">
        </div>
    </div>

    <div class="orders-container">

        <h3 class="orders-label">
            Замовлення на сьогодні
            <span>5</span>
        </h3>

<!-- only for accountant-->
        <div class="general-price">
            <span>СУМА</span>
            <span>390 грн</span>
        </div>
<!-- -->

        <div class="temp-order-area">
            <ul>
                <li class="order-item"><?php include('orders.php');?></li>
                <li class="order-item"><?php include('orders.php');?></li>
                <li class="order-item"><?php include('orders.php');?></li>
                <li class="order-item"><?php include('orders.php');?></li>
                <li class="order-item"><?php include('orders.php');?></li>
            </ul>
        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo PATH?>/js/orders.js"></script>
<script type="text/javascript" src="<?php echo PATH?>/js/general_functions.js"></script>
</body>
</html>


