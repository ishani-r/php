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
    	.error-msg{
    		background: #f2dedf;
    		color: #9c4150;
    		border: 1px solid #e7ced1;
    	}
    	.success-msg{
    		background: #e0efda;
    		color: #407a4a;
    		border: 1px solid #c6dfb2;
    	}
	</style>
	</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form method="POST" enctype="multipart/form-data" id="userRegister">
				<div class="form-group">
					<label>First name:</label>
					<input type="text" name="fname" class="form-control" id="name" placeholder="Enter Your First Name" required>
					<input type="hidden" name="id" id="id" value="">

				</div>
				<div class="form-group">
					<label>Last name:</label>
					<input type="text" name="lname" class="form-control" id="lname" placeholder="Enter Your Last Name" required>
				</div>
				<div>
					<button class="btn btn-success" type="button" name="submit" id="button">SUBMIT</button>  <button class="btn btn-success" type="button" name="update" id="update">UPDATE</button>
				</div>
				<div id="validate">
					
				</div>
			</form>		
		</div>
	</div>
</div>

</body>
<div>
	<table id="studentdat" border="4" align="center">
	<tr>
		<th>Id</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Delete</th>
		<th>Update</th>
	</tr>
	
	<tbody id="studentdata">
		
	</tbody>
</table>
</div>
<script>
				
	// $(document).ready(function(){
	// 	$("#button").click(function(){
	// 		$.ajax({
	// 			url: "fetch.php",
	// 			type: "POST",
	// 			dataType: "json",
	// 			success: function(response){
	// 				$.each(response, function(key, value){
	// 				$('#studentdata').append('<tr><td> ' + value.id + ' </td> <td> ' + value.name + ' </td> <td>' + value.lastname + '</td> </tr>')
	// 			});
	// 			}

	// 		});
	// 	});
	// });
	// function getdata()
	// {
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "fetch.php",
	// 		dataType: "json",
	// 		success: function(response){
	// 			// console.log(response);
	// 			$.each(response, function(key, value){
	// 				// console.log(value['lastname']);
	// 				$('.studentdata').append('<tr><td> ' + value.id + ' </td> <td> ' + value.name + ' </td> <td>' + value.lastname + '</td> </tr>')
	// 			});
	// 		}
	// 	});
	// }
	$(document).ready(function(){

		$("#button").click(function(){
			var name = $('#name').val();
			// console.log(name);
			// alert("data");
			var lastname = $('#lname').val();
			// console.log(lastname);
			if(name != "" & lastname != ""){
				$.ajax({
					url: "demoinsert.php",
					type: "POST",
					data: {
						name: name,
						last_name: lastname,
					},
					dataType:'JSON',
					success: function(result)
					{
						$('#name').val('');
						$('#lname').val('');
						console.log(result);
						if(result.status==true)
						{
							// $('#studentdata').html('');
							$html = "";

							$.each(result.users, function(key, value){
								$html += '<tr><td> ' + value.id + ' </td> <td> ' + value.name + ' </td> <td>' + value.lastname + '</td> <td><button type="button" class="delete" data-id=' + value.id + '>Delete</button></td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
							});

							$('#studentdata').html($html);

							alert("data submited successfully");
						}else{
								alert('something went wrong');
							}
					}
				});
			}else{
				alert("Please Fill Data");
			}

		});
	});
// ---------------------------------------------------
	$('#update').hide();
	$(document).on('click','.edit',function(){
		var id = $(this).attr("data-id");
		var name = $('#name').val();
		var lastname = $('#lname').val();
		// alert(id);
		$('#update').show();
		$('#button').hide();
		$.ajax({
			url: "editajex.php",
			type: "POST",
			data: {
				'id': id,
				'name': name,
				'last_name': lastname
			},
			dataType: "json",
			success: function(data){
				// console.log(data);
				$('#name').val(data.name);
				$('#lname').val(data.lastname);
				$('#id').val(data.id);
				// alert("Value: " + $("#name").val(data.name),"Value: " + $("#lname").val(data.lastname));
				// $html = "";
				// 	$.each(data.users, function(key, value){
				// 		$html += '<tr><td> ' + value.id + ' </td> <td> ' + value.name + ' </td> <td>' + value.lastname + '</td> <td><button type="button" class="delete" data-id=' + value.id + '>Delete</button></td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
				// 	});
				// 	$('#studentdata').html($html);
				// 	alert("data updated successfully");
				// 	else{
				// 			alert('something went wrong');
				// 		}
			}
		});
	});

	$(document).on('click','#update',function(){
		var name = $('#name').val();
		var id = $('#id').val();
		var lastname = $('#lname').val();
		$.ajax({
			url: "updateajex.php",
			type: "POST",
			data: {
				'id': id,
				'name': name,
				'last_name': lastname
			},
			success: function(data){
				$('#name').val('');
				$('#lname').val('');
				console.log(data);
				// if(data.update){
				// 	alert("data updated successfully");
				// }
			}
		});
	});
// ----------------------------------------------------
		$(document).on('click','.delete',function(){
			var id = $(this).attr("data-id");
			// alert(id);
			var element = this;
			if(confirm("Are You Sure To Remove This Recored")){
				$.ajax({
					url: "deletajex.php",
					type: "POST",
					data: {
						'id': id
					},
					success: function(data){
					if(data){
						
						$(element).closest("tr").remove();

					}else{
						alert("no deleted");
					}
					alert("Recored Deleted successfully");
				}
			});
			}
		});
		
// var name = $('#name').val();
// var lastname = $('#lname').val();
	$.ajax({
			type: "GET",
			url: "displayajex.php",
			// data: {
			// 	name: 'list'
			// },
			dataType: "json",
			success: function(response){
				// console.log(response); return false;
				$html = "";

				$.each(response, function(key, value){
					$html += '<tr><td> ' + value.id + ' </td> <td> ' + value.name + ' </td> <td>' + value.lastname + '</td><td><button type="button" class="delete" data-id=' + value.id + '>Delete</button></td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
				});

				$('#studentdata').html($html);
			}
		});

	// $("#button").click(function(){
	// 	var name = $("#name").val();
	// 	var lname = $("#lname").val();

	// 	if(name == "" || lname == ""){
	// 		$('#validate').fadeIn();
	// 		$('#validate').removeClass('success-msg').addClass('error-msg').html("All fields are required.");
	// 	}
	// });
	
</script>
</html>