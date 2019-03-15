$(function(){

    $(".dropdown-menu li a").click(function(){
        $(".dropdown-btn-val .order-header").text($(this).text());
        $(".dropdown-btn-val .order-header").val($(this).text());
    });


    $(".modal-show-btn").on('click', function () {
        var item = $(this).parents(".item");
        var modal = item.find(".show-modal");
        modal.modal();

        var input_comment =  modal.find(".comment-input-class");
        var comment_text = item.find(".comment");
        var comment = comment_text.text();
        var matches = comment.match(/\[(.*?)\]/);
        if(matches){
            comment = matches[1];
        }
        input_comment.val(comment);

        modal.find(".save-modal-btn").click(function () {
            var new_comment = input_comment.val();
            item.find(".comment").text("[" + new_comment + "]");
        })
    })

});