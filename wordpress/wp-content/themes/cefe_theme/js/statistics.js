$(function(){
    var $page_label = $(".page-label");
    var $container = $(".statistics-cont");

    var $general_st = $('#general_st');
    var $orders_st = $('#orders_st');
    var $workers_st = $('#workers_st');
    var $dishes_st = $('#dishes_st');

    var $income_fin = $('#income_finance');
    var $costs_fin = $('#costs_finance');
    var $x_report = $('#x_report');

    onLoad($("#all_st_btn").text());

    $("#all_st_btn").on('click', function(){
        onLoad($(this).text());
    });

    $("#all_finance_btn").on('click', function(){
        $container.html('');
        $container.append($income_fin);
        $container.append($costs_fin);
        $container.append($x_report);
        $page_label.text($(this).text());
        $(".page-label-sm").show();
    });

    addEvent($("#general_st_btn"), $container, $general_st);
    addEvent($("#orders_st_btn"), $container, $orders_st);
    addEvent($("#workers_st_btn"), $container, $workers_st);
    addEvent($("#dishes_st_btn"), $container, $dishes_st);

    addEvent($("#income_finance_btn"), $container, $income_fin);
    addEvent($("#costs_finance_btn"), $container, $costs_fin);
    addEvent($("#x_report_btn"), $container, $x_report);

    function addEvent(btn, container, content) {
        btn.on('click', function(){
            container.html('');
            content.find(".page-label-sm").hide();
            $page_label.text($(this).text());
            container.append(content);
        });
    }

    function onLoad(label_text) {
        $container.html('');
        $container.append($general_st);
        $container.append($orders_st);
        $container.append($workers_st);
        $container.append($dishes_st);
        $page_label.text(label_text);
        $(".page-label-sm").show();
    }
});


