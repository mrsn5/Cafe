<?php
/* Template Name: Deliveries */
define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link href="<?php echo PATH ?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH ?>/less/delivery_page.less"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <?php wp_head(); ?>
    <title>Поставки</title>
</head>
<body>

<div class="header">

    <div class="search-order-btn header-btn-style search-btn" id="search_orders_btn">
        Пошук
    </div>

    <div class="toggle-btn header-btn-style" id="add_area_btn">
        <span>Додати поставку</span>
        <!--<div class="img-cont">-->
        <img class="img-cont image-transition" src="<?php echo PATH ?>/images/drop_down_icon.png">
        <!--</div>-->
    </div>
    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH ?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>

<div class="main">
    <div class="search-area">
        <form>
            <div class="search-block">
                <span class="label-header" id="search_deliveries">Пошук
                    <img src="<?php echo PATH ?>/images/search.svg" class="search-icon">
                </span>

                <div class="input-block search-date">
                    <span class="label">Отримані в період</span>
                    <label>
                        з
                        <input type="date" id="search_date_from">
                    </label>
                    <label>
                        по
                        <input type="date" id="search_date_to">
                    </label>
                </div>

                <div class="search-paid input-block">
                    <span class="label" for="search_paid">Сплачені</span>
                    <input type="checkbox" class="search checkbox-style" id="search_paid">
                    <label for="search_paid"></label>

                    <label class="consider-label">
                        <input type="checkbox" id="is_paid_count" checked>
                        не враховувати
                    </label>
                </div>

                <div class="search-paid input-block">
                    <span class="label" for="search_received">Отримані</span>
                    <input type="checkbox" class="search checkbox-style" id="search_received">
                    <label for="search_received"></label>

                    <label class="consider-label">
                        <input type="checkbox" id="is_received_count" checked>
                        не враховувати
                    </label>
                </div>
            </div>
        </form>
    </div>

    <div class="inf-area">
        <div class="toggle-area new-item-area">
            <div class="new-item-header">
                <div class="name">
                    <span class="header-text">Нова поставка</span>
                    <span class="number">#132</span>
                </div>
                <button class="save-item-btn btn-style">
                    Зберегти поставку
                </button>
            </div>

            <div class="main-area">
                <div class="general-inf">
                    <form>
                        <div class="date-field">
                            <label class="required-label" for="order_date">Дата замовлення</label>
                            <input type="date" id="order_date" value="1980-08-26">
                        </div>

                        <div class="date-field">
                            <label class="required-label" for="receiving_date">Дата отримання</label>
                            <input type="date" id="receiving_date" value="1980-08-26">
                        </div>

                        <div class="date-field">
                            <label class="required-label" for="payment_date">Дата оплати</label>
                            <input type="date" id="payment_date" value="1980-08-26">
                        </div>

                        <div class="provider-list field inline-field">
                            <div class="select-cont">
                                <select class="select-providers" name="providers" id="providers_list">
                                    <option value="provider 1">Постачальник 1</option>
                                    <option value="provider 2">Постачальник 2</option>
                                    <option value="provider 3">Постачальник 3</option>
                                    <option value="provider 4">Постачальник 4</option>
                                </select>
                            </div>
                            <label class="required-label " for="providers_list">Постачальник</label>
                        </div>

                        <!--                        <div>-->
                        <div class="checkbox-field">
                            <input type="checkbox" id="is_paid" class="checkbox-style"/>
                            <label for="is_paid">Сплачено</label>
                        </div>

                        <div class="checkbox-field">
                            <input id="is_received" type="checkbox" class="checkbox-style"/>
                            <label for="is_received">Отримано</label>
                        </div>
                        <!--                        </div>-->
                    </form>
                </div>

                <div class="products">
                    <h3>Продукти</h3>
                    <div class="products-list custom-scrollbar">
                        <table class="products-table">
                            <thead>
                            <tr>
                                <th class="number-col"></th>
                                <th class="name-col">назва</th>
                                <th class="price-col">ціна за од.(грн)</th>
                                <th class="amount-col">кількість</th>
                                <th class="units-col">один. вим.</th>
                                <th class="date-col">вжити з</th>
                                <th class="date-col">вжити до</th>
                                <th class="gen-price-col">заг. вартість (грн)</th>
                                <th class="ingredient">інгредієнт</th>
                                <th class="img-col"></th>
                                <!--<th class="img-col"></th>-->
                            </tr>
                            </thead>

                            <tbody>
                            <tr class="product">
                                <td>1</td>
                                <td class="editable-cell">
                                    <span class="value">картопля</span>
                                    <label class="input-data input-style">
                                        <input type="text" class="input"/>
                                    </label>
                                </td>
                                <td class="editable-cell">
                                    <span class="value">
                                        20
                                    </span>
                                    <label class="input-data input-style">
                                        <input type="number" class="input">
                                    </label>
                                </td>
                                <td class="editable-cell">
                                <span class="value">
                                    30
                                </span>
                                    <label class="input-data input-style">
                                        <input type="number" class="input">
                                    </label>
                                </td>
                                <td class="editable-cell">
                                <span class="value">
                                    кг
                                </span>
                                    <label class="input-data input-style">
                                        <select class="select-units input">
                                            <option value="кг">кг</option>
                                            <option value="л">л</option>
                                            <option value="шт">шт</option>
                                        </select>
                                    </label>
                                </td>
                                <td class="editable-cell">
                                    <span class="value">-</span>

                                    <label class="input-data input-style">
                                        <input type="date" class="input">
                                    </label>
                                </td>
                                <td class="editable-cell">
                                    <span class="value">-</span>
                                    <label class="input-data input-style">
                                        <input type="date" class="input">
                                    </label>
                                </td>
                                <td>134</td>
                                <td class="editable-cell">
                                <span class="value">
                                    картопля
                                </span>
                                    <label class="input-data input-style">
                                        <select class="select-ing input">
                                            <option value="картопля">картопля</option>
                                            <option value="помідор">помідор</option>
                                            <option value="капуста">капуста</option>
                                        </select>
                                    </label>
                                </td>
                                <td><img class=" icon" src="<?php echo PATH ?>/images/delete.svg"></td>
                            </tr>
                            <tr class="product">
                                <td>1</td>
                                <td class="editable-cell">
                                    <span class="value">картопля</span>
                                    <label class="input-data input-style">
                                        <input type="text" class="input"/>
                                    </label>
                                </td>
                                <td class="editable-cell">
                                <span class="value">
                                    20
                                </span>
                                    <label class="input-data input-style">
                                        <input type="number" class="input">
                                    </label>
                                </td>
                                <td class="editable-cell">
                                <span class="value">
                                    30
                                </span>
                                    <label class="input-data input-style">
                                        <input type="number" class="input">
                                    </label>
                                </td>
                                <td class="editable-cell">
                                <span class="value">
                                    кг
                                </span>
                                    <label class="input-data input-style">
                                        <select class="select-units input">
                                            <option value="кг">кг</option>
                                            <option value="л">л</option>
                                            <option value="шт">шт</option>
                                        </select>
                                    </label>
                                </td>
                                <td class="editable-cell">
                                    <span class="value">-</span>

                                    <label class="input-data input-style">
                                        <input type="date" class="input">
                                    </label>
                                </td>
                                <td class="editable-cell">
                                    <span class="value">-</span>
                                    <label class="input-data input-style">
                                        <input type="date" class="input">
                                    </label>
                                </td>
                                <td>134</td>
                                <td class="editable-cell">
                                <span class="value">
                                    картопля
                                </span>
                                    <label class="input-data input-style">
                                        <select class="select-ing input">
                                            <option value="картопля">картопля</option>
                                            <option value="помідор">помідор</option>
                                            <option value="капуста">капуста</option>
                                        </select>
                                    </label>
                                </td>
                                <td><img class=" icon" src="<?php echo PATH ?>/images/delete.svg"></td>
                            </tr>

                            <!--row for new product-->
                            <tr class="product">
                                <td>1</td>
                                <td>
                                    <label class="input-style">
                                        <input type="text" class="input" placeholder="назва"/>
                                    </label>
                                </td>
                                <td class="">
                                    <label class="input-style">
                                        <input type="number" class="input" placeholder="ціна">
                                    </label>
                                </td>
                                <td class="">
                                    <label class="input-style">
                                        <input type="number" class="input" placeholder="кількість">
                                    </label>
                                </td>
                                <td class="">
                                    <label class="input-style">
                                        <select class="select-units input">
                                            <option value="кг" selected>кг</option>
                                            <option value="л">л</option>
                                            <option value="шт">шт</option>
                                        </select>
                                    </label>
                                </td>
                                <td class="">
                                    <label class="input-style">
                                        <input type="date" class="input">
                                    </label>
                                </td>
                                <td class="">
                                    <label class="input-style">
                                        <input type="date" class="input">
                                    </label>
                                </td>
                                <td>0</td>
                                <td class="">
                                    <label class="input-style">
                                        <select class="select-ing input">
                                            <option value="картопля" selected>картопля</option>
                                            <option value="помідор">помідор</option>
                                            <option value="капуста">капуста</option>
                                        </select>
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
        </div>
        <div class="table-area">
            <div class="show_items_btn">
                <span class="all_items" id="all_deliveries">Всі поставки</span>
            </div>

            <table>
                <thead>
                <tr>
                    <th>№ партії</th>
                    <th>дата замовлення</th>
                    <th>дата отримання</th>
                    <th>дата оплати</th>
                    <th>№ накладної</th>
                    <th>ціна</th>
                    <th>постачальник</th>
                    <th>сплачено</th>
                    <th>отримано</th>
                    <th>товари</th>
                </tr>
                </thead>

                <tbody class="color-lines-with-extra" id="deliveries_list">
                <tr>
                    <td>2311</td>
                    <td>2019-10-03</td>
                    <td class="editable-cell edit-date">
                        <span class="value">2019-10-03</span>

                        <label class="input-data">
                            <input type="date" class="input">
                        </label>
                    </td>
                    <td class="editable-cell edit-date">
                        <span class="value">2019-10-03</span>

                        <label class="input-data">
                            <input type="date" class="input">
                        </label>
                    </td>
                    <td>4721</td>
                    <td>472 грн</td>
                    <td>постачальник 1</td>
                    <td class="editable-cell edit-checkbox">
                        <span class="value">&#x2713</span>

                        <div class="input-data checkbox-field">
                            <input type="checkbox" id="is_paid_2311" class="checkbox-style input"/>
                            <label for="is_paid_2311"></label>
                        </div>
                    </td>
                    <td class="editable-cell edit-checkbox">
                        <span class="value">&#x2713</span>

                        <div class="input-data checkbox-field">
                            <input type="checkbox" id="is_received_2311" class="checkbox-style input"/>
                            <label for="is_received_2311"></label>
                        </div>
                    </td>
                    <td class="show-products"><img class="image-transition"
                                                   src="<?php echo PATH ?>/images/drop_down_icon.png"></td>
                </tr>
                <tr class="extra">
                    <td colspan="10">
                        <div class="products-list custom-scrollbar">
                            <ul class="ul-style">
                                <li class="product prod-header">
                                    <div class="number"></div>
                                    <div class="name">назва</div>
                                    <div class="unit-price">ціна за од.</div>
                                    <div class="curr-amount">поточна кількість</div>
                                    <div class="start-amount">поч. кількість</div>
                                    <div class="gen-price">заг. вартість</div>
                                    <div class="date">вжити з</div>
                                    <div class="date">вжити до</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>5432</td>
                    <td>2019-10-03</td>
                    <td class="editable-cell edit-date">
                        <span class="value">2019-10-03</span>

                        <label class="input-data">
                            <input type="date" class="input">
                        </label>
                    </td>
                    <td class="editable-cell edit-date">
                        <span class="value">2019-10-03</span>

                        <label class="input-data">
                            <input type="date" class="input">
                        </label>
                    </td>
                    <td>4721</td>
                    <td>472 грн</td>
                    <td>постачальник 1</td>
                    <td class="editable-cell edit-checkbox">
                        <span class="value">&#x2713</span>

                        <div class="input-data checkbox-field">
                            <input type="checkbox" id="is_paid_5432" class="checkbox-style input"/>
                            <label for="is_paid_5432"></label>
                        </div>
                    </td>
                    <td class="editable-cell edit-checkbox">
                        <span class="value">&#x2713</span>

                        <div class="input-data checkbox-field">
                            <input type="checkbox" id="is_received_5432" class="checkbox-style input"/>
                            <label for="is_received_5432"></label>
                        </div>
                    </td>
                    <td class="show-products"><img class="image-transition"
                                                   src="<?php echo PATH ?>/images/drop_down_icon.png"></td>
                </tr>
                <tr class="extra">
                    <td colspan="10">
                        <div class="products-list custom-scrollbar">
                            <ul class="ul-style">
                                <li class="product prod-header">
                                    <div class="number"></div>
                                    <div class="name">назва</div>
                                    <div class="unit-price">ціна за од.</div>
                                    <div class="curr-amount">поточна кількість</div>
                                    <div class="start-amount">поч. кількість</div>
                                    <div class="gen-price">заг. вартість</div>
                                    <div class="date">вжити з</div>
                                    <div class="date">вжити до</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>1232</td>
                    <td>2019-10-03</td>
                    <td class="editable-cell edit-date">
                        <span class="value">2019-10-03</span>

                        <label class="input-data">
                            <input type="date" class="input">
                        </label>
                    </td>
                    <td class="editable-cell edit-date">
                        <span class="value">2019-10-03</span>

                        <label class="input-data">
                            <input type="date" class="input">
                        </label>
                    </td>
                    <td>4721</td>
                    <td>472 грн</td>
                    <td>постачальник 1</td>
                    <td class="editable-cell edit-checkbox">
                        <span class="value">&#x2713</span>

                        <div class="input-data checkbox-field">
                            <input type="checkbox" id="is_paid_1232" class="checkbox-style input"/>
                            <label for="is_paid_1232"></label>
                        </div>
                    </td>
                    <td class="editable-cell edit-checkbox">
                        <span class="value">&#x2713</span>

                        <div class="input-data checkbox-field">
                            <input type="checkbox" id="is_received_1232" class="checkbox-style input"/>
                            <label for="is_received_1232"></label>
                        </div>
                    </td>
                    <td class="show-products"><img class="image-transition"
                                                   src="<?php echo PATH ?>/images/drop_down_icon.png"></td>
                </tr>
                <tr class="extra">
                    <td colspan="10">
                        <div class="products-list custom-scrollbar">
                            <ul class="ul-style">
                                <li class="product prod-header">
                                    <div class="number"></div>
                                    <div class="name">назва</div>
                                    <div class="unit-price">ціна за од.</div>
                                    <div class="curr-amount">поточна кількість</div>
                                    <div class="start-amount">поч. кількість</div>
                                    <div class="gen-price">заг. вартість</div>
                                    <div class="date">вжити з</div>
                                    <div class="date">вжити до</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
                                </li>
                                <li class="product">
                                    <div class="number">1.</div>
                                    <div class="name">Картопля</div>
                                    <div class="unit-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="curr-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="start-amount">20
                                        <span>кг</span>
                                    </div>
                                    <div class="gen-price">50
                                        <span>грн</span>
                                    </div>
                                    <div class="date">2019-07-01</div>
                                    <div class="date">2019-07-01</div>
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

<?php wp_footer(); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script src="--><?php //echo PATH ?><!--/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo PATH ?><!--/js/general_functions.js"></script>-->

</body>
</html>
