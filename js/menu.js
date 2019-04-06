let Gen = require("./general_functions");
var $ = jQuery

let Storage = require('./locStorage');
let fs = require('fs');
let ejs = require('ejs');

let category = ejs.compile(fs.readFileSync("./templates/category.ejs", "utf8"));
let ing_row = ejs.compile(fs.readFileSync("./templates/new_dish_ing_row.ejs", "utf8"));


$(function () {
    Gen.get_user_role(url_object.ajax_url, function (user_role) {
        console.log(user_role);
        // if(user_role !== 'кухар' || user_role !== 'шеф-кухар'){
        //     $('#add_dish_btn').hide();
        // }

        if(user_role !== "administrator"){
            $('#top_list').hide();
            $('#stop_list').hide();
        }
    });

    let url_params = Gen.decodeUrl();

    let $categories_container = $("#categories_container");
    let $cat_list = $("#categories_add");
    let $ings_list = $("#ing_list");
    let dish_ings = [];

    getCategories(function (data) {
        displayCategories(data);
        categoriesList(data);
    });

    getIngs(function (data) {
        defineNewIngRow(data);
    });

    $("body").on('click', ".category-name", function () {
        let cat_name = $(this).text().trim();
        Storage.set('cat_name', cat_name);

        let url = url_object.category_page_url;
        if (url_params['order_num'])
            url += '/?order_num=' + encodeURI(url_params['order_num']);
        window.location.href = url;
    });


    $("#save_dish_btn").on('click', function () {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'dish_add',
                tech_num: $("#tech_num").val(),
                calc_num: $("#calc_num").val(),
                dish_name: $("#dish_name").val(),
                department: $("#department").val(),
                category: $("#categories_add").val(),
                weight: $("#weight").val(),
                calories: $("#calories").val(),
                cooking_time: $("#cooking_time").val(),
                ings: dish_ings,
                price: $("#price_value").text()
            },
            success: function (res) {
                //   get_personnel(null, null);
                console.log(res);
                $("#tech_num").val('');
                $("#calc_num").val('');
                $("#dish_name").val('');
                $("#department").val('');
                $("#categories_add").val('');
                $("#weight").val('');
                $("#calories").val('');
                $("#cooking_time").val('');
                $("#price_value").text('0');
                $('#add_dish_btn').click();

                $('.dish-ing-row').each(function () {
                   $(this).remove();
                });

                dish_ings = [];
            }
        });
    });

    function displayCategories(cats) {
        $categories_container.html("");
        cats.forEach(function (cat) {
            let $node = $(category(cat));

            $categories_container.append($node);
        });
    }

    function categoriesList(cats) {
        cats.forEach(function (el) {
            $cat_list.append("<option>" + el['cat_name'] + "</option>");
        });
    }

    function updateDishPrice(ings) {
        let new_price = 0;

        ings.forEach(function (ing) {
            new_price = new_price + +ing['gen_price'];
        });

        $('#price_value').text((new_price * 1.5).toFixed(2));
    }

    function defineNewIngRow(ings) {
        let $ings_select = $(".ings-select");
        let $amount_input = $(".amount-input");
        let $price_cell = $("#price_cell");
        let $gen_price_cell = $("#gen_price_cell");

        let ing = undefined;
        $ings_select.on('input', function () {
            let ing_name = $(this).val();
            ings.forEach(function (el) {
                if (el['ing_name'] === ing_name)
                    ing = el;
            });

            if (ing) {
                $price_cell.text((+(ing['unit_price'])).toFixed(5));
            }
        });

        $amount_input.on('input', function () {
            let amount = $(this).val();
            if (ing) {
                $gen_price_cell.text((ing['unit_price'] * amount).toFixed(2));
            }
        });

        $("#add_ingredient").on('click', function () {
            if (ing) {
                let ing_elem = {
                    index: dish_ings.length + 1,
                    ing_name: ing['ing_name'],
                    ing_amount: $amount_input.val(),
                    unit_price: (+ing['unit_price']).toFixed(5),
                    gen_price: $gen_price_cell.text()
                };
                let $node = $(ing_row(ing_elem));

                dish_ings.push(ing_elem);
                $("#new_product").before($node);
                updateDishPrice(dish_ings);
                //    $("#product_container").prepend($node);
            }

            $ings_select.val('');
            $amount_input.val('');
            $price_cell.text('0');
            $gen_price_cell.text('0');
        });

        $("#product_container").on('click', ".delete-ing", function () {
            let index = $(this).parents('tr').find('.index').text() - 1;
            dish_ings.splice(index, 1);

            $(this).parents('tr').nextAll().each(function () {
                let i = $(this).find(".index").text();
                $(this).find(".index").text(i - 1);
            });

            $(this).parents('tr').remove();
            updateDishPrice(dish_ings);
        });

        ings.forEach(function (el) {
            $ings_list.append("<option class='ing-option' value='" + el['ing_name'] + "'>");
        });
    }

    function getCategories(callback) {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'categories_select',
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res);
            }
        });
    }

    function getIngs(callback) {
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'с',
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                callback(res);
            }
        });
    }
});