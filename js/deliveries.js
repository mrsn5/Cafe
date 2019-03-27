let $ = jQuery;
let fs = require('fs');
let ejs = require('ejs');

let delivery_templ= ejs.compile(fs.readFileSync("./templates/delivery.ejs", "utf8"));

Date.prototype.yyyymmdd = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm>9 ? '' : '0') + mm,
        (dd>9 ? '' : '0') + dd
    ].join('-');
};

$(function () {
    let now = new Date().yyyymmdd();
    $('#search_date_from').val(now);
    $('#search_date_to').val(now);

    let $deliveries_cont = $('#deliveries_list');
    get_deliveries(null, null, null, null);

    addChangeListeners();

    $("#search_deliveries").on('click', function() {
        let date_from = $("#search_date_from").val();
        let date_to = $("#search_date_to").val();

        let is_paid = null;
        let is_received = null;

        if(!$('#is_paid_count').is(':checked')){
            is_paid = $('#search_paid').is(':checked');
        }

        if(!$('#is_received_count').is(':checked')){
            is_received = $('#search_received').is(':checked');
        }

        get_deliveries(date_from, date_to, is_paid, is_received);
    });

    $('#all_deliveries').on('click', function () {
        get_deliveries(null, null, null, null);
    });

    function get_deliveries(dateFrom, dateTo, paid, received) {
        console.log(dateFrom);
        console.log(dateTo);
        console.log(paid);
        console.log(received);

        $deliveries_cont.html("");

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'delivery_select',
                date_from: dateFrom,
                date_to: dateTo,
                is_paid: paid,
                is_received: received
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);

                res.forEach(function (delivery) {
                    let goods = delivery['goods'];
                    goods.forEach(function (good) {
                       good['cost'] = good['unit_price']*good['start_amount'];
                    });
                    delivery['goods'] = goods;
                    console.log(delivery);

                    let $node = $(delivery_templ({delivery: delivery}));
                    $deliveries_cont.append($node);
                });
            }
        });
    }


    function addChangeListeners() {
        $deliveries_cont.on('change', '.receiving-date-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".deliv-num").text();
            console.log(code);
            let receiving_date = $(this).val();
            console.log(receiving_date);

            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'delivery_change',
                    code: code,
                    receiving_date: receiving_date
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        $deliveries_cont.on('change', '.pay-date-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".deliv-num").text();
            let pay_date = $(this).val();

            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'delivery_change',
                    code: code,
                    pay_date: pay_date
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        // $deliveries_cont.on('change', '.is-paid-input', function () {
        //     let $parent = ($(this).parents('tr'));
        //     let code = $parent.find(".deliv-num").text();
        //     let is_paid = $(this).is(':checked') ? 1 : 0;
        //
        //     $.ajax({
        //         url: url_object.ajax_url,
        //         type: 'POST',
        //         data: {
        //             action: 'delivery_change',
        //             code: code,
        //             is_paid: is_paid
        //         },
        //         success: function (res) {
        //             console.log(res);
        //             console.log('UPDATED');
        //         }
        //     });
        // });
        //
        // $deliveries_cont.on('change', '.is-received-input', function () {
        //     let $parent = ($(this).parents('tr'));
        //     let code = $parent.find(".deliv-num").text();
        //     let is_received = $(this).is(':checked') ? 1 : 0;
        //
        //     $.ajax({
        //         url: url_object.ajax_url,
        //         type: 'POST',
        //         data: {
        //             action: 'delivery_change',
        //             code: code,
        //             is_received: is_received
        //         },
        //         success: function (res) {
        //             console.log(res);
        //             console.log('UPDATED');
        //         }
        //     });
        // });
    }
});