$(function(){
    var $inventory_table = $('#inventory_table');
    var $ingredients_table = $('#ingredients_table');

    // $inventory_table.hide();

    $('#inventory_btn').on('click', function () {
        $ingredients_table.hide();
        $inventory_table.show();
    });

    $('#all_ings').on('click', function () {
        $ingredients_table.show();
        $inventory_table.hide();
    });
});