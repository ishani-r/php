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
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
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
    	 .error {
            color: red;
        }
        .errorMsg {
            border: 1px solid red;
        }
        .is-invalid {
            border: red 3px solid !important;
        }
	</style>
	</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form method="POST" enctype="multipart/form-data" id="frm_user_register" >
				<div class="form-group">
					<label>First name:</label>
					<input type="text" name="fname" class="form-control" id="name" placeholder="Enter Your First Name">
					<span id="fname_error" class="text-danger"></span>
					<input type="hidden" name="id" id="id" value="">
				</div>
				<div class="form-group">
					<label>Last name:</label>
					<input type="text" name="lname" class="form-control" id="lname" placeholder="Enter Your Last Name">
					<span id="lname_error" class="text-danger"></span>
				</div>
				<input type="hidden" name="action" value="insert" id="action">
			<!-- 	<input type="submit" name="action" value="submit"> -->
				<div>
					<button class="btn btn-success" type="submit" id="form_submit">SUBMIT</button>  
					<button class="btn btn-success" type="submit" name="update" id="update">UPDATE</button>
				</div>
				<div>
					
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
	 $('#frm_user_register').validate({
                // rules: {
                //     name: {
                //         required: true,
                //     },
                //     lname: {
                //         required: true,
                //     }
                // },
                //     messages: {
	               //      name: 'Please enter First Name.',
	               //      lname: 'Please enter last Name.',
                //     },
                //     highlight: function(element, errorClass, validClass) {
                //     $(element).addClass("is-invalid").removeClass("is-valid");
	               //  },
	               //  unhighlight: function(element, errorClass, validClass) {
	               //      $(element).addClass("is-valid").removeClass("is-invalid");
	               //  },
	                submitHandler:  function(form){
            		console.log($(form).serialize());
			// e.preventDefault();
			// console.log($(this).serialize());
			$.ajax({
				url:'singleFileServer1.php',
				type:'POST',
				dataType:'JSON',
				data:$(form).serialize(),
				// beforeSend:function() {
				// },
				success:function(data){
					console.log(data);
					$.each(data.error, function(index, value){
                        console.log(index);
                        $('#' + index + "_error").html(value);
                        console.log(value);
                    });
					if(data){
					getdata();
					alert("Data Submited successfully");
					$("#frm_user_register").trigger('reset');
				}
				},
				// complete: function(){

				// },
				// error:function(){

				// }
			});
		}
 });
	$(document).ready(function(){
	getdata();
		// Add  New Student From Submmition
		//  submitHandler:  function(form){
  //           console.log($(form).serialize()); return false;
            
		// 	// e.preventDefault();
		// 	// console.log($(this).serialize());
		// 	$.ajax({
		// 		url:'singleFileServer.php',
		// 		type:'POST',
		// 		dataType:'json',
		// 		data:$(this).serialize(),
		// 		beforeSend:function() {

		// 		},
		// 		success:function(data){
		// 			console.log(data)
		// 			getdata()
		// 		},
		// 		complete: function(){

		// 		},
		// 		error:function(){

		// 		}
		// 	});
		// }
		});

	function getdata(){
	$.ajax({
			type: "POST",
			url: "singleFileServer1.php",
			data: {
				action: 'list'
			},
			dataType: 'JSON',
			success: function(response){
				// console.log(response); return false;
				$html = "";

				$.each(response, function(key, value){
					$html += '<tr><td> ' + value.id + ' </td> <td> ' + value.firstname + ' </td> <td>' + value.lastname + '</td><td><button type="button" class="delete" data-id=' + value.id + '>Delete</button></td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
				});

				$('#studentdata').html($html);
			}
		});
}

$(document).on('click','#update',function(){
	$('#update').hide();
	$('#form_submit').show();
	// e.preventDefault();
	console.log('assaaaaaaaa');
		// var name = $('#name').val();
		// var id = $('#id').val();
		// var lastname = $('#lname').val();
		$.ajax({
			url: "singleFileServer1.php",
			type: "POST",
			data: $('#frm_user_register').serialize(),
			dataType: 'JSON',
			success: function(data){
				// console.log(data);
				$.each(data.error, function(index, value){
                        console.log(index);
                        $('#' + index + "_error").html(value);
                        console.log(value);
                });
				if(data){
					getdata();
					alert("data updated successfully");
				}
			}
		});
});

$("#update").hide();
$(document).on('click','.edit',function(){
	$('#form_submit').hide();
	// console.log('assa');
	var id = $(this).attr("data-id");
		var name = $('#name').val();
		var lastname = $('#lname').val();
		// alert(id);
		$('#update').show();
		
		$.ajax({
			url: "singleFileServer1.php",
			type: "POST",
			data: {
				'id': id,
				'name': name,
				'last_name': lastname,
				'action': 'edit'
			},
			dataType: "json",
			success: function(data){
				console.log(data);
				$('#name').val(data.users.firstname);
				$('#lname').val(data.users.lastname);
				$('#id').val(data.users.id);
				$('#action').val('update');
			}
		});
});


$(document).on('click','.delete',function(){
	// console.log('assa');
	var id = $(this).attr("data-id");
	var element = this;
	if(confirm("Are You Sure To Remove This Recored")){
		$.ajax({
			url: "singleFileServer1.php",
			type: "POST",
			data: {
				'id': id,
				'action': 'delete'
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

</script>
</html>