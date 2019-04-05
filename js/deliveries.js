let $ = jQuery;
let fs = require('fs');
let ejs = require('ejs');

let delivery_templ= ejs.compile(fs.readFileSync("./templates/delivery.ejs", "utf8"));
let new_deliv_good_templ= ejs.compile(fs.readFileSync("./templates/new_delivery_good.ejs", "utf8"));

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
    $("#order_date").val(now);
    // $("#receiving_date").val(now);
    // $("#payment_date").val(now);

    let delivery_goods = [];

    let $deliveries_cont = $('#deliveries_list');
    getDeliveries(null, null, null, null);

    addChangeListeners();

    getUnits(function (data) {
        fillUnitsList($("#units"), data);
    });

    getProviders(function (data) {
        fillProviderList($("#providers_list"), data);
    });

    getIngs(function (data) {
        defineNewGoodRow(data);
    });


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

        getDeliveries(date_from, date_to, is_paid, is_received);

        $("#search_date_from").val(null);
        $("#search_date_to").val(null);

        $('#search_orders_btn').click();
    });

    $("#save_delivery").on('click', function () {
      //  let code = 0;
        getProviderCodeByName($("#providers_list").val().trim(),function (data) {
            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'delivery_add',
                    order_date: $("#order_date").val(),
                    receiving_date: $("#receiving_date").val() ? $("#receiving_date").val():'NULL',
                    pay_date: $("#payment_date").val() ? $("#payment_date").val():'NULL',
                    provider_code: data['code'],
                    invoice_num: $("#invoice_num").val() === '' ? 'NULL' : $("#invoice_num").val(),
                    cost: $("#price_value").text(),
                    goods: delivery_goods
                },
                success: function (res) {
                    getDeliveries(null, null, null, null);
                    console.log(res);
                    delivery_goods = [];

                    $("#order_date").val(now);
                    $("#receiving_date").val(null);
                    $("#payment_date").val(null);
                    $("#invoice_num").val('');
                    $("#price_value").text('0');
                    $('.product-item').each(function () {
                        $(this).remove();
                    });

                     $('#add_delivery_btn').click();
                }
            });
        });

        // $("#providers_list").val().trim()
    });

    $('#all_deliveries').on('click', function () {
        getDeliveries(null, null, null, null);
    });

    function fillUnitsList($units_cont, units) {
        $units_cont.html('');
        units.forEach(function (unit) {
            $units_cont.append("<option>" + unit['unit_name'] + "</option>");
        });
    }

    function fillProviderList($provider_cont, prov) {
        $provider_cont.html('');
        prov.forEach(function (el) {
            $provider_cont.append("<option>" + el['company_name'] + "</option>");
        });
    }

    function getUnits(callback) {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'units_select',
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res);
            }
        });
    }

    function getProviders(callback) {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'deliverer_select',
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res);
            }
        });
    }

    function getDeliveries(dateFrom, dateTo, paid, received) {
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
            $parent.find(".is-received-cell").html("&#10003;");

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
            $parent.find(".purchased-cell").html("&#10003;");

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
    }

    function defineNewGoodRow(ings) {
        let $good_name = $("#good_name");
        let $price = $("#price");
        let $amount = $("#amount");
        let $prod_date = $("#production_date");
        let $exp_date = $("#expiration_date");
        let $units = $("#units");
        // let $delivery_num = $("#delivery_num");

        let $ings_list = $(".ings-list");
        let $gen_price = $("#gen_price");

        ings.forEach(function (el) {
            $("#ing_list").append("<option class='ing-option' value='" + el['ing_name'] + "'>");
        });


        $amount.on('input', function () {
            let amount = $(this).val();
            if($price.val()){
                $gen_price.text(($price.val()*amount).toFixed(2));
            }
        });

        $("#add_good").on('click', function () {
                let good_elem = {
                    index:delivery_goods.length + 1,
                    goods_name: $good_name.val(),
                    unit_price: $price.val(),
                    cost: $gen_price.text(),
                    start_amount: $amount.val(),
                    production_date: $prod_date.val() ? $prod_date.val():'NULL',
                    expiration_date: $exp_date.val() ? $exp_date.val():'NULL',
                    ing_name: $ings_list.val(),
                    // delivery_num: $delivery_num.text(),
                    unit_name: $units.val(),
                };
                let $node = $(new_deliv_good_templ(good_elem));

                delivery_goods.push(good_elem);
                $("#new_good").before($node);
                updateDelivPrice(good_elem['cost']);
                //    $("#product_container").prepend($node);

            $good_name.val('');
            $amount.val('');
            $price.val('');
            $prod_date.val(null);
            $exp_date.val(null);
            $ings_list.val('');
            $gen_price.text('0');
        });

        function updateDelivPrice(priceToAdd) {
            let old_price = $('#price_value').text();
            $('#price_value').text('');
            $('#price_value').text((+old_price + +priceToAdd));
        }

        $("#new_delivery_goods_cont").on('click', ".delete-icon", function () {
            let parentTr =  $(this).parents('tr');
            let index = parentTr.find('.index').text() - 1;
            let gen_price = parentTr.find('.gen-good-price').text();
            delivery_goods.splice(index, 1);

            parentTr.nextAll().each(function () {
                let i = $(this).find(".index").text();
                $(this).find(".index").text(i - 1);
            });

            $(this).parents('tr').remove();
            updateDelivPrice(-gen_price);
        });
    }

    function getIngs(callback) {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_ingredients',
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res);
            }
        });
    }

    function getProviderCodeByName(name, callback) {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_deliverer_by_name',
                company_name: name
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res);
            }
        });
    }
});