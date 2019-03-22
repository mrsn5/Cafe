<?php
/* Template Name: Statistics */
define("PATH", get_template_directory_uri());
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <?php wp_head(); ?>

<!--    <link href="--><?php //echo PATH ?><!--/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<link rel="stylesheet" type="text/css" href="css/orders.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH ?>/less/statistics.less"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>
<!--    <script src="http://d3js.org/d3.v3.min.js"></script>-->

    <title>Статистика</title>
</head>
<body>
<div class="header">
    <div class="dropdown">
        <div class="dropbtn header-btn-style" id="all_st_btn">Статистика</div>
        <div class="dropdown-content">
            <a id="general_st_btn">Загальна статистика</a>
            <a id="orders_st_btn">Замовлення</a>
            <a id="workers_st_btn">Персонал</a>
            <a id="dishes_st_btn">Страви</a>
        </div>
    </div>

    <div class="dropdown">
        <div class="dropbtn header-btn-style" id="all_finance_btn">Фінанси</div>
        <div class="dropdown-content">
            <a id="income_finance_btn">Прибутки</a>
            <a id="costs_finance_btn">Витрати</a>
            <a id="x_report_btn">Х-звіт</a>
        </div>
    </div>

    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH ?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>
<div class="main">
    <h2 class="page-label" id="page_label">Статистика</h2>

    <div class="container statistics-cont">
        <!--FINANCE BLOCKS-->
        <div id="income_finance">
            <h3 class="page-label-sm">Прибутки</h3>
            <div class="row">
                <div class="block finance-block col-sm-12 col-md-12 col-lg-12">
                    <h2 class="block-header">Прибутки від замовлень за період</h2>
                    <form>
                        <label>
                            <input type="date" id="orders_income_from" value="2019-02-20">
                        </label>
                        <span class="line-between">&#9473;</span>
                        <label>
                            <input type="date" id="orders_income_to" value="2019-02-20">
                        </label>
                        <button class="ok-btn" id="orders_income_btn">
                            oк
                        </button>
                    </form>

                    <table>
                        <thead>
                        <tr>
                            <th class="order-num">номер замовлення</th>
                            <th>дата закриття</th>
                            <th>офіціант</th>
                            <th>сума</th>
                        </tr>
                        </thead>

                        <tbody id="orders_income_table">
                        </tbody>
                    </table>

                    <div class="total">
                        <span>Прибуток</span>
                        <span class="value" id="orders_income_total">0</span> грн
                    </div>
                </div>
            </div>
        </div>
        <div id="costs_finance">
            <h3 class="page-label-sm">Витрати</h3>
            <div class="row">
                <div class="block finance-block col-sm-12 col-md-12 col-lg-12">
                    <h2 class="block-header">Витрати від поставок за період</h2>
                    <form>
                        <label>
                            <input type="date" id="deliveries_cost_from" value="2019-02-20">
                        </label>
                        <span class="line-between">&#9473;</span>
                        <label>
                            <input type="date" id="deliveries_cost_to" value="2019-02-20">
                        </label>
                        <button class="ok-btn" id="deliveries_cost_btn">
                            oк
                        </button>
                    </form>

                    <table>
                        <thead>
                        <tr>
                            <th>номер поставки</th>
                            <th>дата оплати</th>
                            <th>дата отримання</th>
                            <th>постачальник</th>
                            <th>вартість</th>
                        </tr>
                        </thead>

                        <tbody id="deliveries_cost_table">

                        </tbody>
                    </table>

                    <div class="total">
                        <span>Витрати</span>
                        <span class="value" id="deliveries_cost_total">0 </span> грн
                    </div>
                </div>
            </div>
        </div>
        <div id="x_report">
            <h3 class="page-label-sm">Х-звіт</h3>
            <div class="row">
                <div class="block finance-block col-sm-12 col-md-12 col-lg-12">
                    <h2 class="block-header">Х-звіт</h2>

                    <table>
                        <thead>
                        <tr>
                            <th class="order-num">номер замовлення</th>
                            <th>дата закриття</th>
                            <th>офіціант</th>
                            <th>сума</th>
                        </tr>
                        </thead>

                        <tbody id="x_report_table">
                        </tbody>
                    </table>

                    <div class="total">
                        <span>Прибуток</span>
                        <span class="value" id="x_report_total">0 </span> грн
                    </div>
                </div>
            </div>
        </div>
        <!---->

        <!--STATISTICS BLOCKS-->
        <div id="general_st">
            <h3 class="page-label-sm">Загальна</h3>
            <div class="row general-st">
                <div class="block">
                    <h2 class="block-header">Середнє перебування клієнта в кафе за період</h2>
                    <form>
                        <label>
                            <input type="date" id="date_from_av_time" value="2019-02-20">
                        </label>
                        <span class="line-between">&#9473;</span>
                        <label>
                            <input type="date" id="date_to_av_time" value="2019-02-20">
                        </label>
                        <button class="ok-btn" id="av_time_btn">
                            oк
                        </button>
                    </form>

                    <div class="results">
                        <h1>
                            <img class="image" alt="" src="<?php echo PATH ?>/images/clock.svg">
                            <span id="average_client_time">0</span> год
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div id="orders_st">
            <h3 class="page-label-sm">Замовлення</h3>
            <div class="row">
                <div class="block">
                    <h2 class="block-header">Кількість оформлених чеків за період</h2>
                    <form>
                        <label>
                            <input type="date" id="orders_amount_from" value="2019-02-20">
                        </label>
                        <span class="line-between">&#9473;</span>
                        <label>
                            <input type="date" id="orders_amount_to" value="2019-02-20">
                        </label>
                        <button id="orders_amount_btn" class="ok-btn">
                            oк
                        </button>
                    </form>

                    <div class="results">
                        <h1>
                            <img class="image" alt="" src="<?php echo PATH ?>/images/receipt1.svg">
                            <span id="orders_amount">0</span>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="block">
                    <h2 class="block-header">Середня вартість чека за період</h2>
                    <form>
                        <label>
                            <input type="date" id="av_order_cost_from" value="2019-02-20">
                        </label>
                        <span class="line-between">&#9473;</span>
                        <label>
                            <input type="date" id="av_order_cost_to" value="2019-02-20">
                        </label>
                        <button id="av_order_cost_btn" class="ok-btn">
                            oк
                        </button>
                    </form>

                    <div class="results">
                        <h1>
                            <img class="image" alt="" src="<?php echo PATH ?>/images/coin.svg">
                            <span id="av_order_cost">0</span> грн
                        </h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="block">
                    <h2 class="block-header">Середня вартість чека на людину за період</h2>
                    <form>
                        <label>
                            <input type="date" id="av_cost_per_person_from" value="2019-02-20">
                        </label>
                        <span class="line-between">&#9473;</span>
                        <label>
                            <input type="date" id="av_cost_per_person_to" value="2019-02-20">
                        </label>
                        <button class="ok-btn" id="av_cost_per_person_btn">
                            oк
                        </button>
                    </form>

                    <div class="results">
                        <h1>
                            <img class="image" alt="" src="<?php echo PATH ?>/images/coin.svg">
                            <span id="av_cost_per_person">0</span> грн
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div id="workers_st">
            <h3 class="page-label-sm">Персонал</h3>
            <div class="row">
                <div class="block pie-diagram-block">
                    <h2 class="block-header">Робітник, що оформив найбільше замовлень</h2>

                    <div class="content">
                        <form>
                            <div class="period">
                                <label>
                                    <input type="date" id="workers_orders_from" value="2019-02-20">
                                </label>
                                <span class="line-between">&#9473;</span>
                                <label>
                                    <input type="date" id="workers_orders_to" value="2019-02-20">
                                </label>
                            </div>

                            <label class="elems-num input-style">
                                Перших
                                <input type="number" id="first_n_workers_orders" class="input" min="1" max="10" placeholder="1">
                            </label>

                            <button class="ok-btn" id="workers_orders_btn">
                                oк
                            </button>
                        </form>

                        <div class="results diagram-area">
                            <div class="diagram_cont" id="worker_orders_diagram"></div>
                            <div class="legend_cont" id="worker_orders_legend"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="block pie-diagram-block">
                    <h2 class="block-header">Робітник, що приніс найбільший прибуток</h2>
                    <div class="content">
                        <form>
                            <div class="period">
                                <label>
                                    <input type="date" id="worker_income_from" value="2019-02-20">
                                </label>
                                <span class="line-between">&#9473;</span>
                                <label>
                                    <input type="date" id="worker_income_to" value="2019-02-20">
                                </label>
                            </div>

                            <label class="elems-num input-style">
                                Перших
                                <input type="number" id="first_n_workers_income" class="input" min="1" max="10" placeholder="1">
                            </label>

                            <button class="ok-btn" id="worker_income_btn">
                                oк
                            </button>
                        </form>

                        <div class="results diagram-area">
                            <div class="diagram_cont" id="worker_income_diagram"></div>
                            <div class="legend_cont" id="worker_income_legend"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="dishes_st">
            <h3 class="page-label-sm">Страви</h3>
            <div class="row">
                <div class="block">
                    <h2 class="block-header">Кількість замовлених порцій для категорії</h2>
                    <form>

                        <label class="select input-style category-list">
                            Категорія
                            <select class="input select-category" id="category_portions_category_list">
                                <option value="салати">салати</option>
                                <option value="гарніри">гарніри</option>
                                <option value="гарніри">закуски</option>
                            </select>
                        </label>
                        <button class="ok-btn" id="category_portions_btn">
                            oк
                        </button>
                    </form>

                    <div class="results">
                        <h1>
                            <img class="image" alt="" src="<?php echo PATH ?>/images/dish.svg">
                            <span id="category_portions">0</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="block">
                    <h2 class="block-header">Кількість замовлених порцій для страви</h2>
                    <form>
                        <label class="input-style dish-name">
                            Назва страви
                            <input type="text" id="dish_portion_name" class="input" placeholder="Назва">


                        </label>

