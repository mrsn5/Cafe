// Personell.push({
//     person: pizza,
//     size: size,
//     quantity: 1
// });

let fs = require('fs');
let ejs = require('ejs');

var personnel= ejs.compile(fs.readFileSync("./templates/personnel.ejs", "utf8"));

var $personnel_table = $("#personnel-table");

$(function() {
    get_personnel(null, null);
});

$("#search-button").click(function () {
    var search_name = $("#search_pib").val().trim();
    var search_position = $("#position").val();
    get_personnel(search_position, search_name);
});

function get_personnel(position, name) {
    $personnel_table.html("");
    $.ajax({
        url: 'http://localhost/Cafe/wordpress/wp-admin/admin-ajax.php',
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
                $personnel_table.append($node);
            });
        }
    });
}

$("#save-personnel").click(function () {
    $.ajax({
        url: 'http://localhost/Cafe/wordpress/wp-admin/admin-ajax.php',
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
            salary: 6000
        },
        success: function (res) {
            console.log(res);
        }
    });
});