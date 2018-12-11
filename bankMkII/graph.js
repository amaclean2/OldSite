

addData();

var sum;

for(var i = 0; i < accounts.length; i++)
{
	sum = 0;
	for(var j = 0; j < accounts[i].length; j++)
	{
		sum++;
		console.log(accounts[i][j]);
	}
}

var ndx = crossfilter(accounts[0]);
var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;
var screenX = window.innerWidth;
var screenY = window.innerHeight;
var graphWidth = screenX * .99;
var size = accounts[0].length - 1;

accounts[0].forEach(function(d)
{
	d.date = parseDate(d.date);
	d.Year = d.date.getFullYear();
});

var xvar = ndx.dimension(function(d) {return d.date;}),
	yvar = xvar.group().reduceSum(function(d) {return d.y}),
	zvar = xvar.group().reduceSum(function(d) {return d.y}),
	ringDims = ndx.dimension(function(d) {return d.Hun}),
	ring_total = ringDims.group().reduceSum(function(d) {return d.y;});

var chart2 = dc.barChart("#bar-chart"),
	chart = dc.lineChart("#chart");

var minDate = xvar.bottom(1)[0].date,
	maxDate = xvar.top(1)[0].date;

chart
	.width(graphWidth).height(screenY * .8)
	.x(d3.time.scale().domain([minDate, maxDate]))
	.renderHorizontalGridLines(true)
	.renderArea(true)
	.rangeChart(chart2)
	.transitionDuration(1000)
	.dimension(xvar)
	.elasticY(true)
	.group(yvar, "Checking Account: 0011001")
	.margins({right:20, left: 60, top: 10, bottom: 20})
	.brushOn(false);

//for(var i = 2; i < 5; i++)
//{
	//chart.stack(zvar, " Account " + i + ": $" +accounts[0][size].y);
//};

//chart.legend(dc.legend()
//	.x(screenX - 250)
//	.y(screenY - 275 - (i * 20))
//	.itemHeight(20).gap(5));

chart.ordinalColors(['#334b68', '#fc4145', '#44f0f9', '#1d6718', '#f8b045', '#333', '#651b1b']);

chart2
	.width(graphWidth * .96).height(60)
	.x(d3.time.scale().domain([minDate, maxDate]))
	.dimension(xvar)
	.group(yvar)
	//.stack(zvar)
	.centerBar(true)
	.gap(0)
	.margins({left: -2, right: 0, top: 0, bottom: 5});


dc.renderAll();