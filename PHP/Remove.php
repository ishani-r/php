<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$("button").click(function(){
				$("p").removeClass("intro");
			});
		});
	</script>
	<style>
		.intro{
			font-size: 150%;
			color: green;
		}
	</style>
</head>
<body>
<p class="intro">This is intro of java script</p>
<p class="intro">Hello java script</p>
<button>Click</button>
</body>
</html>