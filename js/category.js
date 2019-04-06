let Gen = require("./general_functions");

let $ = jQuery;

let Storage = require('./locStorage');
let fs = require('fs');
let ejs = require('ejs');

let dishTempl = ejs.compile(fs.readFileSync("./templates/dish.ejs", "utf8"));


$(function () {
    let url_params = Gen.decodeUrl();

    let menu_url = url_object.menu_page_url;
    if (url_params['order_num'])
        menu_url += '/?order_num=' + url_params['order_num'];

    $('#menu_link').attr("href", menu_url);

    let $dishes_container = $("#dishes_container");
    let $cat_name_label = $("#category_name");
    let cat_name = Storage.get('cat_name');

    $cat_name_label.text(cat_name);

    getDishes();

    function getDishes() {
        // $dishes_container.html('');

        let action_name = '';
        switch (cat_name) {
            case 'Топ ліст':
                action_name = 'top_list';
                $('.search-area').hide();
                break;
            case 'Стоп ліст':
                action_name = 'stop_list';
                $('.search-area').hide();
                break;
            default:
                action_name = 'cat_select';
        }

        select_dishes(action_name);

        // $.ajax({
        //     url: url_object.ajax_url,
        //     type: 'POST',
        //     data: {
        //         action: action_name,
        //         cat_name: cat_name
        //     },
        //     success: function (res) {
        //         res = JSON.parse(res);
        //         console.log(res);
        //
        //         res.forEach(function (d) {
        //             var $node = $(dishTempl({
        //                 dish: d,
        //                 url_object: url_object,
        //                 choose_mode: url_params['order_num']
        //             }));
        //             $dishes_container.append($node);
        //         });
        //     }
        // });

        $dishes_container.on('click', '.ok-btn', function () {
            //      if(url_params['order_num']) {
            let $parent = $(this).parents('.dish');
            let dish_name = $parent.find('.name').text();
            let dish_price = $parent.find('.dish-price-span').text();
            let tech_card_num = $parent.find('#tech_card_num').text();

            let unsaved_orders = Storage.get('unsaved_orders');
            // let curr_order = unsaved_orders.find(order => order.order_num == data['order_num']);
            let order_index = unsaved_orders.findIndex(order => order.unique_num == url_params['order_num']);

            if (order_index > -1) {
                unsaved_orders[order_index].portions.push({
                    tech_card_num: tech_card_num,
                    dish_name: dish_name,
                    special_wishes: '',
                    price: dish_price,
                    quantity: 1
                });
            }

            Storage.set('unsaved_orders', unsaved_orders);
            window.location.href = url_object.orders_page_url;
        });

        // $dishes_container.on('click', '#delete_dish', function () {
        //     let $parent = $(this).parents('.dish');
        //     let tech_card_num = $parent.find('#tech_card_num').text();
        //
        //     if(tech_card_num){
        //         $.ajax({
        //             url: url_object.ajax_url,
        //             type: 'POST',
        //             data: {
        //                 action: 'delete_dish',
        //                 tech_card_num: tech_card_num
        //             },
        //             success: function (res) {
        //                 // res = JSON.parse(res);
        //                 console.log(res);
        //                 $parent.remove();
        //             }
        //         });
        //     }
        // });
    }

    function select_dishes(action_name, dish_name){
        $dishes_container.html('');

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: action_name,
                cat_name: cat_name,
                dish_name: dish_name
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);

                res.forEach(function (d) {
                    var $node = $(dishTempl({
                        dish: d,
                        url_object: url_object,
                        choose_mode: url_params['order_num']
                    }));
                    $dishes_container.append($node);
                });
            }
        });
    }

    $('#search_btn').on('click', function () {
       let dish_name = $('#search_products').val() === "" ? null : $('#search_products').val();
        select_dishes('cat_select', dish_name);
        $('#search_products').val('');
    });

    $('#search_products').keypress(function(event){
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            $('#search_btn').click();
        }
        event.stopPropagation();
    });

    $dishes_container.on('click', '.toggle-btn', function (event) {
        $(this).parent().find('.toggle-area').slideToggle();
        Gen.rotateImage($(this).find(".img-cont"));
    });

});