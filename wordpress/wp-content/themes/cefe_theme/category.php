<?php
    /* Template Name: Category */
    define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category</title>

    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/category.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

</head>
<body>

<div class="header">
    <div class="search-area">
        <input type="text" class="search" id="search_products" placeholder="Назва страви">
        <label for="search_products">
            <img src="<?php echo PATH?>/images/search.svg" class="search-icon">
        </label>
    </div>

<!--    only for chefs!!!-->
    <div class="header-btn-style" id="add_dish_btn">
        Додати страву
    </div>
<!---->

    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>

<div class="content">
    <div class="path-section">
        <ul class="breadcrumb">
            <li><a href="menu.html">Меню</a></li>
            <li>Перші страви</li>
        </ul>
    </div>

    <div class="row dishes-list">
        <ul>
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
        </ul>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>
