<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

<div ng-app = "myApp" ng-init = "show = true">
<button ng-click = "show = !show">Things...</button>
<p ng-show = "show" id = "wowza">This is something that will disappear</p>
</div>

<script>
var app = angular.module("myApp", []);
</script>