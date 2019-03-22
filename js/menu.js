var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

var category = ejs.compile(fs.readFileSync("./templates/category.ejs", "utf8"));


$(function () {
    var $categories_container = $("#categories_container");

    getCategories();

    $("body").on('click', ".category-name", function () {
       let cat_name = $(this).text().trim();
       localStorage.setItem('cat_name', cat_name);

       window.location.href = url_object.category_page_url;
    });

    function getCategories() {
        $categories_container.html("");
        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'categories_select',
            },
            success: function (res) {
                res = JSON.parse(res);
                console.log(res);
                res.forEach(function (cat) {
                    var $node = $(category(cat));
                    $categories_container.append($node);
                });
            }
        });
    }
});