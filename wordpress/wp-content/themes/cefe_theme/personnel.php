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
    <div class="search-area">
        <input type="text" class="search" id="search_products" placeholder="Пошук">
        <label for="search_products">
            <img src="<?php echo PATH?>/images/search.svg" class="search-icon">
        </label>
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
    <div class="new-worker-area">
        <div class="new-worker-header">
            <!--        <div class="name">-->
            <span class="header-text">Новий робітник</span>
            <!--            <span class="number">#132</span>-->
            <!--        </div>-->
            <button class="save-worker-btn btn-style">
                Зберегти робітника
            </button>
        </div>
        <div class="main-area">
            <div class="general-inf">
                <form>
                    <div class="tab-num">
                        <label for="tab_num">Табельний номер</label>
                        <input type="number" id="tab_num" min="0" required>
                    </div>

                    <div class="name">
                        <p>ПІБ</p>
                        <label for="first_name">Ім'я</label>
                        <input type="text" id="first_name" required />
                        <label for="surname">Прізвище</label>
                        <input type="text" id="surname" required />
                        <label for="father_name">По-батькові</label>
                        <input type="text" id="father_name" required />
                    </div>

                    <div class="date">
                        <p>Персональна інформація</p>
                        <label for="birth_date">Дата народження</label>
                        <input type="date" id="birth_date" value="1980-08-26" required />

                        <div class="radio-btn-block">
                            <input type="radio" id="is_male" class="radio-style" name="gender" checked/>
                            <label for="is_male">Чоловік</label>

                            <input type="radio" id="is_female" class="radio-style" name="gender"/>
                            <label for="is_female">Жінка</label>
                        </div>
                    </div>

                    <div class="address">
                        <p>Контактна інформація</p>
                        <label for="address">Адреса</label>
                        <input type="text" id="address" required />
                        <label for="tel_num">Телефон</label>
                        <input type="tel" id="tel_num" required>
                    </div>


                    <div class="position-list">
                        <!--                    <div class="select-cont">-->
                        <label for="position">Посада</label>
                        <select class="select-position" id="position" name="positions" required>
                            <option value="офіціант">офіціант</option>
                            <option value="бармен">бармен</option>
                            <option value="кухар">кухар</option>
                            <option value="бухгалтер">бухгалтер</option>
                            <option value="адміністратор">адміністратор</option>
                        </select>
                        <!--                    </div>-->
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="table-area">
        <table>
            <thead>
            <tr>
                <th>tab №</th>
                <th>ім'я</th>
                <th>прізвище</th>
                <th>по-батькові</th>
                <th>дата народження</th>
                <th>адреса</th>
                <th>стать</th>
                <th>телефон</th>
                <th>посада</th>
                <th>зарплатня (грн/міс)</th>
            </tr>
            </thead>

            <tbody>
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




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<!--<script type="text/javascript" src="--><?php //echo PATH?><!--/js/orders.js"></script>-->
</body>
</html>

