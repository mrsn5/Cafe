<?php
/* Template Name: Orders */
define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/orders.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/orders_page.less" />
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/new_order.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <?php wp_head(); ?>
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/orders.less" />
    <title>Замовлення</title>

</head>
<body>

<div class="header">
    <div class="toggle-btn header-btn-style" id="add_order_btn">
        Додати замовлення
    </div>


</div>

<!--    <div class="orders-main">-->
        <div class="orders-container">
            <h3 class="orders-label">Мої замовлення</h3>
            <div class="temp-order-area">
                <h3 class="order-list-label">Не збережені</h3>
                <ul id="unsaved_orders_list">
<!--                    <li class="order-item">--><?php //include('new_order.php');?><!--</li>-->
<!--                    <li class="order-item">--><?php //include('new_order.php');?><!--</li>-->
                </ul>

                <h3 class="order-list-label">Відкриті</h3>
                <!--            <div class="open-orders order-block">-->
                <!--                <h3 class="order-block-label">Відкриті замовлення</h3>-->
                <ul id="open-orders">

                </ul>
                <h3 class="order-list-label">Закриті</h3>
                <!--            </div>-->
                <!--            <div class="closed-orders order-block">-->
                <!--                <ul>-->
                <!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
                <!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
                <!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
                <!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
                <!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
                <!--                </ul>-->
                <!--            </div>-->
            </div>
        </div>
<!--    </div>-->
<!--</div>-->

<?php wp_footer(); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script src="--><?php //echo PATH?><!--/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>-->

</body>
</html>

