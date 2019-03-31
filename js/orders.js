let $ = jQuery;

let Storage = require('./locStorage');
let fs = require('fs');
let ejs = require('ejs');

let order = ejs.compile(fs.readFileSync("./templates/order.ejs", "utf8"));
let new_order_templ = ejs.compile(fs.readFileSync("./templates/new_order.ejs", "utf8"));

Date.prototype.hrsmins = function () {
    let hrs = this.getHours();
    let mins = this.getMinutes();

    return [hrs, mins
    ].join(':');
};

$(function(){
    let unsaved_orders = [];

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

    get_unsaved_orders();

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

    function get_unsaved_orders(){
        unsaved_orders = Storage.get('unsaved_orders') ? Storage.get('unsaved_orders') : [];

        unsaved_orders.forEach(function (order) {
            let order_cost = 0;
            for(let i = 0; i< order.dishes.length; i++)
                order_cost += order.dishes[i].dish_price*order.dishes[i].quantity;

            $("#unsaved_orders_list").prepend($(new_order_templ({
                order:order,
                order_cost: order_cost
            })));
        });
    }


    $('#add_order_btn').on('click', function () {
        let order;
        console.log(unsaved_orders.length);
        if(unsaved_orders.length == 0){
            get_next_order_id(function (data) {
                order = {
                    order_num: data['next_id'],
                    order_time: new Date().hrsmins(),
                    dishes: []
                };
                appendNewOrder(order);
            });
        }
        else{
            let last_order = getLastOrder();
            console.log(last_order);
            order = {
                order_num: +(last_order['order_num']) + 1,
                order_time: new Date().hrsmins(),
                dishes: []
            };
            appendNewOrder(order);
        }
    });

    function appendNewOrder(new_order) {
        $("#unsaved_orders_list").prepend($(new_order_templ({
            order: new_order,
            order_cost: 0
        })));

        unsaved_orders.push(new_order);
        Storage.set('unsaved_orders', unsaved_orders);
    }

    function getLastOrder() {
        return unsaved_orders[unsaved_orders.length-1];
    }

    function get_next_order_id(callback){
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_next_order_id',
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res);
            }
        });
    }

    $("#unsaved_orders_list").on('click', '.add-dish-btn', function () {
        let $parent = $(this).parents('.order-container');
        let order_num = $parent.find('#order_num').text();
        console.log(order_num);

        window.location.href = url_object.menu_page_url + '/?order_num=' + encodeURI(order_num);
        // $.ajax({
        //     url: url_object.ajax_url,
        //     type: 'POST',
        //     data: {
        //         action: 'choose_order_dish_mode',
        //         order_num: order_num
        //     },
        //     success: function (res) {
        //         console.log(res);
        //
        //     }
        // });
    });

    $("#unsaved_orders_list").on('input', '.quantity', function () {
        let quantity = $(this).val();

        let $parent = $(this).parents('.order-container');
        let order_num = $parent.find('#order_num').text();
        let dish_name = $(this).parents('.item').find('.name').text();

        let orderIndex = unsaved_orders.findIndex(o => o.order_num == order_num);
        if(orderIndex > -1){
            console.log(order);
            let i = unsaved_orders[orderIndex].dishes.findIndex(d => d.dish_name == dish_name);
            if(i > -1){
                unsaved_orders[orderIndex].dishes[i].quantity = quantity;
            }

            let $total_cost = $(this).parents('.order-container').find('.order-total-cost');
            Storage.set('unsaved_orders', unsaved_orders);
            updateOrderCost(unsaved_orders[orderIndex], $total_cost);
        }
    });


    function updateOrderCost(order, $cost_label) {
        let order_cost = 0;
        for(let i = 0; i< order.dishes.length; i++)
            order_cost += order.dishes[i].dish_price*order.dishes[i].quantity;
        $cost_label.text(order_cost);
    }
});