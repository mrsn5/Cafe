<?php
    define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/main.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/main_page.less">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <title>Головна</title>
</head>
<body>

<div class="header">
    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH?>/images/exit.svg" alt="Menu"/></a></li>
    </ul>
</div>

<!-- Tab container -->
<div class="tab-container">
    <ul>
        <li style="background-image: linear-gradient(0deg, #50c3ff, #046aec);">
            <a href="menu"><img src="<?php echo PATH?>/images/menu.svg" alt="Menu"/></a>
        </li>
        <li style="background-image: linear-gradient(180deg, #ffd53a, #ea7b00);">
            <a href="orders"><img src="<?php echo PATH?>/images/serving-dish.svg" alt="Orders"/></a>
        </li>
        <li style="background-image: linear-gradient(150deg, #94ffaf, #00bf52);">
            <a href="storage"><img src="<?php echo PATH?>/images/open-box.svg" alt="Storage"/></a>
        </li>
        <li style="background-image: linear-gradient(20deg, #e134b7, #ffd2f6);">
            <a href="deliveries.php"><img src="<?php echo PATH?>/images/truck.svg" alt="Deliveries"/></a>
        </li>
        <li style="background-image: linear-gradient(150deg, rgb(229,173,255), #9532b5);">
            <a href="personnel"><img src="<?php echo PATH?>/images/waiter.svg" alt="Personnel"/></a>
        </li>
        <li style="background-image: linear-gradient(150deg, #ff5a6d, #ff938e);">
            <a href="deliverer"><img src="<?php echo PATH?>/images/farmer.svg" alt="Deliverer"/></a>
        </li>
        <li style="background-image: linear-gradient(150deg, #ff5a6d, #ff938e);">
            <a href="history"><img src="<?php echo PATH?>/images/script.svg" alt="History"/></a>
        </li>
        <li style="background-image: linear-gradient(150deg, #ff5a6d, #ff938e);">
            <a href="statistics"><img src="<?php echo PATH?>/images/analysis.svg" alt="Statistics"/></a>
        </li>
    </ul>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>