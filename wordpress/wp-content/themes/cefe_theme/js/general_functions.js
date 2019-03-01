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

    var inputElem = input.find(".input");
    var type = inputElem.attr("type");
    updateInput(value, inputElem, type);
    input.focus();

    $(document).on("click", function (e) {
        if(!input.is(e.target) && input.has(e.target).length === 0){
            updateValue(value, inputElem, type);
            value.show();
            input.hide();
        }
    });
}

function updateInput(value, inputElem, type) {
    switch (type) {
        case "checkbox":
        {
            inputElem.prop('checked', (value.text().charCodeAt(0) === 0x2713));
            break;
        }
        case "number":
        {
            inputElem.val(parseInt(value.text(), 10));
            break;
        }
        default: {
            inputElem.val(value.text());
        }
    }
}

function updateValue(value, inputElem, type) {
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
            var newVal = inputElem.val();
            if(newVal !== null )
                value.text(inputElem.val());
        }
    }
}
