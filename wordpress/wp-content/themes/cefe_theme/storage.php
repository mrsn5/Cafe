<?php
/* Template Name: Storage */
define("PATH", get_template_directory_uri());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo PATH ?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH ?>/less/storage.less"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <title>Склад</title>
</head>
<body>

<div class="header">
    <!--    <div class="search-area">-->
    <!--        <input type="text" class="search" id="search_products" placeholder="Назва">-->
    <!--        <label for="search_products">-->
    <!--            <img src="--><?php //echo PATH ?><!--/images/search.svg" class="search-icon">-->
    <!--        </label>-->
    <!--    </div>-->

    <div class="header-btn-style search-btn" id="search_personnel_btn">
        Пошук
    </div>

    <div class="header-btn-style modal-btn" data-toggle="modal">
        Додати Інгредієнт
    </div>

    <div class="header-btn-style" id="inventory_btn">
        Інвентаризація
    </div>

    <div class="header-btn-style toggle-btn" id="discarding_btn">
        <span>Списання</span>
        <img class="img-cont image-transition" src="<?php echo PATH ?>/images/drop_down_icon.png">
    </div>

    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH ?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>

<div class="modal fade show-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Новий інгредієнт</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="input-style">
                    Назва інгредієнту
                    <input type="text" class="ing-name input" placeholder="Назва">
                </label>

                <label class="input-style">
                    Одиниці вимірювання
                    <select class="select-units input">
                        <option value="кг">кг</option>
                        <option value="л">л</option>
                        <option value="шт">шт</option>
                    </select>
                </label>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-style save-modal-btn" data-dismiss="modal">SAVE</button>
                <button type="button" class="btn btn-style close-modal-btn" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<div class="main">
    <div class="search-area">
        <form>
            <div class="search-name search-block">
                <span class="label-header">Пошук
                    <img src="<?php echo PATH ?>/images/search.svg" class="search-icon">
                </span>

                <label class="label" for="search_name">Назва</label>
                <input type="text" class="search " id="search_name" placeholder="Картопля">
            </div>

            <div class="search-name search-block">
                <span class="label-header">Інгредієнти, що скоро зіпсуються
                    <img src="<?php echo PATH ?>/images/search.svg" class="search-icon">
                </span>

                <label class="label" for="search_date">Вжити до</label>
                <input type="date" id="search_date">
            </div>

            <div class="search-worker search-block">
                 <span class="label-header">Інгредієнти, що скінчились
                    <img src="<?php echo PATH ?>/images/search.svg" class="search-icon">
                </span>
