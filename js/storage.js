let $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

let ing_templ = ejs.compile(fs.readFileSync("./templates/ingredient.ejs", "utf8"));
let disc_good_templ = ejs.compile(fs.readFileSync("./templates/discarding_good_row.ejs", "utf8"));
let iventarization_temlp = ejs.compile(fs.readFileSync("./templates/iventarization_row.ejs", "utf8"));

Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm > 9 ? '' : '0') + mm,
        (dd > 9 ? '' : '0') + dd
    ].join('-');
};

$(function () {
        let now = new Date().yyyymmdd();

        let $inventory_table = $('#inventory_table');
        let $ingredients_table = $('#ingredients_table');
        let $ivent_print = $('#ivent_print');

        function show_ings_table() {
            $ingredients_table.show();
            $inventory_table.hide();
            $ivent_print.css('visibility', 'hidden');
        }

        function show_inv_table() {
            $ingredients_table.hide();
            $inventory_table.show();
            $ivent_print.css('visibility', 'visible');
        }

        // $inventory_table.hide();

        $('#inventory_btn').on('click', function () {
            show_inv_table();

            iventarization(function (res) {
                $('#ivent_goods_container').html('');
                res.forEach(function (row) {
                    $('#ivent_goods_container').append($(iventarization_temlp(row)));
                });
            });
        });

        // $('#all_items').on('click', function () {
        //     $ingredients_table.show();
        //     $inventory_table.hide();
        //     $ivent_print.css('visibility', 'hidden');
        // });

        let $ings_cont = $("#ingredient_container");
        let ings_units = [];

        get_units(function (data) {
            ings_units = data;
            get_ings(null, null, null);
            add_change_listeners();
            fill_new_ing_units(ings_units);
        });

        add_new_discarding();
        ivent_listeners();

        $("#search_ings").on('click', function () {
            show_ings_table();

            let search_name = $("#search_ing_name").val().trim();
            let search_run_out_date = $("#run_out_date").val();
            get_ings(search_name, search_run_out_date, null);

            $("#run_out_date").val(null);
            $("#search_ing_name").val('');
            $('#search_personnel_btn').click();
        });

        $("#run_out_ings").on('click', function () {
            get_ings(null, null, true);
        });

        $("#all_items").on('click', function () {
            show_ings_table();
            get_ings(null, null, null);
        });

        $('#ivent_print').on('click', function () {
            let goods = [];

            $('.ivent-item').each(function () {
                let good_code = $(this).find('.good-code').text();
                let curr_amount = $(this).find('.curr-amount-input').val();

               let good = {
                   good_code: good_code,
                   curr_amount: curr_amount == '' ? 0 : curr_amount
               };
                goods.push(good);
            });
            console.log(goods);

            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_goods_amount',
                    goods: goods
                },

                success: function (res) {
                    res = JSON.parse(res);
                    console.log(res);
                }
            });

            //  openPrintDialogue();
            $('#ivent_goods_container').find('.ivent-item').each(function () {
                //    $(this).find('.input-style').hide();
                let val = $(this).find('.curr-amount-input').val();
                $(this).find('.curr-amount-text').text(val == '' ? 0 : val);
            });
            window.print();

            $('#ivent_goods_container').find('.ivent-item').each(function () {
                //    $(this).find('.input-style').show();
                $(this).find('.curr-amount-text').text('');
                //  $(this).find('.curr-amount').html($(this).find('.curr-amount-input').val());
            });
        });

        $("#add_ing").on('click', function () {
            add_ing();
        });

        $("#cancel_add_ing").on('click', function () {
            $("#new_ing_name").val('');
            $("#new_ing_units").val(ings_units[0]);
        });

        function get_ings(name, exp_date, run_out_ings) {
            $ings_cont.html("");

            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'ingredient_select',
                    name: name === "" ? null : name,
                    exp_date: exp_date,
                    run_out_ings: run_out_ings
                },

                success: function (res) {
                    res = JSON.parse(res);
                    console.log(res);
                    res.forEach(function (ing) {
                        let $node = $(ing_templ({
                            ing: ing,
                            units: ings_units
                        }));
                        $ings_cont.append($node);
                    });
                }
            });
        }

        function get_units(callback) {
            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'ing_units_select'
                },

                success: function (res) {
                   res = JSON.parse(res);
                    console.log(res);
                    // let array = res.split(",");
                    // console.log(array);
                    callback(res);
                    // if(res != null){
                    //     ings_units = res;
                    // }
                }
            });
        }

        function add_change_listeners() {
            $ings_cont.on('change', '.ing-units-list', function () {
                let $parent = ($(this).parents('tr'));
                let name = $parent.find(".ing-name").text();
                console.log(name);

                let unit = $(this).val();
                console.log(unit);

                $.ajax({
                    url: url_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ing_change',
                        name: name,
                        unit: unit
                    },
                    success: function (res) {
                        console.log(res);
                        console.log('UPDATED');
                    }
                });
            });
        }

        function add_ing() {
            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'ing_add',
                    ing_name: $("#new_ing_name").val(),
                    units: $("#new_ing_units").val()
                },
                success: function (res) {
                    get_ings(null, null, null);
                    console.log(res);
                }
            });
        }

        function fill_new_ing_units(units) {
            let $units_list = $("#new_ing_units");
            $units_list.html('');
            units.forEach(function (unit) {
                $units_list.append("<option>" + unit + "</option>");
            });
        }

        function add_new_discarding() {
            let disc_goods = [];
            let goods = [];

            let $good_code = $("#good_code");
            // let $delivery_num = $("#delivery_code");
            let $amount = $("#good_amount");
            let $reason = $("#reason");

            let $good_name = $("#good_name");
            let $good_unit = $("#good_unit");
            let $cost = $("#good_cost");
            let $price_per_unit = $('#price_per_unit');
            let $curr_amount = $('#curr_amount');

            let $resp_person = $('#resp_person');

            getGoods(function (data) {
                goods = data;
                addListeners();
            });

            function getGoods(callback) {
                $.ajax({
                    url: url_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'get_all_goods'
                    },
                    success: function (res) {
                        res = JSON.parse(res);
                        console.log(res);
                        callback(res);
                    }
                });
            }

            function addListeners() {
                $('#add_discarding').on('click', function () {

                    getEmployeeCodeByName($resp_person.val().trim(), function (data) {
                        if (data != null) {
                            $.ajax({
                                url: url_object.ajax_url,
                                type: 'POST',
                                data: {
                                    action: 'discarding_add',
                                    date: now,
                                    goods: disc_goods,
                                    cost: $('#price_value').text(),
                                    resp_person: data['tab_num']
                                },
                                success: function (res) {
                                    console.log(res);
                                    disc_goods = [];

                                    getGoods(function (data) {
                                        goods = [];
                                        goods = data;
                                    });
                                    $('#discarding_btn').click();
                                }
                            });
                        } else {
                            alert('Необхідно вказати відповідальну особу');
                        }
                    });

                    $('.good-item').remove();
                    $('#price_value').text('0');

                    $resp_person.val('');

                    $good_code.val('');
                    // $delivery_num.val('');
                    $amount.val('');
                    $reason.val('');
                    $good_name.text('');
                    $good_unit.text('');
                    $cost.text('0');
                    $curr_amount.text('0');
                    $price_per_unit.text('0');
                });

                $('.storage-main').on("click", function (e) {
                    if (!$good_code.is(e.target) && $good_code.has(e.target).length === 0) {
                        let code = $good_code.val().trim();

                        let good = goods.find(curr_good => curr_good['unique_code'] == code);
                        if (good) {
                            $good_name.text(good['goods_name']);
                            $good_unit.text(good['unit_name']);
                            $price_per_unit.text(good['unit_price']);
                            $curr_amount.text(good['curr_amount']);

                            $amount.attr({
                                "max": good['curr_amount']
                            });
                        }
                    }
                });

                $amount.on('keyup keydown', function (e) {
                    let max = parseInt($(this).attr('max'));
                    if ($(this).val() > max) {
                        e.preventDefault();
                        $(this).val(max);
                    }

                    let amount = $(this).val();
                    if ($price_per_unit.text()) {
                        $cost.text(($price_per_unit.text() * amount).toFixed(2));
                    }
                });

                $("#add_good").on('click', function () {
                    let good_elem = {
                        index: disc_goods.length + 1,
                        // delivery_num: $delivery_num.val(),
                        good_code: $good_code.val(),
                        goods_name: $good_name.text(),
                        good_unit: $good_unit.text(),
                        unit_price: $price_per_unit.text(),
                        curr_amount: $curr_amount.text(),
                        cost: $cost.text(),
                        amount: $amount.val(),
                        reason: $reason.val()
                    };
                    let $node = $(disc_good_templ(good_elem));

                    disc_goods.push(good_elem);
                    $("#disc_new_good").before($node);
                    updateDiscPrice(good_elem['cost']);
                    //    $("#product_container").prepend($node);

                    $good_code.val('');
                    // $delivery_num.val('');
                    $amount.val('');
                    $reason.val('');
                    $good_name.text('');
                    $good_unit.text('');
                    $cost.text('0');
                    $curr_amount.text('0');
                    $price_per_unit.text('0');
                });

                $("#disc_goods_list").on('click', ".delete-icon", function () {
                    let parentTr = $(this).parents('tr');
                    let index = parentTr.find('.index').text() - 1;
                    let cost = parentTr.find('.cost').text();
                    disc_goods.splice(index, 1);

                    parentTr.nextAll().each(function () {
                        let i = $(this).find(".index").text();
                        $(this).find(".index").text(i - 1);
                    });

                    $(this).parents('tr').remove();
                    updateDiscPrice(-cost);
                });
            }

            function updateDiscPrice(priceToAdd) {
                let old_price = $('#price_value').text();
                $('#price_value').text('');
                $('#price_value').text((+old_price + +priceToAdd));
            }

            function getEmployeeCodeByName(name, callback) {
                console.log('name: ' + name);
                let names = name.split(' ');
                // console.log('names: ' + name);

                $.ajax({
                    url: url_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'get_employee_by_name',
                        surname: names[0],
                        first_name: names[1],
                        father_name: names.length > 2 ? names[2] : ''
                    },
                    success: function (res) {
                        res = JSON.parse(res);
                        console.log(res);
                        callback(res);
                    }
                });
            }
        }

        function iventarization(callback) {
            $.ajax({
                url: url_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'iventarization'
                },

                success: function (res) {
                    res = JSON.parse(res);
                    console.log(res);
                    callback(res);
                }
            });
        }

        function ivent_listeners() {
            $('#ivent_goods_container').on('input', '.curr-amount-input', function () {
                let amount = $(this).val();

                let parentTr = $(this).parents('tr');
                let price_per_unit = parentTr.find('.price-per-unit').text();
                let $curr_price = parentTr.find('.curr-price');

                $curr_price.text((price_per_unit * amount).toFixed(2));
            });
        }
    }
);