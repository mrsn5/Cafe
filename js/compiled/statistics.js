(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
dataOrders = [{"label":"Петро Петренко Петрович", "value":120},
    {"label":"Іван Іваненко Іванович", "value":60},
    {"label":"Денис Денисенко Денисович", "value":30},
    {"label":"Денис Денисенко Денисович", "value":30}];

dataIncome = [{"label":"Петро Петренко Петрович", "value":4321},
    {"label":"Іван Іваненко Іванович", "value":1342},
    {"label":"Денис Денисенко Денисович", "value":645},
    {"label":"Денис Денисенко Денисович", "value":532}];

dataDishes = [{"label":"Борщ", "value":70},
    {"label":"Салат Цезар", "value":12},
    {"label":"Сніданок", "value":10},
    {"label":"Котлета по-київськи", "value":5}];

var color = d3.scale.category20b();
function createPie(id, data){
    if(data.length === 0){
        data.push({"pib":"empty","worker_res":1});
    }

    var w = 300,
        h = 300,
        r = 150;

    //configure svg file
    var vis = d3.select(id)
        .append("svg:svg")
        .data([data])
        .attr("width", w)
        .attr("height", h)
        .append("svg:g")
        .attr("transform", "translate(" + r + "," + r + ")");

    var arc = d3.svg.arc()
        .outerRadius(r);

    var pie = d3.layout.pie()
        .value(function(d) { return d.worker_res; });

    var arcs = vis.selectAll("g.slice")
        .data(pie)
        .enter()
        .append("svg:g")
        .attr("class", "slice");

    arcs.append("svg:path")
       .attr("fill", function(d, i) { return color(i); } )
        .attr("d", arc);

    arcs.append("svg:text")
        .attr("transform", function(d) {
            //we have to make sure to set these before calling arc.centroid
            d.innerRadius = 0;
            d.outerRadius = r;
            return "translate(" + arc.centroid(d) + ")";
        })
        .attr("text-anchor", "middle")
        .text(function(d, i) { return data[i].worker_res; });

    d3.selectAll(id + " text").style("fill", "white");
}

function legend(id, lD){
    var leg = {};

    // create table for legend.
    var legend = d3.select(id).append("table").attr('class','legend');

    // create one row per segment.
    var tr = legend.append("tbody").selectAll("tr").data(lD).enter().append("tr");

    // create the first column for each segment.
    tr.append("td").append("svg").attr("width", '16').attr("height", '16').append("rect")
        .attr("width", '16').attr("height", '16')
        .attr("fill",function(d, i) { return color(i); });

    // create the second column for each segment.
    tr.append("td").text(function(d){ return d.pib;});

    // create the third column for each segment.
    tr.append("td").attr("class",'legendFreq')
        .text(function(d){ return d.worker_res;});

    return leg;
}

function createBarChart(id, data){
    var margin = {
        top: 15,
        right: 25,
        bottom: 15,
        left: 155
    };

    var chartDiv = document.getElementById("dishes_orders_diagram");
    var width = chartDiv.clientWidth - margin.left - margin.right;
    var aspect = width / height;
    var height = data.length*30;

    var max = d3.max(data, function (d) {
        return d.dish_res;
    });

    var x = d3.scale.linear()
        .range([0, width])
        .domain([0, max]);

    var y = d3.scale.ordinal()
        .rangeRoundBands([height, 0], .1)
        .domain(data.map(function (d) {
            return d.dish_name;
        }));

    var yAxis = d3.svg.axis()
        .scale(y)
        //no tick marks
        .tickSize(0)
        .orient("left");

    var svg = d3.select(id).append("svg")
        .attr("width", "100%")
        .attr("height", height)
        // .attr("preserveAspectRatio", "xMinYMin meet")
    //         // .attr("viewBox", "0 0 960 400")
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + 0 + ")");

    var gy = svg.append("g")
        .attr("class", "y axis")
        .call(yAxis)
        .append("text")
        .attr("transform", "translate(0," + (width) + ")");

    var bars = svg.selectAll(".bar")
        .data(data)
        .enter()
        .append("g")


    bars.append("rect")
        .style("fill", function(d, i) { return color(i); })
        .attr("class", "bar")
        .attr("y", function (d) {
            return y(d.dish_name);
        })
        .attr("height", y.rangeBand())
        .attr("x", 0)
        .attr("width", function (d) {
            return x(d.dish_res);
        });

    bars.append("text")
        .attr("class", "label")
        //y position of the label is halfway down the bar
        .attr("y", function (d) {
            return y(d.dish_name) + y.rangeBand() / 2 + 4;
        })
        //x position is 3 pixels to the right of the bar
        .attr("x", function (d) {
            return x(d.dish_res) + 3;
        })
        .text(function (d) {
            return d.dish_res;
        });

    bars.selectAll("text").
        attr("font-size", "16px");

}

// legend("#worker_orders_legend", []);
//
// createPie("#worker_income_diagram", []);
// legend("#worker_income_legend", []);