<!--                <div class="label" id="absent_ings">Інгредієнти, що скінчились</div>-->
            </div>
        </form>
    </div>

    <div class="inf-area">
        <div class="toggle-area discarding-area">
            <div class="discarding-header">
                <button class="save-discarding-btn btn-style">Списати</button>
            </div>
            <div class="products">
                <h3>Продукти</h3>
                <div class="products-list custom-scrollbar">
                    <table class="products-table">
                        <thead>
                        <tr>
                            <th class="number-col"></th>
                            <th class="">код</th>
                            <th class="">назва</th>
                            <th class="">кількість</th>
                            <th class="">заг. вартість (грн)</th>
                            <th class="reason">причина</th>
                            <th class="img-col"></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr class="product">
                            <td>1</td>
                            <td>1234</td>
                            <td>картопля</td>

                            <td class="editable-cell">
                                <span class="value">20</span>
                                <label class="input-data input-style">
                                    <input type="number" class="input">
                                </label>
                            </td>

                            <td>1342</td>

                            <td class="editable-cell reason-cell">
                                <span class="value">-</span>
                                <label class="input-data input-style">
                                    <input type="text" class="input">
                                </label>
                            </td>

                            <td><img class="icon" src="<?php echo PATH ?>/images/delete.svg"></td>
                        </tr>
                        <tr class="product">
                            <td>1</td>
                            <td>1234</td>
                            <td>картопля</td>

                            <td class="editable-cell">
                                <span class="value">20</span>
                                <label class="input-data input-style">
                                    <input type="number" class="input">
                                </label>
                            </td>

                            <td>1342</td>

                            <td class="editable-cell reason-cell">
                                <span class="value">-</span>
                                <label class="input-data input-style">
                                    <input type="text" class="input">
                                </label>
                            </td>

                            <td><img class="icon" src="<?php echo PATH ?>/images/delete.svg"></td>
                        </tr>

                        <!--row for new product-->
                        <tr class="product">
                            <td>1</td>
                            <td>
                                <label class="input-style">
                                    <input type="number" class="input" placeholder="код"/>
                                </label>
                            </td>

                            <td class="">
                                назва
                            </td>

                            <td class="">
                                <label class="input-style">
                                    <input type="number" class="input" placeholder="кількість">
                                </label>
                            </td>
                            <td>0</td>
                            <td class="reason-cell">
                                <label class="input-style">
                                    <input type="text" class="input" placeholder="причина">
                                </label>
                            </td>
                            <td><img class=" icon" src="<?php echo PATH ?>/images/delete.svg"></td>
                            <td><img class=" icon" src="<?php echo PATH ?>/images/checked.svg"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="total">
                    <span>Всього</span>
                    <span class="total-price">174,42 грн</span>
                </div>
                <button class="add-product-btn btn-style">Додати продукт</button>
            </div>
        </div>

        <div class="table-area">
            <div class="show_ings_btn">
                <span id="all_ings">Всі інгредієнти</span>
            </div>
            <table id="ingredients_table">
                <thead>
                <tr>
                    <th>назва інгредієнту</th>
                    <th>одиниці вимірювання</th>
                    <th>кількість на складі</th>
                    <th>товари</th>
                </tr>
                </thead>

                <tbody class="color-lines-with-extra">
                <tr>
                    <td>картопля</td>
                    <td class="editable-cell">
                        <span class="value">кг</span>
                        <label class="input-data input-style">
                            <select class="select-units input">
                                <option value="кг">кг</option>
                                <option value="л">л</option>
                                <option value="шт">шт</option>
                            </select>
                        </label>
                    </td>
                    <td>200</td>
                    <td class="show-products"><img class="image-transition"
                                                   src="<?php echo PATH ?>/images/drop_down_icon.png">
                    </td>
                <tr class="extra">
                    <td colspan="10">
                        <div class="products-list custom-scrollbar">
                            <ul class="ul-style">
                                <li class="product prod-header">
                                    <div class="number"></div>
                                    <div class="code">№ поставки</div>
                                    <div class="code">код товару</div>
                                    <div class="name">назва</div>
                                    <div class="date">вжити з</div>
                                    <div class="date">вжити до</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="code">12343</div>
                                    <div class="code">53542</div>
                                    <div class="name">Картопля білоруська</div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="code">12343</div>
                                    <div class="code">53542</div>
                                    <div class="name">Картопля білоруська</div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="code">12343</div>
                                    <div class="code">53542</div>
                                    <div class="name">Картопля білоруська</div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                </tr>
                </tbody>
            </table>

            <table id="inventory_table">
                <thead>
                <tr>
                    <th>код товару</th>
                    <th>назва товару</th>
                    <th>назва інгредієнту</th>
                    <th>одиниці вимірювання</th>
                    <th>кількість при закупці</th>
                    <th>сума при закупці(грн)</th>
                    <th>очікувана кількість</th>
                    <th>очікувана сума (грн)</th>
                    <th>фактична кількість</th>
                    <th>фактична сума (грн)</th>
                </tr>
                </thead>

                <tbody class="color-lines">
                <tr>
                    <td>1234</td>
                    <td>картопля білоруська</td>
                    <td>картопля</td>
                    <td>кг</td>
                    <!--                при закупці-->
                    <td>200</td>
                    <td>300</td>
                    <!--                очікувана-->
                    <td>150</td>
                    <td>250</td>
                    <!--                фактична-->
                    <td>
                        <label class="input-style">
                            <input type="number" class="input" min="0" placeholder="фактична кількість">
                        </label>
                    </td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>1234</td>
                    <td>картопля білоруська</td>
                    <td>картопля</td>
                    <td>кг</td>
                    <!--                при закупці-->
                    <td>200</td>
                    <td>300</td>
                    <!--                очікувана-->
                    <td>150</td>
                    <td>250</td>
                    <!--                фактична-->
                    <td>
                        <label class="input-style">
                            <input type="number" class="input" min="0" placeholder="фактична кількість">
                        </label>
                    </td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>1234</td>
                    <td>картопля білоруська</td>
                    <td>картопля</td>
                    <td>кг</td>
                    <!--                при закупці-->
                    <td>200</td>
                    <td>300</td>
                    <!--                очікувана-->
                    <td>150</td>
                    <td>250</td>
                    <!--                фактична-->
                    <td>
                        <label class="input-style">
                            <input type="number" class="input" min="0" placeholder="фактична кількість">
                        </label>
                    </td>
                    <td>0</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo PATH ?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo PATH ?>/js/general_functions.js"></script>
<script type="text/javascript" src="<?php echo PATH ?>/js/storage.js"></script>
</body>
</html>