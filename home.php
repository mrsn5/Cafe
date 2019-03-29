<?php

define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/main_page.less">

    <?php wp_head(); ?>
    <title>Головна</title>
</head>
<body class="main-page-body">

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
            <a href="deliveries"><img src="<?php echo PATH?>/images/truck.svg" alt="Deliveries"/></a>
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

<?php wp_footer(); ?>
</body>
</html>