let $ = jQuery;

let Storage = require('./locStorage');
let fs = require('fs');
let ejs = require('ejs');

let order_templ = ejs.compile(fs.readFileSync("./templates/order.ejs", "utf8"));
let new_order_templ = ejs.compile(fs.readFileSync("./templates/new_order.ejs", "utf8"));

Date.prototype.hrsmins = function () {
    let hrs = this.getHours();
    let mins = this.getMinutes();
    let sec = this.getSeconds();

    return [hrs, mins, (sec > 9 ? '' : '0') + sec
    ].join(':');
};


Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm > 9 ? '' : '0') + mm,
        (dd > 9 ? '' : '0') + dd
    ].join('-');
};

$(function () {
    let today_date = new Date().yyyymmdd();

    let unsaved_orders = [];

    let open_orders = $("#open-orders");
    let $unsaved_orders_cont = $("#unsaved_orders_list");

    $unsaved_orders_cont.on('click', ".dropdown-menu li a", function () {
        $(".dropdown-btn-val .order-header").text($(this).text());
        $(".dropdown-btn-val .order-header").val($(this).text());
    });

    $unsaved_orders_cont.on('click', ".modal-show-btn", function () {
        let item = $(this).parents(".item");
        let modal = item.find(".show-modal");
        modal.modal();

        let input_comment = modal.find(".comment-input-class");
        let comment_text = item.find(".comment");
        let comment = comment_text.text();
        let matches = comment.match(/\[(.*?)\]/);
        if (matches) {
            comment = matches[1];
        }
        input_comment.val(comment);

        modal.find(".save-modal-btn").click(function () {
            let new_comment = input_comment.val();
            if (new_comment != '') {
                item.find(".comment").text("[" + new_comment + "]");

                let dish_name = item.find(".name").text();
                console.log(dish_name);

                let order_num = $(this).parents('.order-item').find('#order_num').text();
                let order_i = unsaved_orders.findIndex(o => o.unique_num == order_num);
                if (order_i > -1) {
                    let dish_i = unsaved_orders[order_i].portions.findIndex(p => p.dish_name == dish_name);
                    if (dish_i > -1) {
                        unsaved_orders[order_i].portions[dish_i].special_wishes = new_comment;
                        Storage.set('unsaved_orders', unsaved_orders);
                    }
                }
            }

        })
    });

    getOrders(false);
    // poll();

    getUnsavedOrders();

    function getOrders(is_closed, tab_num) {
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
                    var $node = $(order_templ({
                        order: o,
                        url: url_object.template_directory,
                        mode: 'orders'
                    }));


                    var isEditing = true;
                    var isPaid = o.is_paid == 1;
                    $node.find('.edit').on('click', function () {
                        isEditing = !isEditing;
                        if (isEditing) {
                            $node.find(".pay-order").removeClass('hide');
                            $node.find(".delete-order").addClass('hide');
                            if (!isPaid)
                                $node.find('.close-order').attr('style', 'display:none');
                        } else {
                            $node.find(".delete-order").removeClass('hide');
                            $node.find(".pay-order").addClass('hide');
                            $node.find('.close-order').attr('style', 'display:inline-block');
                        }
                    });

                    $node.find('.delete-order').on('click', function () {
                        $.ajax({
                            url: url_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'delete_order',
                                unique_num: o.unique_num
                            },
                            success: function (res) {
                                console.log(res);
                                console.log("DELETED");
                                getOrders(false);
                            }
                        });
                    });

                    $node.find('.close-order').on('click', function () {
                        $.ajax({
                            url: url_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'close_order',
                                unique_num: o.unique_num
                            },
                            success: function (res) {
                                console.log(res);
                                getOrders(false);
                            }
                        });
                    });

                    $node.find('.pay-order').on('click', function () {
                        $.ajax({
                            url: url_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'pay_order',
                                unique_num: o.unique_num
                            },
                            success: function (res) {
                                console.log(res);
                                console.log("PAYED");
                                $node.find('.pay-order').attr('style', 'display:none');
                                $node.find('.close-order').attr('style', 'display:inline-block');
                                isPaid = true;
                            }
                        });
                    });

                    if (o.is_paid == 1) {
                        $node.find('.pay-order').attr('style', 'display:none');
                        $node.find('.close-order').attr('style', 'display:inline-block');
                    }
                    //////////////////////
                    $node.find('.box').on('click', function (e) {
                        var is_served = "FALSE";
                        var unique_num = e.target.id.split('-')[1];
                        if(($('#'+e.target.id).is(":checked"))) {
                            // e.target.parentNode.parentNode.classList.add("gray");
                            $('.' + e.target.id).addClass('is-served');
//.removeClass('is-ready')
                            is_served = "TRUE";
                        } else {
                            $('.' + e.target.id).removeClass('is-served');
                        }

                        $.ajax({
                            url: url_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'change_portion_state',
                                is_served: is_served,
                                unique_num:unique_num
                            },
                            success: function (res) {
                                console.log(res);
                                console.log("UPDATED!")
                            }
                        });
                    });



                    open_orders.append($node);
                });
            }
        });
    }

    function getUnsavedOrders() {
        unsaved_orders = Storage.get('unsaved_orders') ? Storage.get('unsaved_orders') : [];

        unsaved_orders.forEach(function (order) {
            let order_cost = 0;
            for (let i = 0; i < order.portions.length; i++)
                order_cost += order.portions[i].price * order.portions[i].quantity;

            $("#unsaved_orders_list").prepend($(new_order_templ({
                order: order,
                cost: order_cost
            })));
        });
    }


    $('#add_order_btn').on('click', function () {
        let order;
        console.log(unsaved_orders.length);
        let last_order_id = getLastOrderId();
        console.log(last_order_id);
        order = {
            unique_num: +last_order_id + 1,
            order_time: new Date().hrsmins(),
            portions: [],
            n_people: 1
        };
        appendNewOrder(order);
    });

    function appendNewOrder(new_order) {
        $unsaved_orders_cont.prepend($(new_order_templ({
            order: new_order,
            cost: 0
        })));

        unsaved_orders.push(new_order);
        Storage.set('unsaved_orders', unsaved_orders);
    }

    function getLastOrderId() {
        return unsaved_orders.length === 0 ? 0 : (unsaved_orders[unsaved_orders.length - 1])['unique_num'];
    }

    $unsaved_orders_cont.on('click', '.add-dish-btn', function () {
        let $parent = $(this).parents('.order-container');
        let order_num = $parent.find('#order_num').text();
        console.log(order_num);

        window.location.href = url_object.menu_page_url + '/?order_num=' + encodeURI(order_num);
    });

    $unsaved_orders_cont.on('input', '#n_people', function () {
        let n_people = $(this).val();

        let $parent = $(this).parents('.order-container');
        let order_num = $parent.find('#order_num').text();

        let orderIndex = unsaved_orders.findIndex(o => o.unique_num == order_num);
        if (orderIndex > -1) {
            unsaved_orders[orderIndex].n_people = n_people;
        }
        Storage.set('unsaved_orders', unsaved_orders);
    });

    $unsaved_orders_cont.on('input', '.quantity', function () {
        let quantity = $(this).val();

        let $parent = $(this).parents('.order-container');
        let order_num = $parent.find('#order_num').text();
        let dish_name = $(this).parents('.item').find('.name').text();

        let orderIndex = unsaved_orders.findIndex(o => o.unique_num == order_num);
        if (orderIndex > -1) {
            console.log(order_templ);
            let i = unsaved_orders[orderIndex].portions.findIndex(d => d.dish_name == dish_name);
            if (i > -1) {
                unsaved_orders[orderIndex].portions[i].quantity = quantity;
            }

            let $total_cost = $(this).parents('.order-container').find('.order-total-cost');
            Storage.set('unsaved_orders', unsaved_orders);
            updateOrderCost(unsaved_orders[orderIndex], $total_cost);
        }
    });


    $unsaved_orders_cont.on('click', "#save_order_btn", function () {
        let $parent = $(this).parents('.order-item');
        let order_num = $parent.find('#order_num').text();
        let order_index = unsaved_orders.findIndex(o => o.unique_num == order_num);

        if (order_index > -1) {
            let order = unsaved_orders[order_index];
            let order_cost = 0;
            for (let i = 0; i < order.portions.length; i++) {
                order_cost += order.portions[i].price * order.portions[i].quantity;
            }
            order['cost'] = order_cost;

            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_new_order',
                    // unique_num: order['unique_num'],
                    order_time: today_date + " " + order['order_time'],
                    table_num: $parent.find('#table_num').text(),
                    is_paid: false,
                    cost: order['cost'],
                    n_people: order['n_people'],
                    portions: order['portions'],
                    tab_num: 516
                },
                success: function (res) {
                    console.log(res);
                    res = JSON.parse(res);
                    let lastid = res['last_id'];

                    if (lastid != null) {
                        getLastInsertedOrder(lastid, function (res) {
                            let $node = $(order_templ({
                                order: res,
                                url: url_object.template_directory,
                                mode: 'orders'
                            }));

                            open_orders.append($node);
                            $parent.remove();
                            unsaved_orders.splice(order_index, 1);
                            Storage.set('unsaved_orders', unsaved_orders);
                        });
                    }
                }
            });
        }
    });

    $unsaved_orders_cont.on('click', "#delete_new_order_btn", function () {
        let $parent = $(this).parents('.order-item');
        let order_num = $parent.find('#order_num').text();
        let order_index = unsaved_orders.findIndex(o => o.unique_num == order_num);
        unsaved_orders.splice(order_index, 1);
        Storage.set('unsaved_orders', unsaved_orders);
        $parent.remove();
    });

    function getLastInsertedOrder(id, callback) {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'orders_select',
                unique_num: id
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res['0']);
            }
        });
    }

    function updateOrderCost(order, $cost_label) {
        let order_cost = 0;
        for (let i = 0; i < order.portions.length; i++)
            order_cost += order.portions[i].price * order.portions[i].quantity;
        $cost_label.text(order_cost);
    }




    function poll() {
        setTimeout(function () {
            getOrders(false);
            poll();
        }, 5000);
    }
});