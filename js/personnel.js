var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

var personnel = ejs.compile(fs.readFileSync("./templates/personnel.ejs", "utf8"));

$(function () {
    var $personnel_table = $("#personnel-table");

    get_personnel(null, null);

    $("#search-button").click(function () {
        var search_name = $("#search_pib").val().trim();
        var search_position = $("#position").val();
        get_personnel(search_position, search_name);
    });

    function get_personnel(position, name) {
        console.log(ajax_object);
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
                res.forEach(function (p) {
                    var $node = $(personnel(p));

                    $node.find('.name-input').on('change', function () {
                        $ajax({

                        });
                    });

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
                salary: $("#salary-add").val()
            },
            success: function (res) {
                console.log(res);
            }
        });
    });
});