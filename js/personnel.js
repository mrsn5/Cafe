var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

var personnel = ejs.compile(fs.readFileSync("./templates/personnel.ejs", "utf8"));

$(function () {
    var $personnel_table = $("#personnel-table");

    get_personnel(null, null);
    addChangeLiesteners();

    $("#search-button").click(function () {
        var search_name = $("#search_pib").val().trim();
        var search_position = $("#position").val();
        get_personnel(search_position, search_name);
    });

    function get_personnel(position, name) {
        $personnel_table.html("");
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'personnel_select',
                position: position,
                name: name
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                res.forEach(function (p) {
                    var $node = $(personnel(p));
                    $personnel_table.append($node);
                });
            }
        });
    }

    $("#save-personnel").click(function () {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'personnel_add',
                tab_num: $("#tab_num").val(),
                position: $("#position-add").val(),
                first_name: $("#first_name").val(),
                surname: $("#surname").val(),
                father_name: $("#father_name").val() == '' ? 'NULL' : $("#father_name").val(),
                birth_date: $("#birth_date").val(),
                gender: $("#is_male:checked").val() || $("#is_female:checked").val(),
                address: $("#address").val(),
                telephone: $("#tel_num").val(),
                salary: $("#salary-add").val(),
                tel_num: $("#tel_num").val()
            },
            success: function (res) {
                get_personnel(null, null);
                console.log(res);
            }
        });
    });

    $("#all_personnel").click(function () {
        get_personnel(null, null);
    });


    // get_personnel(null, null);
    function addChangeLiesteners() {

        $personnel_table.on('change', '.name-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let first_name = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    first_name: first_name
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.surname-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let surname = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    surname: surname
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.fathername-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let father_name = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    father_name: father_name
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.birthdate-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let birth_date = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    birth_date: birth_date
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.address-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let address = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    address: address
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.gender-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let gender = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    gender: gender
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.position-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let position = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    position: position
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.salary-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let salary = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    salary: salary
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.tel-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let tel_num = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    tel_num: tel_num
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });
    }
});