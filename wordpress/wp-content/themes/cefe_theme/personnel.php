<?php
    /* Template Name: Personnel */
    define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/orders.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/personnel.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>
    <title>Персонал</title>

</head>
<body>


<div class="header">
<!--    <div class="search-area">-->
<!--        <input type="text" class="search" id="search_products" placeholder="ПІБ">-->
<!--        <label for="search_products">-->
<!--            <img src="--><?php //echo PATH?><!--/images/search.svg" class="search-icon">-->
<!--        </label>-->
<!--    </div>-->

    <div class="header-btn-style search-btn" id="search_personnel_btn">
        Пошук
    </div>

    <div class="add-btn header-btn-style" id="add_area_btn">
        <span>Додати робітника</span>
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
                <label class="label" for="search_pib">ПІБ</label>
                <input type="text" class="search" id="search_pib" placeholder="Петро Петренко Петрович">
            </div>

            <div class="search-worker search-block">
                <label class="label" for="position">Посада</label>
                <select class="select-position" id="position" name="positions" required>
                    <option value="офіціант">офіціант</option>
                    <option value="бармен">бармен</option>
                    <option value="кухар">кухар</option>
                    <option value="бухгалтер">бухгалтер</option>
                    <option value="адміністратор">адміністратор</option>
                </select>
            </div>
        </form>
    </div>

    <div class="inf-area">
        <div class="new-item-area">
            <div class="new-item-header">
                <span class="header-text">Новий робітник</span>
                <button class="save-item-btn btn-style" >
                    Зберегти робітника
                </button>
            </div>
            <div class="main-area">
<!--                <div class="general-inf">-->
                    <form action="">

                        <div>
                            <p>Робоча інформація</p>
                            <div class="inputs-row">
                                <div class="field inline-field">
                                    <input type="number" name="tab" id="tab_num" placeholder="1234">
                                    <label for="tab_num">Табельний номер</label>
                                </div>

                                <div class="field inline-field position-list">
                                    <div class="select-cont">
                                        <select class="select-position" id="position" name="positions" required>
                                            <option value="офіціант">офіціант</option>
                                            <option value="бармен">бармен</option>
                                            <option value="кухар">кухар</option>
                                            <option value="бухгалтер">бухгалтер</option>
                                            <option value="адміністратор">адміністратор</option>
                                        </select>
                                    </div>
                                    <label class="label-without-trans" for="position">Посада</label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p>ПІБ</p>
                            <div class="inputs-row">
                                <div class="field inline-field">
                                    <input type="text" name="first_name" id="first_name" placeholder="Петро">
                                    <label for="first_name">Ім'я</label>
                                </div>

                                <div class="field inline-field">
                                    <input type="text" name="surname" id="surname" placeholder="Петренко">
                                    <label for="surname">Прізвище</label>
                                </div>

                                <div class="field inline-field">
                                    <input type="text" name="father_name" id="father_name" placeholder="Петрович">
                                    <label for="father_name">По батькові</label>
                                </div>
                            </div>
                        </div>


                        <div>
                            <p>Песональні дані</p>
                            <div class="personal-inf">
                                <div class="date-field inline-field">
                                    <input type="date" name="birth_date" id="birth_date" value="1999-02-20">
                                    <label class="label-without-trans" for="birth_date">Дата народження</label>
                                </div>

                                <fieldset class="radio-btn-field" id="gender">
                                    <legend>Стать</legend>
                                    <input type="radio" id="is_male" class="radio-style" name="gender" checked/>
                                    <label for="is_male">Чоловік</label>

                                    <input type="radio" id="is_female" class="radio-style" name="gender"/>
                                    <label for="is_female">Жінка</label>
                                </fieldset>
                            </div>
                        </div>

                        <div>
                            <p>Контактна інформація</p>
                            <div class="inputs-row">
                                <div class="field inline-field" style="width: 50%">
                                    <input type="text" name="address" id="address" placeholder="Київ, вул Марини Цвєтаєвої, 14Б">
                                    <label for="address">Адреса</label>
                                </div>

                                <div class="field inline-field">
                                    <input type="tel" name="tel_num" id="tel_num" placeholder="0951234567">
                                    <label for="tel_num">Телефон</label>
                                </div>
                            </div>
                        </div>

                    </form>
<!--                </div>-->
            </div>
        </div>
        <div class="table-area">
            <table>
                <thead>
                <tr>
                    <th>tab №</th>
                    <th>ім'я</th>
                    <th>прізвище</th>
                    <th>по батькові</th>
                    <th>дата народження</th>
                    <th>адреса</th>
                    <th>стать</th>
                    <th>телефон</th>
                    <th>посада</th>
                    <th>зарплатня (грн/міс)</th>
                </tr>
                </thead>

                <tbody class="color-lines">
                <tr>
                    <td>12</td>
                    <td>Денис</td>
                    <td>Іваненко</td>
                    <td>Петрович</td>
                    <td>1988-10-02</td>
                    <td>Київ, вул. Марини Цвєтаєвої, 14Б</td>
                    <td>ч</td>
                    <td>0987654321</td>
                    <td>офіціант</td>
                    <td>5000</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Денис</td>
                    <td>Іваненко</td>
                    <td>Петрович</td>
                    <td>1988-10-02</td>
                    <td>Київ, вул. Марини Цвєтаєвої, 14Б</td>
                    <td>ч</td>
                    <td>0987654321</td>
                    <td>офіціант</td>
                    <td>5000</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Денис</td>
                    <td>Іваненко</td>
                    <td>Петрович</td>
                    <td>1988-10-02</td>
                    <td>Київ, вул. Марини Цвєтаєвої, 14Б</td>
                    <td>ч</td>
                    <td>0987654321</td>
                    <td>офіціант</td>
                    <td>5000</td>
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

