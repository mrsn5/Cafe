<?php
    /* Template Name: Category */
    define("PATH", get_template_directory_uri());
    define("Theme_Name", home_url());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/category.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <?php wp_head(); ?>
    <title>Category</title>
</head>
<body>

<div class="header">
    <div class="search-area">
        <input type="text" class="search" id="search_products" placeholder="Назва страви">
        <label for="search_products">
            <img src="<?php echo PATH?>/images/search.svg" class="search-icon" id="search_btn">
        </label>
    </div>

</div>

<div class="content">
    <div class="path-section">
        <ul class="breadcrumb">
            <li><a id="menu_link" href="">меню</a></li>
            <li id="category_name">Перші страви</li>
        </ul>

        <div class="btn-container">
            <div class="show_items_btn">
                <span class="in-menu" id="in_menu">В меню</span>
            </div>
            <div class="show_items_btn">
                <span class="not-in-menu" id="not_in_menu">Не в меню</span>
            </div>
            <div class="show_items_btn">
                <span class="all-dishes" id="all_dishes">Всі страви</span>
            </div>
        </div>

    </div>

    <div class="row dishes-list">
        <ul id="dishes_container">
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
            <li class="dish"><?php include('dish_card.php');?></li>
        </ul>
    </div>
</div>

<?php wp_footer(); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script src="--><?php //echo PATH?><!--/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>-->
</body>
</html>

