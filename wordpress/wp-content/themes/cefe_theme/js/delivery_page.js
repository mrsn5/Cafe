$(document).ready(function(){

    $('#add_area_btn').on('click', function(event) {
        toggleEvent($('.new-delivery-area'));
        rotateImage($(".img-cont"));
    });

    $(".show-products").on("click", function (event) {
        toggleEvent(($(this).parent().next("tr").find(".delivery-products")));
        rotateImage(($(this).find("img")));
    });
});

function toggleEvent(toggleElement) {
    toggleElement.slideToggle();
}

function rotateImage($imageEl) {
    var roratedClass = $imageEl.hasClass("rotated") || "fail";
    if(roratedClass === "fail"){
        $imageEl.css({
            "transform": "rotate(-180deg)"
        });
        $imageEl.addClass("rotated");
    } else {
        $imageEl.css({
            "transform": "rotate(0deg)"
        });
        $imageEl.removeClass("rotated");
    }
}
