let $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

let ing_templ = ejs.compile(fs.readFileSync("./templates/ingredient.ejs", "utf8"));


$(function(){
    let $inventory_table = $('#inventory_table');
    let $ingredients_table = $('#ingredients_table');

    // $inventory_table.hide();

    $('#inventory_btn').on('click', function () {
        $ingredients_table.hide();
        $inventory_table.show();
    });

    $('#all_ings').on('click', function () {
        $ingredients_table.show();
        $inventory_table.hide();
    });

    $ings_cont = $("#ingredient_container");
    ings_units = [];

    get_units(function (data) {
        ings_units = data;
        get_ings(null, null, null);
        addChangeListeners();
    });

    $("#search_ings").on('click', function () {
        let search_name = $("#search_ing_name").val().trim();
        let search_run_out_date = $("#run_out_date").val();
        get_ings(search_name, search_run_out_date, null);

        $("#run_out_date").val(null);
        $("#search_ing_name").val('');
    });

    $("#run_out_ings").on('click', function () {
        get_ings(null, null, true);
    });

    $("#all_items").on('click', function () {
        get_ings(null, null, null);
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
                        ing:ing,
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

    function addChangeListeners() {
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
});