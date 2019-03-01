<?php
define("PATH", get_template_directory_uri());
?>

<div class="container">

    <div class="top-panel">
        <div class="img-cont">
            <div class="image-wrap">
                <img src="<?php echo PATH?>/images/food/borsch1.jpg">
            </div>
        </div>


        <div class="inf-block">
            <h1 class="name">Борщ</h1>
            <span class="availability">Недоступно</span>
            <ul>
                <li>
                    <img class="inf-icon weight" src="<?php echo PATH?>/images/icon-weight.png">
                    <span>300 г</span>
                </li>
                <li>
                    <img class="inf-icon price" src="<?php echo PATH?>/images/icon-price.png">
                    <span>30 грн</span>
                </li>
                <li>
                    <img class="inf-icon calories" src="<?php echo PATH?>/images/icon-calories.png">
                    <span>350 ккал</span>
                </li>
                <li>
                    <img class="inf-icon timer" src="<?php echo PATH?>/images/icon-timer.png">
                    <span>30 хв</span>
                </li>
            </ul>
        </div>
    </div>

    <hr class="separator">

    <div class="ingredient-cont">
        <ul class="ing-list">
            <li>
                <div class="ingredient">
                    <span class="ing-name">Буряк</span>
                </div>
            </li>
            <li>
                <div class="ingredient">
                    <span class="ing-name">Картопля</span>
                </div>
            </li>
            <li>
                <div class="ingredient">
                    <span class="ing-name">Морква</span>
                </div>
            </li>
            <li>
                <div class="ingredient">
                    <span class="ing-name">Свинина</span>
                </div>
            </li>
        </ul>
    </div>

    <div class="button-cont">
        <button class="ok-btn btn-style">ДОДАТИ</button>
        <button class="cancel-btn btn-style">НАЗАД</button>
    </div>

</div>

