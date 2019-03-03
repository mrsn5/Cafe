<?php
/* Template Name: One New Order */
define("PATH", get_template_directory_uri());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" type="text/css" href="css/orders.css">-->
    <!--<link rel="stylesheet" type="text/css" href="css/new_order.css">-->
    <link rel="stylesheet/less" type="text/css" href="<?php echo PATH?>/less/new_order.less" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js"></script>

    <title>Title</title>
</head>
<body>
<div class="order-container">

        <div class="order-header-panel">
            <div class="order-num">
                <h2 class="order-header">#1203</h2>
                <a class="edit" href=""><img src="<?php echo PATH?>/images/edit.svg" alt="Edit"/></a>
            </div>

            <div class="table-num-list">
                <div class="btn-group">
                    <button class="btn btn-secondary dropdown-btn dropdown-btn-val" type="button">
                        <h2 class="order-header">1</h2>
                    </button>
                    <button  class="btn btn-secondary dropdown-toggle dropdown-toggle-split dropdown-btn dropdown-btn-img" type="button" id="tableListDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="<?php echo PATH?>/images/drop_down_icon.png" >
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#"><h2 class="order-header">1</h2></a></li>
                        <li><a class="dropdown-item" href="#"><h2 class="order-header">5</h2></a></li>
                        <li><a class="dropdown-item" href="#"><h2 class="order-header">12</h2></a></li>
                    </ul>
                </div>
            </div>

            <div class="order-time">
                10:23
            </div>
        </div>
        <div class="order-content">
            <ul>
                <li class="item">
                    <div class="item-info">
                        <span class="item-number">1.</span>
                        <div class="text">
                            <span class="name">Борщ</span>
                            <br/>
                            <span class="comment" id="comment_text"></span>
                        </div>
                        <div class="comment-icon">
                            <a class="modal-show-btn" data-toggle="modal" href="" id="add_comment_btn"><img src="<?php echo PATH?>/images/add-comment2.png" alt="AddComment"/></a>
                        </div>
                    </div>

                    <input type="number"  min="1" class="quantity">
                    <span class="price">127,70 грн</span>

                    <div class="modal fade show-modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title comment-modal-title" id="modal_comment_title">Коментар</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="comment-input-class" id="input_comment">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-style save-modal-btn" id="save_comment" data-dismiss="modal">SAVE</button>
                                    <button type="button" class="btn btn-style close-modal-btn" data-dismiss="modal">CANCEL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="item">
                    <div class="item-info">
                        <span class="item-number">2.</span>
                        <div class="text">
                            <span class="name">Картопля по-селянськи</span>
                            <br/>
                            <span class="comment">[Без часнику]</span>
                        </div>
                        <div class="comment-icon">
                            <a class="modal-show-btn" data-toggle="modal" href=""><img src="<?php echo PATH?>/images/add-comment2.png" alt="AddComment"/></a>
                        </div>
                    </div>

                    <input type="number"  min="1" class="quantity">
                    <span class="price">127,70 грн</span>

                    <div class="modal fade show-modal"  tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title comment-modal-title">Коментар</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="comment-input-class">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-style save-modal-btn" data-dismiss="modal">SAVE</button>
                                    <button type="button" class="btn btn-style close-modal-btn" data-dismiss="modal">CANCEL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="item">
                    <div class="item-info">
                        <span class="item-number">3.</span>
                        <div class="text">
                            <span class="name">Салат</span>
                            <br/>
                            <span class="comment"></span>
                        </div>
                        <div class="comment-icon">
                            <a class="modal-show-btn" data-toggle="modal"><img src="<?php echo PATH?>/images/add-comment2.png" alt="AddComment"/></a>
                        </div>
                    </div>

                    <input type="number"  min="1" class="quantity">
                    <span class="price">127,70 грн</span>

                    <div class="modal fade show-modal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title comment-modal-title">Коментар</h2>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="comment-input-class">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-style save-modal-btn" data-dismiss="modal">SAVE</button>
                                    <button type="button" class="btn btn-style close-modal-btn" data-dismiss="modal">CANCEL</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="item add-new-item">
                    <div class="item-info">
                        <div class="add-block">
                            <img src="<?php echo PATH?>/images/add-icon.png" class="add-icon">
                            <span class="add-new-item-text">Додати страву</span>
                        </div>

                    </div>
                    <a href="#"><span></span></a>
                </li>
            </ul>

            <div class="total">
                <span>Всього</span>
                <span class="total-price">174,42 грн</span>
            </div>

            <div class="control-buttons">
                <button class="ok-button control-btn btn-style">OK</button>
                <button class="cancel-button control-btn btn-style">CANCEL</button>
            </div>
        </div>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed-->
<script src="<?php echo PATH?>/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo PATH?>/js/orders.js"></script>
</body>
</html>
