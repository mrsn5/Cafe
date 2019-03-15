var $ = jQuery;

let fs = require('fs');
let ejs = require('ejs');

var personnel = ejs.compile(fs.readFileSync("./templates/personnel.ejs", "utf8"));

$(function () {
    var $personnel_table = $("#personnel-table");

    get_personnel(null, null);

    $("#search-button").click(function () {
        var search_name = $("#search_pib").val().trim();
        var search_position = $("#position").val();
        get_personnel(search_position, search_name);
    });

    function get_personnel(position, name) {
        console.log(ajax_object);
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
                res = JSON.parse(res);
                res.forEach(function (p) {
                    var $node = $(personnel(p));
                    $node.find('.name-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                first_name: $node.find('.name-input').val()
                            }
                        });
                    });
                    $node.find('.surname-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                surname: $node.find('.surname-input').val()
                            }
                        });
                    });
                    $node.find('.fathername-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                father_name: $node.find('.fathername-input').val()
                            },
                            success: function (e) {
                                console.log(e);
                            }
                        });
                    });
                    $node.find('.birthdate-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                birth_date: $node.find('.birthdate-input').val()
                            },
                            success: function (e) {
                                console.log(e);
                            }
                        });
                    });
                    $node.find('.address-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                address: $node.find('.address-input').val()
                            },
                            success: function (e) {
                                console.log(e);
                            }
                        });
                    });
                    $node.find('.gender-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                gender: $node.find('.gender-input').val()
                            },
                            success: function (e) {
                                console.log(e);
                            }
                        });
                    });
                    $node.find('.position-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                position: $node.find('.position-input').val()
                            },
                            success: function (e) {
                                console.log(e);
                            }
                        });
                    });
                    $node.find('.salary-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                salary: $node.find('.salary-input').val()
                            },
                            success: function (e) {
                                console.log(e);
                            }
                        });
                    });
                    $node.find('.tel-input').on('change', function () {
                        $.ajax({
                            url: ajax_object.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'personnel_change',
                                tab_num: $node.find('.tab_num').text(),
                                tel_num: $node.find('.tel-input').val()
                            },
                            success: function (e) {
                                console.log(e);
                            }
                        });
                    });

                    $personnel_table.append($node);
                });
            }
        });
    }

    $("#save-personnel").click(function () {
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
                telephone: $("#tel_num").val(),
                salary: $("#salary-add").val()
            },
            success: function (res) {
                console.log(res);
            }
        });
    });

    $("#all_personnel").click(function () {
        get_personnel(null, null);
    });
});