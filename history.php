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

    <?php wp_head(); ?>
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/orders.less" />
    <title>Історія</title>

</head>
<body>

<div class="header">
    <div class="search-btn header-btn-style" id="search_orders_btn">
        Пошук
    </div>

    <div class="orders-btn header-btn-style" id="orders_btn">
        Замовлення
    </div>

    <div class="discarding-btn header-btn-style" id="discarding_btn">
        Списання
    </div>

    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>

<div class="main">

    <div class="search-area">
        <div class="search-cont-orders">
            <form>
                <div class="search-block">
                    <span class="label-header" id="today-orders">Замовлення на сьгодні
                        <img src="<?php echo PATH?>/images/search.svg" class="search-icon" alt="Пошук по даті">
                    </span>

                    <div class="input-block search-date">
                        <span class="label">В період</span>
                        <label>
                            з
                            <input type="date" id="date-from-search">
                        </label>
                        <label>
                            по
                            <input type="date" id="date-to-search">
                        </label>
                    </div>


                    <div class="input-block">
                        <span class="label">Робітник</span>
                        <input type="text" placeholder="Ім'я робітника" id="searched-name">
                    </div>
                </div>
            </form>

            <div class="search-block" id="search-button">
                <span class="label-header">Пошук
                    <img src="<?php echo PATH?>/images/search.svg" class="search-icon" alt="Пошук по даті">
                </span>
            </div>
        </div>

        <div class="search-cont-discarding">
            <form>
                <div class="search-block">
                    <span class="label-header" id="search_discards">Пошук
                        <img src="<?php echo PATH?>/images/search.svg" class="search-icon" alt="Пошук по даті">
                    </span>
                    <div class="input-block">
                        <label class="label" for="discarding_date">Дата списання</label>
                        <input type="date" id="discarding_date">
                    </div>

                    <div class="input-block">
                        <label class="label" for="resp_person">Відповідальна особа</label>
                        <input type="text" placeholder="Ім'я робітника" id="resp_person">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="inf-area">
        <div class="orders-container">

            <h3 class="orders-label">
                <div id="prompt-label"> Замовлення на сьогодні</div>
                <span id="num-ord">5</span>
            </h3>

<!--            only for accountant-->
            <div class="general-price">
                <span>СУМА</span>
                <span id="total-all">390 грн</span>
            </div>


            <div class="temp-order-area">
                <ul id="orders-list">
<!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
<!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
<!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
<!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
<!--                    <li class="order-item">--><?php //include('orders.php');?><!--</li>-->
                </ul>
            </div>
        </div>

        <div class="discarding-container">
            <div class="table-area">
                <table>
                    <thead>
                    <tr>
                        <th>номер списання</th>
                        <th>дата списання</th>
                        <th>вартість (грн)</th>
                        <th>відповідальна особа</th>
                        <th>продукти</th>
                    </tr>
                    </thead>

                    <tbody class="color-lines-with-extra" id="discarding_list_container">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php wp_footer(); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script src="--><?php //echo PATH?><!--/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>-->
<!---->
<!--<script type="text/javascript" src="--><?php //echo PATH?><!--/js/history.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo PATH?><!--/js/orders.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo PATH?><!--/js/general_functions.js"></script>-->

</body>
</html>


