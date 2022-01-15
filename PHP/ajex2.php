<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script type="text/javascript">
		
		$(document).ready(function() {

			var form = $('#myfrom');
			// console.log(form);

			$('#submit').click(function(){
				
				$.ajax({
					url: "data_insert.php",
					type: "POST",
					data: $("#myfrom input").serialize(),

					success: function(data){
						console.log(data);
					}
				});
			});

		});
	</script>
</body>
</html>