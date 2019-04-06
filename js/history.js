var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

let order = ejs.compile(fs.readFileSync("./templates/order.ejs", "utf8"));
let discarding_templ = ejs.compile(fs.readFileSync("./templates/discarding.ejs", "utf8"));


Date.prototype.yyyymmdd = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm>9 ? '' : '0') + mm,
        (dd>9 ? '' : '0') + dd
    ].join('-');
};


$(function(){
    var $orders = $(".orders-container");
    var $discarding = $(".discarding-container");

    var $orders_search = $(".search-cont-orders");
    var $discarding_search = $(".search-cont-discarding");

    var $container = $(".inf-area");
    var $container_search = $(".search-area");

    onLoad();

    let $orders_list = $("#orders-list");

    orders_today();

    var now = new Date().yyyymmdd();
    $('#date-from-search').val(now);
    $('#date-to-search').val(now);

    $container_search.on('click', "#search-button", function(){
        get_orders(true, $('#date-from-search').val(), $('#date-to-search').val(), ($('#searched-name').val().trim() === ''? null:$('#searched-name').val().trim()))
    });

    $container_search.on('click', "#search_discards", function(){
        get_discardings($('#discarding_date').val(), $('#resp_person').val().trim() === ''? null: $('#resp_person').val().trim());

        $('#discarding_date').val('');
        $('#resp_person').val('');
    });

    $("#today-orders").on('click', function(){
        orders_today();
    });

    $("#orders_btn").on('click', function(){
        onLoad();
    });

    $("#discarding_btn").on('click', function(){
        $container.html('');
        $container_search.html('');
        $container.append($discarding);
        $container_search.append($discarding_search);
        get_discardings();
    });

    function onLoad() {
        $container.html('');
        $container_search.html('');
        $container.append($orders);
        $container_search.append($orders_search);
    }

    function orders_today() {
        $("#prompt-label").text("Замовлення на сьогодні");
        var now = new Date().yyyymmdd();
        console.log(now);
        get_orders(true, now, now);
        $('#date-from-search').val(now);
        $('#date-to-search').val(now);
        $('#searched-name').val('');
    }


    function get_orders(is_closed, order_time_from, order_time_to, name) {
        $orders_list.html("");
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'orders_select',
                is_closed: is_closed,
                name: name,
                order_time_from: order_time_from,
                order_time_to: order_time_to
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
                        mode: 'history'
                    }));
                    $node.find('.is-ready').removeClass('is-ready').attr('style', 'color: rgba(255, 127, 80, 0.6)');
                    $orders_list.append($node);
                });


                var total = 0;
                for(var i=0; i < res.length; i++) {
                    total += parseFloat(res[i].cost);
                }
                $("#total-all").text(total.toFixed(2) + " грн");
                console.log(total);

                $("#num-ord").text(res.length);
            }
        });
    }

    function get_discardings(disc_date, resp_person) {
        let $discarding_list = $('#discarding_list_container');
        $discarding_list.html("");
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'discarding_select',
                disc_date: disc_date,
                resp_person: resp_person
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                res.forEach(function (d) {
                    let $node = $(discarding_templ({
                        discarding: d,
                        url: url_object.template_directory
                    }));
                    $discarding_list.append($node);
                });
            }
        });
    }
});