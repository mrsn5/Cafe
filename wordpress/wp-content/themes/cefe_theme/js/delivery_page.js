import {rotateImage} from "http://localhost/cafeProject/wordpress/wp-content/themes/cefe_theme/js/general_functions.js";

$(document).ready(function(){

    $(".show-products").on("click", function (event) {
        ($(this).parent().next("tr").find(".delivery-products")).slideToggle();
        rotateImage(($(this).find("img")));
    });
});



