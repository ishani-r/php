<!-- <?php
include 'database.php';
if (isset($_POST['submit']))
{
$fname=$_POST['fname'];
$lname=$_POST['lname'];
}
?> -->
<!DOCTYPE html>
<html>
<head>
	<title>AJEX example</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
				<form id="myfrom" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="fname" id="fname" placeholder="Enter First Name" class="form-control">
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="lname" id="lname" placeholder="Enter Last Name" class="form-control">
					</div>
					<div>
						<input type="submit" name="submit" value="Submit" id="submit">
					</div>
				</form>
			</div>	
		</div>
	</div>
</body>
<script>
		$(document).ready(function() {
			$('#submit').click(function() {
				
				var firstname = $('#fname').val();
				console.log(fname);
				var lastname = $('#lname').val();
				console.log(lname);
				
					$.ajax({
						url: "datainsert.php",
						type: "POST",
						data: {
							'firstname': firstname,
							'lastname': lastname				
						},
						// cache: false,
						success: function(data){
							console.log(data);
							if(result=true){
							alert("status is true");
							}						
						}
				});		
			});
		});
</script>
</html>