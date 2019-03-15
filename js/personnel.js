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

    if (position && name) {
        url = '../wp-content/themes/cafe_theme/Backend/personnel.php?type=select&position=' + position + '&name=' + name;
    } else if (position) {
        url = '../wp-content/themes/cafe_theme/Backend/personnel.php?type=select&position=' + position;
    } else if (name) {
        url = '../wp-content/themes/cafe_theme/Backend/personnel.php?type=select&name=' + name;
    } else {
        url = '../wp-content/themes/cafe_theme/Backend/personnel.php?type=select';
    }


    console.log(url);

    fetch(url)
        .then(data=>{return data.json();})
        .then(function (res) {
            console.log(res);
            res.forEach(function (p) {
                var $node = $(personnel(p));
                $personnel_table.append($node);
            });
        });
}

$("#save-personnel").click(function () {
    var tab_num = $("#tab_num").val();
    var position = $("#position-add").val();
    var name = $("#first_name").val();
    var surname = $("#surname").val();
    var fathername = $("#father_name").val();
    var birthdate = $("#birth_date").val();
    var gender = $("#is_male:checked").val() || $("#is_female:checked").val();//? "Ч" : "Ж";
    var address = $("#address").val();
    var telephone = $("#tel_num").val();

    console.log(tab_num, position, name, surname, fathername, birthdate, gender, address, telephone);
    fetch('../wp-content/themes/cafe_theme/Backend/personnel.php?type=add'
                + '&first_name=' + name
                + '&surname=' + surname
                + '&father_name=' + fathername
                + '&tab_num=' + tab_num
                + '&position=' + position
                + '&birth_date=' + birthdate
                + '&gender=' + gender
                + '&address=' + address
                + '&tel_num=' + telephone
                + '&salary=6000')
        .then(data=>{return data.text();})
        .then(function (res) {
                console.log(res);
            });
});