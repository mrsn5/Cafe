var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

let dishTempl = ejs.compile(fs.readFileSync("./templates/dish.ejs", "utf8"));

$(function(){
    let $dishes_container = $("#dishes_container");
    let $cat_name_label = $("#category_name");
    let cat_name = localStorage.getItem('cat_name');

    $cat_name_label.text(cat_name);

    getDishes();

    function getDishes() {
        $dishes_container.html('');

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'cat_select',
                cat_name:cat_name
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);

                // let cat_name = res.cat_name;
                // let dishes = res.dishes;

                console.log(url_object.template_directory);

                res.forEach(function (d) {
                    var $node = $(dishTempl({
                        dish: d,
                        url_object: url_object
                    }));
                    $dishes_container.append($node);
                });
            }
        });
    }
});