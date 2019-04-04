let $ = jQuery;
// TEST2
let fs = require('fs');
let ejs = require('ejs');

var personnel = ejs.compile(fs.readFileSync("./templates/personnel.ejs", "utf8"));

$(function () {
    var $personnel_table = $("#personnel-table");

    get_personnel(null, null);
    addChangeLiesteners();

    $("#search-button").click(function () {
        var search_name = $("#search_pib").val().trim();
        var search_position = $("#position").val();
        get_personnel(search_position, search_name);
    });

    function get_personnel(position, name) {
        $personnel_table.html("");
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'personnel_select',
                position: position,
                name: name
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                res.forEach(function (p) {
                    var $node = $(personnel(p));
                    $personnel_table.append($node);
                });
            }
        });
    }

    $("#save-personnel").click(function () {
        let tels = [];
        $('#tels_list').find('.tel-opt').each(function () {
            tels.push($(this).val());
        });
        console.log(tels);

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'personnel_add',
                tab_num: $("#tab_num").val(),
                position: $("#position-add").val(),
                first_name: $("#first_name").val(),
                surname: $("#surname").val(),
                father_name: $("#father_name").val() == '' ? 'NULL' : $("#father_name").val(),
                birth_date: $("#birth_date").val(),
                gender: $("#is_male:checked").val() || $("#is_female:checked").val(),
                address: $("#address").val(),
                telephones: tels,
                salary: $("#salary-add").val(),
                // tel_num: $("#tel_num").val()
            },
            success: function (res) {
                get_personnel(null, null);
                console.log(res);

                $("#tab_num").val('');
                $("#first_name").val('');
                $("#surname").val('');
                $("#father_name").val('');
                $("#birth_date").val(null);
                $("#address").val('');
                $("#salary-add").val('');

                $('#tels_list').html('');
                $("#tel_num").val('');

                $('#add_area_btn').click();
            }
        });
    });

    $("#all_personnel").click(function () {
        get_personnel(null, null);
    });

    $("#add_tel").on('click', function () {
       let tel = $("#tel_num").val();
        $("#tels_list").append('<option class="tel-opt">'+tel+'</option>');
        $("#tel_num").val('');
    });

    $personnel_table.on('click', ".modal-show-btn", function () {
        let worker = $(this).parents(".worker-row");
        let modal = $(".show-modal");
        modal.modal();

        let modal_title = $('.tels-modal-title');
        let tels_cont = $('.tels-cont');
        tels_cont.html('');

        modal_title.text(worker.find('.first-name').text() + " " + worker.find('.surname').text() + " " + worker.find('.father-name').text());

        worker.find('.telephones-cell').find('.tel').each(function () {
            appendToTelsList(tels_cont, $(this).text());
        });
    });

    $('#add_tell_modal').on('click', function () {
       let new_tel = $("#input_tell").val();
       let tels_cont = $('.tels-cont');
       if(new_tel != ''){
           appendToTelsList(tels_cont, new_tel);
       }
        $("#input_tell").val('');
    });

    $('.modal').on('click', '.remove-tel', function () {
        $(this).parents('.tel-row').remove();
    });

    function appendToTelsList(tels_cont, tel) {
        tels_cont.append('<div class="tel-row">\n' +
            '                            <div style="display: inline-block" class="editable-cell">\n' +
            '                                <span class="value">'+ tel.trim() +'</span>\n' +
            '                                <label class="input-data input-style">\n' +
            '                                    <input type="tel" class="input tel-input">\n' +
            '                                </label>\n' +
            '                            </div>\n' +
            '                            <span  class="glyphicon glyphicon-remove remove-tel"></span>\n' +
            '                        </div>');
    }

    // get_personnel(null, null);
    function addChangeLiesteners() {

        $personnel_table.on('change', '.name-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let first_name = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    first_name: first_name
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.surname-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let surname = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    surname: surname
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.fathername-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let father_name = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    father_name: father_name
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.birthdate-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let birth_date = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    birth_date: birth_date
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.address-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let address = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    address: address
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.gender-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let gender = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    gender: gender
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.position-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let position = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    position: position
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.salary-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let salary = $(this).val();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    salary: salary
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });

        $personnel_table.on('change', '.tel-input', function () {
            let $parent = ($(this).parents('tr'));
            let tab_num = $parent.find(".tab_num").text();
            let tel_num = $(this).val().trim();

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'personnel_change',
                    tab_num: tab_num,
                    tel_num: tel_num
                },
                success: function (e) {
                    console.log(e);
                }
            });
        });
    }
});