// createBarChart("#dishes_orders_diagram", dataDishes);


exports.createPie = createPie;
exports.legend = legend;
exports.createBarChart = createBarChart;
},{}],2:[function(require,module,exports){
let Diagrams = require("./graphics");


Date.prototype.yyyymmdd = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    return [this.getFullYear(),
        (mm>9 ? '' : '0') + mm,
        (dd>9 ? '' : '0') + dd
    ].join('-');
};



jQuery(function(){
    let $ = jQuery;

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

    var now = new Date().yyyymmdd();
    $('input[type="date"]').val(now);

    $("#first_n_workers_orders").val(3);
    $("#first_n_workers_income").val(3);
    $("#dish_frequency_orders_amount").val(10);
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
        getXReport();
        $('input[type="date"]').val(now);
    });

    addEvent($("#general_st_btn"), $container, $general_st);
    addEvent($("#orders_st_btn"), $container, $orders_st);
    addEvent($("#workers_st_btn"), $container, $workers_st);
    addEvent($("#dishes_st_btn"), $container, $dishes_st);

    addEvent($("#income_finance_btn"), $container, $income_fin);
    addEvent($("#costs_finance_btn"), $container, $costs_fin);
    // addEvent($("#x_report_btn"), $container, $x_report, getXReport());


    $("#x_report_btn").on('click', function(){
        $container.html('');
        $x_report.find(".page-label-sm").hide();
        $page_label.text($(this).text());
        $container.append($x_report);
        getXReport();
    });

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
        $(".page-label-sm").show()

        $("#worker_orders_diagram").html('');
        $("#worker_income_diagram").html('');
        Diagrams.createPie("#worker_orders_diagram", []);
        Diagrams.createPie("#worker_income_diagram", []);

        getAllCategories();
    }

    function getAllCategories(){
        let $cat_list = $('.select-category');
        $cat_list.innerHTML = '';

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'categories_select',
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                res.forEach(function (el) {
                    $cat_list.append("<option>" + el['cat_name'] + "</option>");
                });
            }
        });
    }


    //AJAX QUERIES
    $container.on('click', "#av_time_btn", function (e) {
        e.preventDefault();

        let $av_client_time = $('#average_client_time');

        let $date_from = $('#date_from_av_time').val();
        let $date_to = $('#date_to_av_time').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'average_client_time',
                date_from: $date_from,
                date_to: $date_to
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                $av_client_time.text(res['avg_time']);
            }
        });
    });

    $container.on('click', "#orders_amount_btn", function (e) {
        e.preventDefault();

        let $orders_amount = $('#orders_amount');

        let $date_from = $('#orders_amount_from').val();
        let $date_to = $('#orders_amount_to').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'orders_amount',
                date_from: $date_from,
                date_to: $date_to
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                $orders_amount.text(res['orders_amount']);
            }
        });
    });


    $container.on('click', "#av_order_cost_btn", function (e) {
        e.preventDefault();

        let $orders_cost = $('#av_order_cost');

        let $date_from = $('#av_order_cost_from').val();
        let $date_to = $('#av_order_cost_to').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'average_orders_cost',
                date_from: $date_from,
                date_to: $date_to
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                $orders_cost.text(res['avg_cost']);
            }
        });
    });

    $container.on('click', "#av_cost_per_person_btn", function (e) {
        e.preventDefault();

        let $av_cost_per_person = $('#av_cost_per_person');

        let $date_from = $('#av_cost_per_person_from').val();
        let $date_to = $('#av_cost_per_person_to').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'average_orders_cost_per_person',
                date_from: $date_from,
                date_to: $date_to
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                $av_cost_per_person.text(res['avg_cost_per_person']);
            }
        });
    });

    $container.on('click', "#workers_orders_btn", function (e) {
        e.preventDefault();

        let $workers_orders_diagram = $('#worker_orders_diagram');
        $workers_orders_diagram.html('');

        let $workers_orders_legend = $('#worker_orders_legend');
        $workers_orders_legend.html('');

        let $date_from = $('#workers_orders_from').val();
        let $date_to = $('#workers_orders_to').val();
        let $first_n = $('#first_n_workers_orders').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'best_workers_orders_amount',
                date_from: $date_from,
                date_to: $date_to,
                first: $first_n
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);

                Diagrams.createPie('#worker_orders_diagram', res);
                Diagrams.legend('#worker_orders_legend', res);
                // $av_cost_per_person.text(res['avg_cost_per_person']);
            }
        });
    });


    $container.on('click', "#worker_income_btn", function (e) {
        e.preventDefault();

        let $workers_orders_diagram = $('#worker_income_diagram');
        $workers_orders_diagram.html('');

        let $workers_orders_legend = $('#worker_income_legend');
        $workers_orders_legend.html('');

        let $date_from = $('#worker_income_from').val();
        let $date_to = $('#worker_income_to').val();
        let $first_n = $('#first_n_workers_income').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'best_workers_income',
                date_from: $date_from,
                date_to: $date_to,
                first: $first_n
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);

                Diagrams.createPie('#worker_income_diagram', res);
                Diagrams.legend('#worker_income_legend', res);
                // $av_cost_per_person.text(res['avg_cost_per_person']);
            }
        });
    });

    $container.on('click', "#category_portions_btn", function (e) {
        e.preventDefault();

        let $category_portions = $('#category_portions');

        let $category_name = $('#category_portions_category_list').val();
        console.log($category_name);

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'category_portions_amount',
                cat_name: $category_name
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);

                $category_portions.text(res['n_portions']);
            }
        });
    });

    $container.on('click', "#category_portions_btn", function (e) {
        e.preventDefault();

        let $category_portions = $('#category_portions');

        let $category_name = $('#category_portions_category_list').val();
        console.log($category_name);

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'category_portions_amount',
                cat_name: $category_name
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);

                $category_portions.text(res['quantity']);
            }
        });
    });

    $container.on('click', "#dish_portions_btn", function (e) {
        e.preventDefault();

        let $dish_portions = $('#dish_portions');
        let $dish_name = $("#dish_portion_name").val().trim();
        // let $category_name = $('#dish_portions_category_list').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'dish_portions_amount',
                dish_name: $dish_name
                // cat_name: $category_name
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);

                $dish_portions.text(res['quantity']);
            }
        });
    });


    $container.on('click', "#dish_frequency_btn", function (e) {
        e.preventDefault();

        let $dish_diagram = $('#dishes_orders_diagram');
        $dish_diagram.html('');

        let $date_from = $('#dish_frequency_from').val();
        let $date_to = $('#dish_frequency_to').val();
        let $less = ($('#dish_frequency_less_more_option').val() == 'менше');
        let $n_orders = $('#dish_frequency_orders_amount').val();

        console.log($less);
        // let $category_name = $('#dish_portions_category_list').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'dish_frequency',
                date_from:$date_from,
                date_to:$date_to,
                less: $less,
                n_orders: $n_orders
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                Diagrams.createBarChart('#dishes_orders_diagram', res);
            }
        });
    });


    $container.on('click', "#orders_income_btn", function (e) {
        e.preventDefault();

        let $orders_income_table = $('#orders_income_table');
        $orders_income_table.html('');

        let $date_from = $('#orders_income_from').val();
        let $date_to = $('#orders_income_to').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'orders_income',
                date_from:$date_from,
                date_to:$date_to,
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);

                let total = (res.splice(-1,1))[0];

                res.forEach(function (r) {
                    $orders_income_table.append("<tr>\n" +
                        "                           <td>" + r['unique_num'] + "</td>\n" +
                        "                           <td>" + r['close_time'] + "</td>\n" +
                        "                           <td>" + r['pib'] + "</td>\n" +
                        "                           <td>" + r['cost'] + "</td>\n" +
                        "                        </tr>")
                })

                $("#orders_income_total").text(total['total']);
            }
        });
    });


    $container.on('click', "#deliveries_cost_btn", function (e) {
        e.preventDefault();

        let $deliveries_cost_table = $('#deliveries_cost_table');
        $deliveries_cost_table.html('');

        let $date_from = $('#deliveries_cost_from').val();
        let $date_to = $('#deliveries_cost_to').val();

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'deliveries_cost',
                date_from: $date_from,
                date_to: $date_to
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);

                let total = (res.splice(-1,1))[0];

                res.forEach(function (r) {
                    $deliveries_cost_table.append("<tr>\n" +
                        "                            <td>" + r['delivery_num'] +"</td>\n" +
                        "                            <td>" + r['pay_date'] + "</td>\n" +
                        "                            <td>" + r['receiving_date'] + "</td>\n" +
                        "                            <td>" + r['company_name'] + "</td>\n" +
                        "                            <td>" + r['cost'] + "</td>\n" +
                        "                        </tr>")
                });

                $("#deliveries_cost_total").text(total['total']);
            }
        });
    });


    function getXReport() {
        let $x_report_table = $('#x_report_table');
        $x_report_table.html('');

        $.ajax({
            url: url_object.ajax_url,
            type: 'POST',
            data: {
                action: 'x_report'
            },
            success: function (res) {
                console.log(res);
                res = JSON.parse(res);
                let total = (res.splice(-1,1))[0];
                res.forEach(function (r) {
                    $x_report_table.append("<tr>\n" +
                        "                           <td>" + r['unique_num'] + "</td>\n" +
                        "                           <td>" + r['close_time'] + "</td>\n" +
                        "                           <td>" + r['pib'] + "</td>\n" +
                        "                           <td>" + r['cost'] + "</td>\n" +
                        "                        </tr>")
                });

                $("#x_report_total").text(total['total']);
            }
        });
    }
});



},{"./graphics":1}]},{},[2]);
