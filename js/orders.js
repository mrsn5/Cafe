var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

var order = ejs.compile(fs.readFileSync("./templates/order.ejs", "utf8"));

$(function(){

    $(".dropdown-menu li a").click(function(){
        $(".dropdown-btn-val .order-header").text($(this).text());
        $(".dropdown-btn-val .order-header").val($(this).text());
    });


    $(".modal-show-btn").on('click', function () {
        var item = $(this).parents(".item");
        var modal = item.find(".show-modal");
        modal.modal();

        var input_comment =  modal.find(".comment-input-class");
        var comment_text = item.find(".comment");
        var comment = comment_text.text();
        var matches = comment.match(/\[(.*?)\]/);
        if(matches){
            comment = matches[1];
        }
        input_comment.val(comment);

        modal.find(".save-modal-btn").click(function () {
            var new_comment = input_comment.val();
            item.find(".comment").text("[" + new_comment + "]");
        })
    });

    var open_orders = $("#open-orders");

    get_orders(false);

    function get_orders(is_closed, tab_num) {
        open_orders.html("");
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'orders_select',
                is_closed: is_closed,
                name: null,
                order_time_from: null,
                order_time_to: null,
                tab_num: tab_num
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                console.log(res);
                res.forEach(function (o) {
                    // console.log(url_object.template_directory);
                    var $node = $(order({
                        order: o,
                        url: url_object.template_directory,
                        mode: 'orders'
                    }));
                    open_orders.append($node);
                });
            }
        });
    }


});