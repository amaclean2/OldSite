<?php include("header.inc.php"); ?>
<?php $id = $_SESSION['id']; ?>

<script>
	var app = angular.module("stock-list", []);
	app.controller("stock-controller", function($scope)
	{
		$scope.stocks = [{title: "AAPL", price: "139.52", change: 'up', chA: "0.18"},
						 {title: "GOOGL", price: "851.15", change: 'up', chA: "3.88"},
						 {title: "SNAP", price: "21.44", change: 'down', chA: "2.33"},
						 {title: "FB", price: "130.30", change: 'down', chA: "0.12"},
						 {title: "GM", price: "37.52", change: 'down', chA: "0.04"},
						 {title: "DIS", price: "110.86", change: 'up', chA: "0.19"},
						 {title: "BAC", price: "25.21", change: "down", chA: "0.04"}];
		$scope.addStock = function()
		{
			$scope.errorText = "";
			if(!$scope.addMe) {return;}
			if($scope.stocks.indexOf($scope.addMe) == -1)
				$scope.stocks.push($scope.addMe);
			else
			{
				$scope.errorText = "This stock is already in your list";
			}
		}
		$scope.removeStock = function(x)
		{
			$scope.errorText = "";
			$scope.stocks.splice(x, 1);
		}
	});
</script>


<link rel = "stylesheet" href = "invest.css">
<a class = "logo" href = "<?php if($_SESSION['id'] != '') {echo 'profile.php';} else {echo 'index.php';}?>">4mal</a>
<div >
	<div class = "invest" >
		<a href = "profile.php" class = "sign-up">Return to profile</a>
		<div class = "title">
			<h2><?php echo $_SESSION['first']; ?>'s Investments</h2>
			<a href = "" >Learn how to invest</a>
		</div>
		<div class = "inv-info">
			<div class = "left-col">
				<div class = "index"><strong>DJIA:</strong> <span class = "up"><i class="fa fa-arrow-up" aria-hidden="true"></i> 13.24</span></div>
				<div class = "index"><strong>NASDAQ:</strong> <span class = "down"><i class="fa fa-arrow-down" aria-hidden="true"></i> 1.42</span></div>
				<div class = "search">
					<input type = "text" name = "search" placeholder = "Search Stocks">
					<input type = "submit" name = "sub" value = "enter">
				</div>
				<div class = "stock-frame">
					<img src = "googleStocks.png"></img>
				</div>
			</div>
			<div class = "middle-col">
				<h3>Your stocks</h3>
				<div class = "add">
					<input type = "text" ng-model = "addMe" name = "add" placeholder = "add stocks">
					<input type = "submit" ng-click = "addStock" name = "addS" value = "Add">
				</div>
				<div class = "stock-list" ng-app = "stock-list" ng-controller = "stock-controller">
					<ul>
						<li ng-repeat = "x in stocks"><div class = "price"><b>{{ x.title }}</b>: {{ x.price }} 
							<span class = "{{ x.change }}"><i class = "fa fa-arrow-{{ x.change }}" aria-hidden = "true"></i> {{ x.chA }}</span>
							<span ng-click = "removeStock($index)" class = "close">×</span></div></li>
					</ul>
				</div>
			</div>
			<div class = "news-feed">

				<h3>News Feed</h3>
				<div class = "article">
					<h4 class = "headline">The Second Big Bird Riot</h4>
					<div class = "date">March 7th, 2017</div>
					<div class = "preview">Yesterday, a bombing happened in Times New Roman.
						Luckilly no one was killed and only minor injuries were sustained.
						Authorities are looking into perpetuators of the bombing and they believe it is linked to Big Bird.
						Several recent events have shown that the favorite children's tv-show character has gone off the deep end and is creating mass havic all over the city.
						<a href = "">read more</a>
					</div>
				</div>
				<div class = "article">
					<h4 class = "headline">The Big Bird Riot</h4>
					<div class = "date">March 6th, 2017</div>
					<div class = "preview">Yesterday, a bombing happened in Times New Roman.
						Luckilly no one was killed and only minor injuries were sustained.
						Authorities are looking into perpetuators of the bombing and they believe it is linked to Big Bird.
						Several recent events have shown that the favorite children's tv-show character has gone off the deep end and is creating mass havic all over the city.
						<a href = "">read more</a>
					</div>
				</div>
				<input type = "button" name = "feed" value = "View More Articles">
			</div>
		</div>
	</div>
</div>
<div class = "extras">
	<a href = "help">help</a>
	<a href = "privacy">privacy policy</a>
</div>
