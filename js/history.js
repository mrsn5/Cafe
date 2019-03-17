var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

var order = ejs.compile(fs.readFileSync("./templates/order.ejs", "utf8"));


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

    var $container = $(".inf-details-block");
    var $container_search = $(".search-area");

    onLoad();

    var $orders_list = $("#orders-list");

    orders_today();

    var now = new Date().yyyymmdd();
    $('#date-from-search').val(now);
    $('#date-to-search').val(now);

    $("#search-button").on('click', function(){
        get_orders(true, $('#date-from-search').val(), $('#date-to-search').val(), ($('#searched-name').val().trim() === ''? null:$('#searched-name').val().trim()))
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

});