$(function()
{
	var data =
	{
		labels: [1, 2, 3, 4, 5, 6, 7],
		datasets: [
			{
				label: "The First Dataset",
				fillColor: "rgba(153, 0, 76, 0.2)",
				strokeColor: "rgb(153, 0, 76, 1)",
				pointColor: "rgb(153, 0, 76, 1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(153, 0, 76, 1)",
				data: [100, 34, 21, 56, 23, 90, 40]
			},

			{
				label: "The Second Dataset",
				fillColor: "rgba(76, 0, 153, 0.2)",
				strokeColor: "rgb(76, 0, 153, 1)",
				pointColor: "rgb(76, 0, 153, 1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(76, 0, 153, 1)",
				data: [25, 48, 52, 91, 28, 34, 67]
			}
			]
	};
	var option = {};

	var ctx = document.getElementById("canv").getContext('2d');
	var myLineChart = new Chart(ctx).Line(data, option);
	
});