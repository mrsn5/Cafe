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
        .value(function(d) { return d.value; });

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
        .text(function(d, i) { return data[i].value; });

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
    tr.append("td").text(function(d){ return d.label;});

    // create the third column for each segment.
    tr.append("td").attr("class",'legendFreq')
        .text(function(d){ return d.value;});

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
        return d.value;
    });

    var x = d3.scale.linear()
        .range([0, width])
        .domain([0, max]);

    var y = d3.scale.ordinal()
        .rangeRoundBands([height, 0], .1)
        .domain(data.map(function (d) {
            return d.label;
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
            return y(d.label);
        })
        .attr("height", y.rangeBand())
        .attr("x", 0)
        .attr("width", function (d) {
            return x(d.value);
        });

    bars.append("text")
        .attr("class", "label")
        //y position of the label is halfway down the bar
        .attr("y", function (d) {
            return y(d.label) + y.rangeBand() / 2 + 4;
        })
        //x position is 3 pixels to the right of the bar
        .attr("x", function (d) {
            return x(d.value) + 3;
        })
        .text(function (d) {
            return d.value;
        });

    bars.selectAll("text").
        attr("font-size", "16px");

}

createPie("#worker_orders_diagram", dataOrders);
legend("#worker_orders_legend", dataOrders);

createPie("#worker_income_diagram", dataIncome);
legend("#worker_income_legend", dataIncome);

createBarChart("#dishes_orders_diagram", dataDishes);
        