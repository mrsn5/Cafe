$(function(){
    var $orders = $(".orders-container");
    var $discarding = $(".discarding-container");

    var $orders_search = $(".search-cont-orders");
    var $discarding_search = $(".search-cont-discarding");

    var $container = $(".inf-details-block");
    var $container_search = $(".search-area");

    onLoad();

    $("#orders_btn").on('click', function(){
        onLoad();
    });

    $("#discarding_btn").on('click', function(){
        $container.html('');
        $container_search.html('');
        $container.append($discarding);
        $container_search.append($discarding_search);
    });

    function onLoad() {
        $container.html('');
        $container_search.html('');
        $container.append($orders);
        $container_search.append($orders_search);
    }
});