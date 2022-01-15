<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>
		$(document).ready(function(){
			$("#flip").click(function(){
				$("#panel").slideDown(5000);
			});
			$("#stop").click(function(){
				$("#panel").stop();
			});
		});
	</script>
	<style>
		#panel, #flip{
			padding: 5px;
			font-size: 20px;
			text-align: center;
			background-color: pink;
			color: black;
			border: solid 1px #666;
			border-radius: 3px;
		}
		#panel{
			padding: 100px;
			display: none;
		}
	</style>
</head>
<body>

<button id="stop">Stop Sliding</button>

<div id="flip">Click to slide down panel</div>
<div id="panel">Hello JQuery</div>
</body>
</html>