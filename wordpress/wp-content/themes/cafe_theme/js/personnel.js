// Personell.push({
//     person: pizza,
//     size: size,
//     quantity: 1
// });

let fs = require('fs');
let ejs = require('ejs');

var personnel= ejs.compile(fs.readFileSync("./wp-content/themes/cafe_theme/templates/personnel.ejs", "utf8"));

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
        url = './wp-content/themes/cafe_theme/Backend/personnel.php?position=' + position + '&name=' + name;
    } else if (position) {
        url = './wp-content/themes/cafe_theme/Backend/personnel.php?position=' + position;
    } else if (name) {
        url = './wp-content/themes/cafe_theme/Backend/personnel.php?name=' + name;
    } else {
        url = './wp-content/themes/cafe_theme/Backend/personnel.php';
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