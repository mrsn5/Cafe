<?php
    /* Template Name: Orders */
    define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" type="text/css" href="css/orders.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/orders.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>


    <title>Поточні замовлення</title>

</head>
<body>

<div class="orders-container">
    <!-- Order -->
    <div class="order-container">

        <div class="order-num">
            <h1>#1203</h1>
            <a class="edit" href=""><img src="<?php echo PATH?>/images/edit.svg" alt="Edit"/></a>
        </div>

        <div class="table-num">
            <a href=""><img src="<?php echo PATH?>/images/hand-2.svg" alt="Money"/></a>
            <a href=""><img src="<?php echo PATH?>/images/hand.svg" alt="Card"/></a>
            <h1>12</h1>
        </div>

        <div class="order-time">
            10:23
        </div>

        <div class="content">
            <ul>
                <!-- ITEMS -->
                <li class="item">
                    <div class="item-info">
                        <input type="checkbox" id="box-1">
                        <label for="box-1">
                            <div class="text">
                                <span class="name">Борщ</span><br/>
                                <span class="comment">[Без петрушки]</span>
                            </div>
                        </label>
                    </div>
                    <span class="quantity">2</span>
                    <span class="price">127,70 грн</span>
                </li>

                <li class="item">
                    <div class="item-info">
                        <input type="checkbox" id="box-2">
                        <label for="box-2">
                            <div class="text">
                                <div class="name">Картопля по-селянськи, 250г</div><br/>
                                <span class="comment"></span>
                            </div>
                        </label>
                    </div>
                    <span class="quantity">1</span>
                    <span class="price">23,50 грн</span>
                </li>

                <li class="item">
                    <div class="item-info">
                        <input type="checkbox" id="box-3">
                        <label for="box-3">
                            <div class="text">
                                <span class="name">Пюре</span><br/>
                                <span class="comment">[Не солити]</span>
                            </div>
                        </label>
                    </div>
                    <span class="quantity">2</span>
                    <span class="price">42,60 грн</span>
                </li>

                <!-- BREAK LINE-->
                <li><hr></li>

                <!-- DISCOUNT -->
                <li class="discount">
                    <div class="item-info">
                        <div class="text">
                            <span>Знижка</span><br/>
                        </div>
                    </div>
                    <span class="quantity">10%</span>
                    <span class="price">19,38 грн</span>
                </li>

                <!-- BREAK LINE-->
                <li><hr></li>

                <!-- TOTAL -->
                <li class="total">
                    <span>Всього</span>
                    <span class="total-price">174,42 грн</span>
                </li>

            </ul>
        </div>
    </div>
</div>


</body>
</html>
