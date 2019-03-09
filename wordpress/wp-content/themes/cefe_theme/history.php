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
                    <span class="label-header">Пошук
                        <img src="<?php echo PATH?>/images/search.svg" class="search-icon" alt="Пошук по даті">
                    </span>

                    <div class="input-block search-date">
                        <span class="label">В період</span>
                        <label>
                            з
                            <input type="date">
                        </label>
                        <label>
                            по
                            <input type="date">
                        </label>
                    </div>


                    <div class="input-block">
                        <span class="label">Робітник</span>
                        <input type="text" placeholder="Ім'я робітника">
                    </div>
                </div>
            </form>

            <div class="search-block">
                <span class="label-header">Замовлення на сьгодні
                    <img src="<?php echo PATH?>/images/search.svg" class="search-icon" alt="Пошук по даті">
                </span>
            </div>
        </div>

        <div class="search-cont-discarding">
            <form>
                <div class="search-block">
                    <span class="label-header">Пошук
                        <img src="<?php echo PATH?>/images/search.svg" class="search-icon" alt="Пошук по даті">
                    </span>
                    <div class="input-block">
                        <label class="label" for="discarding_date">Дата списання</label>
                        <input type="date" id="discarding_date">
                    </div>

                    <div class="input-block">
                        <label class="label" for="resp_person">Відповідальна особа</label>
                        <input type="text" placeholder="Ім'я робітника">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="inf-area">
        <div class="orders-container">

            <h3 class="orders-label">
                Замовлення на сьогодні
                <span>5</span>
            </h3>

<!--            only for accountant-->
            <div class="general-price">
                <span>СУМА</span>
                <span>390 грн</span>
            </div>


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

                    <tbody class="color-lines-with-extra">
                    <tr>
                        <td>1234</td>
                        <td>2019-02-20</td>
                        <td>340</td>
                        <td>Петренко Петро Петрович</td>
                        <td class="show-products"><img class="image-transition"
                                                       src="<?php echo PATH ?>/images/drop_down_icon.png">
                        </td>
                    </tr>
                    <tr class="extra">
                        <td colspan="10">
                            <div class="products-list custom-scrollbar">
                                <ul class="ul-style">
                                    <li class="product prod-header">
                                        <div class="number"></div>
                                        <div class="code">№ поставки</div>
                                        <div class="code">код товару</div>
                                        <div class="name">назва</div>
                                        <div class="units">один. вимірюв.</div>
                                        <div class="amount">кількість</div>
                                        <div class="price">ціна за од.(грн)</div>
                                    </li>
                                    <li class="product">
                                        <div class="number">1.</div>
                                        <div class="code">12343</div>
                                        <div class="code">53542</div>
                                        <div class="name">Картопля білоруська</div>
                                        <div class="units">кг</div>
                                        <div class="amount">30</div>
                                        <div class="price">10</div>
                                    </li>
                                    <li class="product">
                                        <div class="number">1.</div>
                                        <div class="code">12343</div>
                                        <div class="code">53542</div>
                                        <div class="name">Картопля білоруська</div>
                                        <div class="units">кг</div>
                                        <div class="amount">30</div>
                                        <div class="price">10</div>
                                    </li>
                                    <li class="product">
                                        <div class="number">1.</div>
                                        <div class="code">12343</div>
                                        <div class="code">53542</div>
                                        <div class="name">Картопля білоруська</div>
                                        <div class="units">кг</div>
                                        <div class="amount">30</div>
                                        <div class="price">10</div>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo PATH?>/js/history.js"></script>
<script type="text/javascript" src="<?php echo PATH?>/js/orders.js"></script>
<script type="text/javascript" src="<?php echo PATH?>/js/general_functions.js"></script>

</body>
</html>


