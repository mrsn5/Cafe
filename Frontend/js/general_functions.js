$(function(){

    //edit cells event
    $(document).on ("dblclick", ".editable-cell", function (e) {
        e.stopPropagation();
        var currentElem = $(this);
        update(currentElem);
    });
});

function update(currentElem) {
    var value = currentElem.find(".value");
    var input = currentElem.find(".input-data");
    value.hide();
    input.show();

    updateInput(value, input);
    input.focus();

    $(document).on("click", function (e) {
        if(!input.is(e.target) && input.has(e.target).length === 0){
            updateValue(value, input);
            value.show();
            input.hide();
        }
    });
}

function updateInput(value, input) {
    var inputElem = input.find("input");
    var type = inputElem.attr("type");
    switch (type) {
        case "checkbox":
        {
            inputElem.prop('checked', (value.text().charCodeAt(0) === 0x2713));
            break;
        }

        default: {
            input.val(value.text());
        }
    }
}

function updateValue(value, input) {
    var inputElem = input.find("input");
    var type = inputElem.attr("type");
    switch (type) {
        case "checkbox":
        {
            if(inputElem.is(':checked'))
                value.html('&#10003;');
            else
                value.html('&#10007;');
            break;
        }
        default: {
            value.text(input.val());
        }
    }
}
