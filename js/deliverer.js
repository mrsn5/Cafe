var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

let delivererTempl = ejs.compile(fs.readFileSync("./templates/deliverer.ejs", "utf8"));

$(function () {
    let $deliverer_table = $("#deliverer_table");

    getDeliverers(null, null, null);
    addChangeListeners();

    $("#search_deliverer").click(function () {
        var search_name = $("#search_company_name").val().trim();
        var search_product = $("#search_product").val().trim();
        var dish_name = $("#search_dish").val().trim();
        getDeliverers(search_name, search_product, dish_name);
    });

    $("#search_all_ings_deliverer").on('click', function () {
        $deliverer_table.html("");
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'deliverer_all_ings_select',
            },
            success: function (res) {
                res = JSON.parse(res);
                displayDeliverers(res, delivererTempl, $deliverer_table)
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#all_deliveries').on('click', function () {
        getDeliverers(null, null, null);
    });


    $("#save_deliverer").on('click', function () {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'deliverer_add',
                code: $("#code").val(),
                company_name: $("#company_name").val(),
                address: $("#address").val(),
                contact_person_name: $("#contact_person_name").val(),
                contact_person_tel: $("#contact_person_tel").val(),
                email: $("#email").val() == '' ? 'NULL' : $("#email").val()
                // sign_date: $("#sign_date").val()
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                if(res.length > 0)
                    $deliverer_table.append($(delivererTempl(res[0])));
            }
        });
    });


    function getDeliverers(company_name, product, dish) {
        $deliverer_table.html("");
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'deliverer_select',
                company_name: company_name,
                product: product,
                dish_name:dish
            },
            success: function (res) {
                // console.log(res);
                res = JSON.parse(res);
                displayDeliverers(res, delivererTempl, $deliverer_table)
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function displayDeliverers(delivs, delivTempl, table) {
        delivs.forEach(function (d) {
            let $node = $(delivTempl(d));
            table.append($node);
        });
    }


    function addChangeListeners() {
        $deliverer_table.on('change', '.company-name-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".code").text();
            console.log(code);
            let comp_name = $(this).val().trim();
            console.log(comp_name);

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'deliverer_change',
                    code: code,
                    company_name: comp_name
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        $deliverer_table.on('change', '.address-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".code").text();
            let address = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'deliverer_change',
                    code: code,
                    address: address
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        $deliverer_table.on('change', '.cont-person-name-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".code").text();
            let cont_person_name = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'deliverer_change',
                    code: code,
                    contact_person_name: cont_person_name
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        $deliverer_table.on('change', '.cont-person-tel-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".code").text();
            let cont_person_tel = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'deliverer_change',
                    code: code,
                    contact_person_tel: cont_person_tel
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        $deliverer_table.on('change', '.email-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".code").text();
            let email = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'deliverer_change',
                    code: code,
                    email: email
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        $deliverer_table.on('change', '.break-date-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".code").text();
            let break_date = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'deliverer_change',
                    code: code,
                    break_date: break_date
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });

        $deliverer_table.on('change', '.break-reason-input', function () {
            let $parent = ($(this).parents('tr'));
            let code = $parent.find(".code").text();
            let break_reason = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'deliverer_change',
                    code: code,
                    break_reason: break_reason
                },
                success: function (res) {
                    console.log(res);
                    console.log('UPDATED');
                }
            });
        });
    }
});

