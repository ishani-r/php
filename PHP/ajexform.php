<?php
include 'database.php';
if (isset($_POST['submit']))
{
	$name=$_POST['name'];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>AJEX example</title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style>
		body{
            background-color: pink;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
        }
		.form-control{
            padding: 7px;
            border: #bdbdbd 1px solid;
            border-radius: 10px;
            width: 700px;
        }
        .container {
            border: 1px solid #7ddaff;
            margin: 10px auto;
            padding: 40px;
            width: 900px;
            border-radius: 4px;
            background:black;
            vertical-align: center;
            margin-top:60px;
            margin-left: 299px;
            margin-right: 400px;
            padding-top: 20px;
            background: rgba(255,255,255,.5);
            box-shadow: 0 20px 20px rgba(0,0,0,.5);
    }
	</style>
	</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<label>First name:</label>
					<input type="text" name="fname" class="form-control" id="name" placeholder="Enter Your Name">
				</div>
				<div>
					<button class="btn btn-success" type="button" name="submit" id="button">submit</button>
				</div>
			</form>		
		</div>
	</div>
</div>

</body>
<script>
	$(document).ready(function(){
		$("#button").click(function(){
			var name = $('#name').val();
				$.ajax({
					url: "insertajex.php",
					type: "POST",
					data: {
					name: name,
					},
					success: function(result)
					{
						console.log(result);
						if(result=true)
						{
						alert("status is true");
						}
					}
			});
		});
	});
</script>
</html>