$(function(){
    $(".dropdown-menu li a").click(function(){

        $(".dropdown-btn-val .order-header").text($(this).text());
        $(".dropdown-btn-val .order-header").val($(this).text());
    });
});