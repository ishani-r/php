<!DOCTYPE html>
<html>
<head>
	<title>JQuery</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$("p").click(function(){
			$(this).css({"font-style": "italic", "font-weight": "bold","text-decoration": "underline"});
		});
	});
</script>
</head>
<body>
	<p>Move the mouse pointer on the text to make text bold, italic and underline.</p>
</body>
</html>