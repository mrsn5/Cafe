<?php
/* Template Name: Menu */
define("PATH", get_template_directory_uri());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href="<?php echo PATH ?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/main.css">-->

    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH ?>/less/menu.less">
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
    <div class="toggle-btn header-btn-style" id="add_dish_btn">
        Додати страву
    </div>
    <!---->

    <div class="top-btn header-btn-style category-name" id="top_list">
        Топ ліст
    </div>

    <div class="stop-btn header-btn-style category-name" id="stop_list">
        Стоп ліст
    </div>

</div>

<div class="toggle-area new-item-area">
    <div class="new-item-header">
        <div class="name">
            <span class="header-text">Нова страва</span>
        </div>
        <button class="save-item-btn btn-style" id="save_dish_btn">
            Зберегти страву
        </button>
    </div>

    <div class="main-area">
        <form class="general-inf">
            <div>
                <p>Загальне</p>
                <div class="inputs-row">
                    <div class="field inline-field">
                        <input type="text" name="dish_name" id="dish_name" placeholder="Борщ">
                        <label class="required-label" for="dish_name">Назва</label>
                    </div>

                    <div class="field inline-field">
                        <div class="select-cont">
                            <select class="select-department" id="department" name="department" required>
                                <option value="кухня" >кухня</option>
                                <option value="бар">бар</option>
                            </select>
                        </div>
                        <label class="required-label label-without-trans" for="department">Відділ</label>
                    </div>

                    <div class="field inline-field">
                        <div class="select-cont">
                            <select class="select-category" id="categories_add" name="categories" required>
                            </select>
                        </div>
                        <label class="required-label label-without-trans" for="categories">Категорія</label>
                    </div>
                </div>
            </div>

            <div>
                <p>Документація</p>
                <div class="inputs-row">
                    <div class="field inline-field">
                        <input type="number" name="tab" id="tech_num" placeholder="123456">
                        <label class="required-label" for="tech_num">Технологічна картка</label>
                    </div>

                    <div class="field inline-field">
                        <input type="number" name="tab" id="calc_num" placeholder="123456">
                        <label class="required-label" for="calc_num">Калькуляційна картка</label>
                    </div>
                </div>
            </div>

            <div>
                <p>Характеристики</p>
                <div class="inputs-row">
                    <div class="field inline-field">
                        <input type="number" name="tab" id="weight" placeholder="123">
                        <label class="required-label" for="weight">Вага порції (г)</label>
                    </div>

                    <div class="field inline-field">
                        <input type="number" name="tab" id="calories" placeholder="123">
                        <label class="required-label" for="calories">Калорійність (ккал)</label>
                    </div>

                    <div class="field inline-field">
                        <input type="number" name="tab" id="cooking_time" placeholder="123">
                        <label class="required-label" for="cooking_time">Час приготування (хв)</label>
                    </div>
                </div>
            </div>

        </form>
        <div class="products">
            <h3>Інгредієнти</h3>
            <div class="products-list custom-scrollbar">
                <table class="products-table">
                    <thead>
                    <tr>
                        <th class="number-col"></th>
                        <th class="name-col">назва</th>
                        <th class="amount-col">кількість (г)</th>
                        <th class="gen-price-col">середня вартість (грн/г)</th>
                        <th class="gen-price-col">загальна вартість</th>
                        <th class="img-col"></th>
                        <!--<th class="img-col"></th>-->
                    </tr>
                    </thead>

                    <tbody id="product_container">
                    <!--row for new product-->
                    <tr id="new_product" class="product">
                        <td></td>
                        <td>
                            <label class="input-style">
                                <input type="text" class="input ings-select" list="ing_list" placeholder="інгредієнт">

                                <datalist id="ing_list"></datalist>
                            </label>
                        </td>
                        <td class="">
                            <label class="input-style">
                                <input type="number" class="input amount-input" min="0" placeholder="кількість">
                            </label>
                        </td>
                        <td class="" id="price_cell">0.00</td>
                        <td class="" id="gen_price_cell">0.00</td>
                        <!--                        <td><img class=" icon" src="-->
                        <?php //echo PATH ?><!--/images/delete.svg"></td>-->
                        <td><img class="icon" id="add_ingredient" src="<?php echo PATH ?>/images/checked.svg"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="total">
                <span>Ціна</span>
                <span class="total-price"><span id="price_value">0.00</span> грн</span>
            </div>
        </div>
    </div>
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