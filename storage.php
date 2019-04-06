<?php
/* Template Name: Storage */
define("PATH", get_template_directory_uri());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<!--    <link href="--><?php //echo PATH ?><!--/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH ?>/less/storage.less"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <?php wp_head(); ?>
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
        Додати інгредієнт
    </div>

    <div class="header-btn-style" id="inventory_btn">
        Провести інвентаризацію
    </div>

    <div class="header-btn-style toggle-btn" id="discarding_btn">
        <span>Списати</span>
        <img class="img-cont image-transition" src="<?php echo PATH ?>/images/drop_down_icon.png">
    </div>


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
                    <input type="text" class="ing-name input" id="new_ing_name" placeholder="Назва">
                </label>

                <label class="input-style">
                    Одиниці вимірювання
                    <select class="select-units input" id="new_ing_units">
                        <option value="кг">кг</option>
                        <option value="л">л</option>
                        <option value="шт">шт</option>
                    </select>
                </label>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-style save-modal-btn" id="add_ing" data-dismiss="modal">SAVE</button>
                <button type="button" class="btn btn-style close-modal-btn" id="cancel_add_ing" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<div class="main storage-main">
    <div class="search-area">
        <form>
            <div class="search-name search-block">
                <span class="label-header" id="search_ings">Пошук
                    <img src="<?php echo PATH ?>/images/search.svg" class="search-icon">
                </span>

                <div class="input-block">
                    <label class="label" for="search_name">Назва</label>
                    <input type="text" class="search " id="search_ing_name" placeholder="Картопля">
                </div>

                <div class="input-block">
                    <label class="label" for="run_out_date">Скоро зіпсуються</label>
                    <input type="date" id="run_out_date">
                </div>
            </div>

<!--            <div class="search-block">-->
<!--                <span class="label-header">Інгредієнти, що скоро зіпсуються-->
<!--                    <img src="--><?php //echo PATH ?><!--/images/search.svg" class="search-icon">-->
<!--                </span>-->
<!---->
<!--                <div class="input-block">-->
<!--                    <label class="label" for="search_date">Вжити до</label>-->
<!--                    <input type="date" id="search_date">-->
<!--                </div>-->
<!--            </div>-->

            <div class="search-block">
                 <span class="label-header" id="run_out_ings">Інгредієнти, що скінчились
                    <img src="<?php echo PATH ?>/images/search.svg" class="search-icon">
                </span>
<!--                <div class="label" id="absent_ings">Інгредієнти, що скінчились</div>-->
            </div>
        </form>
    </div>

    <div class="inf-area">
        <div class="toggle-area discarding-area">
            <div class="discarding-header">
                <button class="save-discarding-btn btn-style" id="add_discarding">Списати</button>
            </div>
            <div class="products">
                <h3>Продукти</h3>
                <div class="products-list custom-scrollbar">
                    <table class="products-table">
                        <thead>
                        <tr>
                            <th class="number-col" style="width: 5%"></th>
                            <th class="" style="width: 10%">№ товару</th>
                            <th class="" style="width: 15%">назва</th>
                            <th class="" style="width: 7%">один. вимірюв.</th>
                            <th class="" style="width: 7%">ціна за од.</th>
                            <th class="" style="width: 10%">поточна кількість</th>
                            <th class="" style="width: 10%">кількість</th>
                            <th class="" style="width: 10%">заг. вартість (грн)</th>
                            <th class="reason" style="width: 35%">причина</th>
                            <th class="img-col" style="width: 5%"></th>
                        </tr>
                        </thead>

                        <tbody id="disc_goods_list">
                        <!--row for new product-->
                        <tr class="product" id="disc_new_good">
                            <td></td>
                            <td>
                                <label class="input-style">
                                    <input type="number" class="input" id="good_code" placeholder="код"/>
                                </label>
                            </td>

                            <td class="" id="good_name"></td>
                            <td class="" id="good_unit"></td>
                            <td id="price_per_unit">0</td>
                            <td id="curr_amount">0</td>

                            <td class="">
                                <label class="input-style">
                                    <input type="number" class="input" id="good_amount" placeholder="кількість">
                                </label>
                            </td>

                            <td id="good_cost">0</td>

                            <td class="reason-cell">
                                <label class="input-style">
                                    <input type="text" class="input" id="reason" placeholder="причина">
                                </label>
                            </td>
<!--                            <td><img class=" icon" src="--><?php //echo PATH ?><!--/images/delete.svg"></td>-->
                            <td><img class="icon" id="add_good" src="<?php echo PATH ?>/images/checked.svg"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="total">
                    <span>Всього</span>
                    <span class="total-price"><span id="price_value">0</span> грн</span>
                </div>
                <div class="resp-person">
                    <span>Відповідальна особа</span>
                    <label class="input-style">
                        <input class="input" type="text" id="resp_person" placeholder="ПІБ робітника">
                    </label>
                </div>
<!--                <button class="add-product-btn btn-style">Додати продукт</button>-->
            </div>
        </div>

        <div class="table-area">
            <div class="show_items_btn">
                <span id="ivent_print">Друкувати</span>

                <span id="all_items">Всі інгредієнти</span>
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

                <tbody class="color-lines-with-extra" id="ingredient_container">
                </tbody>
            </table>

            <div class="ivent-print ivent-print-header">
                <div class="cafe-name">
                    <label class="input-style">
                        Установа
                        <input class="input" type="text" id="organization">
                    </label>

                    <label class="input-style">
                        Склад
                        <input class="input" type="text" id="storage">
                    </label>
                </div>

                <h3 class="print-header">Інвентаризаційний опис запасів</h3>
            </div>

            <table id="inventory_table">
                <thead>
                <tr>
                    <th>код товару</th>
                    <th style="width: 15%">назва товару</th>
                    <th style="width: 15%">назва інгредієнту</th>
                    <th style="width: 3%">од. вим.</th>
                    <th style="width: 10%">ціна за од.</th>
                    <th>кількість при закупці</th>
                    <th>сума при закупці(грн)</th>
                    <th>очікувана кількість</th>
                    <th>очікувана сума (грн)</th>
                    <th style="width: 10%">фактична кількість</th>
                    <th>фактична сума (грн)</th>
                </tr>
                </thead>

                <tbody class="color-lines" id="ivent_goods_container">

                </tbody>
            </table>

            <div class="ivent-print ivent-print-inputs">
                <div class="ivent-input ivent-person">
                    <span>Матеріально відповідальна особа</span>
                    <div class="ivent-block name-block">
                        <label class="input-style person-input">
                            <input class="input" type="text" id="ivent_position">
                            (посада)
                        </label>

                        <label class="input-style person-input">
                            <input class="input" type="text" id="ivent_person">
                            (прізвище, ініціали)
                        </label>

                        <label class="input-style input-sign">
                            <input class="input" type="text" id="ivent_sign">
                            (підпис)
                        </label>
                    </div>
                </div>


                <div class="ivent-input ivent-date">
                    <span>Дата</span>
                    <div class="ivent-block date-block">
                        <label class="input-style date-input">
                            <input class="input" type="text" id="ivent_date">
                        </label>
<!--                        <label class="input-style date-input">-->
<!--                            завершено-->
<!--                            <input class="input" type="text" id="ivent_date">-->
<!--                        </label>-->
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>



<?php wp_footer(); ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--<script src="--><?php //echo PATH ?><!--/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>-->
<!---->
<!--<script type="text/javascript" src="--><?php //echo PATH ?><!--/js/general_functions.js"></script>-->
<!--<script type="text/javascript" src="--><?php //echo PATH ?><!--/js/storage.js"></script>-->
</body>

</html>