<!--                        <label class="select input-style category-list">-->
<!--                            Категорія-->
<!--                            <select class="input select-category" id="dish_portions_category_list">-->
<!--                                <option value="салати">салати</option>-->
<!--                                <option value="гарніри">гарніри</option>-->
<!--                                <option value="гарніри">закуски</option>-->
<!--                            </select>-->
<!--                        </label>-->
                        <button class="ok-btn" id="dish_portions_btn">
                            oк
                        </button>
                    </form>

                    <div class="results">
                        <h1>
                            <img class="image" alt="" src="<?php echo PATH ?>/images/dish.svg">
                            <span id="dish_portions">0</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" block histogram-block">
                    <h2 class="block-header">Страви, що були замовлені найчастіше/найрідше</h2>
                    <form>
                        <div class="period">
                            <label>
                                <input type="date" id="dish_frequency_from" value="2019-02-20">
                            </label>
                            <span class="line-between">&#9473;</span>
                            <label>
                                <input type="date" id="dish_frequency_to" value="2019-02-20">
                            </label>
                        </div>

                        <label class="select input-style">
                        <select class="input" id="dish_frequency_less_more_option">
                            <option value="більше">більше</option>
                            <option value="менше">менше</option>
                        </select>
                        </label>

                        <label class="elems-num input-style">
                            Кількість замовлень
                            <input type="number" id="dish_frequency_orders_amount" class="input" min="1" placeholder="1">
                        </label>

                        <button class="ok-btn" id="dish_frequency_btn">
                            oк
                        </button>
                    </form>

                    <div class="results">
                        <div class="diagram_cont" id="dishes_orders_diagram"></div>
                    </div>
                </div>
            </div>
        </div>
        <!---->
    </div>
</div>

<?php wp_footer(); ?>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script src="--><?php //echo PATH ?><!--/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>-->

<!--<script type="text/javascript" src="--><?php //echo PATH ?><!--/js/graphics.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo PATH ?><!--/js/statistics.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo PATH ?><!--/js/general_functions.js"></script>-->
</body>
</html>



