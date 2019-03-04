<?php
    /* Template Name: Deliverer */
    define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/orders.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/deliverer.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>
    <title>Постачальники</title>

</head>
<body>


<div class="header">
    <!--    <div class="search-area">-->
    <!--        <input type="text" class="search" id="search_products" placeholder="ПІБ">-->
    <!--        <label for="search_products">-->
    <!--            <img src="--><?php //echo PATH?><!--/images/search.svg" class="search-icon">-->
    <!--        </label>-->
    <!--    </div>-->

    <div class="search-order-btn header-btn-style search-btn" id="search_orders_btn">
        Пошук
    </div>

    <div class="add-btn header-btn-style" id="add_area_btn">
        <span>Додати постачальника</span>
        <img class="img-cont image-transition" src="<?php echo PATH?>/images/drop_down_icon.png">
    </div>

    <ul>
        <li>ІМ'Я КОРИСТУВАЧА</li>
        <li>|</li>
        <li><a href="main.html"><img src="<?php echo PATH?>/images/exit-black.svg" alt="Menu"/></a></li>
    </ul>
</div>


<div class="main">
    <div class="search-area">
        <form>
            <span class="label-header">
                Пошук
                <img src="<?php echo PATH?>/images/search.svg" class="search-icon">
            </span>

            <div class="search-name search-block">
                <label class="label" for="search_pib">Назва</label>
                <input type="text" class="search" id="search_pib" placeholder="Назва постачальника">
            </div>

            <div class="search-name search-block">
                <label class="label" for="search_pib">Продукт</label>
                <input type="text" class="search" id="search_pib" placeholder="Продукт, що поставляє">
            </div>
        </form>
    </div>

    <div class="inf-area">
        <div class="new-item-area new-item-area">
            <div class="new-item-header">
                <span class="header-text">Новий постачальник</span>
                <button class="save-item-btn btn-style" >
                    Зберегти постачальника
                </button>
            </div>
            <div class="main-area">
                <div class="general-inf">
                    <form action="">
                        <div>
                            <p>Про підприємство</p>
                            <div class="inputs-row">
                                <div class="field inline-field" style="width: 30%">
                                    <input type="number" name="code" id="code" placeholder="32855961">
                                    <label class="required-label" for="code">Код ЄДРПОУ</label>
                                </div>

                                <div class="field inline-field" style="width: 50%">
                                    <input type="text" name="name" id="name" placeholder="ТОВ «ЕКСІМ ФУД»">
                                    <label class="required-label" for="name">Назва підприємства</label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p>Контактна інформація</p>
                            <div class="inputs-row">
<!--                                <div>-->
                                <div class="field inline-field" style="width: 50%">
                                    <input type="text" name="contact_person_name" id="contact_person_name" placeholder="Петро Петренко Петрович">
                                    <label class="required-label" for="contact_person_name">Ім'я контактної особи</label>
                                </div>

                                <div class="field inline-field" style="width: 40%">
                                    <input type="tel" name="contact_person_tel" id="contact_person_tel" placeholder="0951234567">
                                    <label class="required-label" for="contact_person_tel">Телефон контактної особи</label>
                                </div>
                            </div>

                            <div class="inputs-row">
                                <div class="field inline-field" style="width: 50%">
                                    <input type="text" name="address" id="address" placeholder="Київ, вул Марини Цвєтаєвої, 14Б">
                                    <label class="required-label" for="address">Адреса</label>
                                </div>


                                <div class="field inline-field" style="width: 40%">
                                    <input type="email" name="email" id="email" placeholder="postachalnyk@example.com">
                                    <label for="email">Електронна пошта </label>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="table-area">
            <table>
                <thead>
                <tr>
                    <th>код ЄДРПОУ</th>
                    <th>назва підприємства</th>
                    <th>адреса</th>
                    <th>ім'я конт. особи</th>
                    <th>тел. конт. особи</th>
                    <th>електронна пошта</th>
                </tr>
                </thead>

                <tbody class="color-lines">
                <tr>
                    <td>32855961</td>
                    <td class="editable-cell">
                        <span class="value"> ТОВ «ЕКСІМ ФУД» </span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">Київ, вул Марини Цвєтаєвої, 14Б</span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">Петро Петренко Петрович</span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">0951234567</span>
                        <label class="input-data">
                            <input type="tel" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">postachalnyk@example.com</span>
                        <label class="input-data">
                            <input type="email" class="input"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>32855961</td>
                    <td class="editable-cell">
                        <span class="value"> ТОВ «ЕКСІМ ФУД» </span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">Київ, вул Марини Цвєтаєвої, 14Б</span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">Петро Петренко Петрович</span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">0951234567</span>
                        <label class="input-data">
                            <input type="tel" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">postachalnyk@example.com</span>
                        <label class="input-data">
                            <input type="email" class="input"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>32855961</td>
                    <td class="editable-cell">
                        <span class="value"> ТОВ «ЕКСІМ ФУД» </span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">Київ, вул Марини Цвєтаєвої, 14Б</span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">Петро Петренко Петрович</span>
                        <label class="input-data">
                            <input type="text" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">0951234567</span>
                        <label class="input-data">
                            <input type="tel" class="input"/>
                        </label>
                    </td>
                    <td class="editable-cell">
                        <span class="value">postachalnyk@example.com</span>
                        <label class="input-data">
                            <input type="email" class="input"/>
                        </label>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script type="module" src="<?php echo PATH?>/js/general_functions.js"></script>
</body>
</html>


