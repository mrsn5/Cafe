<?php
    /* Template Name: Menu */
    define("PATH", get_template_directory_uri());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/main.css">-->

    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/menu.less">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <?php wp_head(); ?>

    <title>Меню</title>
</head>
<body>



<!--1. Холодные закуски:-->
<!--рыбные,-->
<!--мясные,-->
<!--овощные.-->
<!--2. Салаты :-->
<!--рыбные,-->
<!--мясные,-->
<!--овощные.-->
<!--3. Горячие закуски :-->
<!--рыбные,-->
<!--мясные,-->
<!--овощные.-->
<!--4. Первые блюда :-->
<!--Сначала бульоны,-->
<!--Заправочные супы (борщи, щи, солянка)-->
<!--Пюреобразные супы овощные, из курицы-->
<!--5. Вторые горячие блюда (основные)-->
<!--Рыбные-->
<!--Отварная рыба или припущенная-->
<!--Рыба в соусе-->
<!--Жаренные-->
<!--Запеченные-->
<!--Мясные основные блюда-->
<!--Натуральные блюда из мяса (бифштекс, стейк различной степени прожарки)-->
<!--Блюда под соусом (бефстроганов)-->
<!--Блюда из птицы и дичи (рябчики, цыплята)-->
<!--Овощные блюда-->
<!--6. Гарниры-->

<!--7. Десерты-->
<!--8. Напитки-->

<div class="header">
    <!--    only for chefs!!!-->
    <div class="header-btn-style" id="add_dish_btn">
        Додати страву
    </div>
    <!---->

    <div class="top-btn header-btn-style category-name" id="top_list">
        Топ ліст
    </div>

    <div class="stop-btn header-btn-style category-name" id="stop_list">
        Стоп ліст
    </div>

    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>

<!-- Tab container -->
<div class="tab-container" style="opacity: 0.9;">
    <ul id="categories_container">
        <li style="background-image: linear-gradient(180deg, #50c3ff, #046aec);">
            <a href="orders.html"><h2>Холодні закуски</h2></a>
        </li>
        <li style="background-image: linear-gradient(180deg, #ff1e36, #ff938e);">
            <a href="orders.html"><h2>Гарячі закуски</h2></a>
        </li>
        <li style="background-image: linear-gradient(60deg, #ffd53a, #ea7b00);">
            <a href="orders.html"><h2>Гарніри</h2></a>
        </li>
        <li style="background-image: linear-gradient(320deg, #94ffaf, #00bf52);">
            <a href="orders.html"><h2>Салати</h2></a>
        </li>
        <li style="background-image: linear-gradient(20deg, #e134b7, #ffd2f6);">
            <a href="orders.html"><h2>Перші страви</h2></a>
        </li>
        <li style="background-image: linear-gradient(150deg, rgb(229,173,255), #9532b5);">
            <a href="orders.html"><h2>Другі страви</h2></a>
        </li>

        <li style="background-image: linear-gradient(30deg, #ffff09, #ffb300);">
            <a href="orders.html"><h2>Десерти</h2></a>
        </li>
        <li style="background-image: linear-gradient(60deg, #00e4ff, #cbeaff);">
            <a href="orders.html"><h2>Напої</h2></a>
        </li>

    </ul>
</div>



<!-- TEMPLATES -->
<div class="list-container" hidden>
    <ul>
        <li>
            <a href="orders.html"><h3>Страва 1</h3></a>
        </li>
        <li>
            <a href="orders.html"><h3>Страва 2</h3></a>
        </li>
        <li>
            <a href="orders.html"><h3>Страва 3</h3></a>
        </li>
        <li>
            <a href="orders.html"><h3>Страва 4</h3></a>
        </li>
        <li>
            <a href="orders.html"><h3>Страва 5</h3></a>
        </li>
        <li>
            <a href="orders.html"><h3>Страва 6</h3></a>
        </li>

        <li>
            <a href="orders.html"><h3>Страва 7</h3></a>
        </li>
        <li>
            <a href="orders.html"><h3>Страва 8</h3></a>
        </li>

    </ul>
</div>


<?php wp_footer(); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!--<script src="libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>-->


</body>
</html></html>