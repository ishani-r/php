<!DOCTYPE html>
<html>
	<head>
		<title>AJEX example</title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
	        .ajax-loader{
			   position: fixed;
			   z-index: 11;
			   width: 100%;
			   height: 100%;
			   display: flex;
			   align-items: center;
			   justify-content: center;
			   background-color: rgba(255,255,255,0.7);
			   color: #aa00ff;
			   visibility: hidden;
			   opacity: 0;
			   transition: 0.3s;
			}
			.ajax-loader .spinner-border{
			   width: 40px;
			   height: 40px;
			   border: 4px solid currentColor;
			   border-right-color: transparent;
			}
			.ajax-loader.active{
			   visibility: visible;
			   opacity: 1;
			} 
		</style>
	</head>
	<!---------------------------------------------------- Start Form ------------------------>
<body>
	<div class="ajax-loader show">
		<div class="spinner-border text-danger active" role="status">
		  	<span class="sr-only">Loading...</span>
		</div>
	</div>
	<div class="container">
		<h1 class="text-center"><font color="008B8B"><b>....Registration form....</b></font></h1>
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
					<div class="form-group">
						<label>Email :</label>
						<input type="text" name="email" class="form-control" id="email" placeholder="Enter Your Email.">
						<span id="email_error" class="text-danger"></span>
					</div>
					<div class="form-group">
						<label>Mobile No:</label>
						<input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter Your Mobile Number.">
						<span id="mobile_error" class="text-danger"></span>
					</div>
					<div class="form-group">
						<label>DOB</label>
						<input type="date" name="dob" class="form-control" id="dob" placeholder="Enter Your Birth Date.">
						<span id="dob_error" class="text-danger"></span>
					</div>
					<div class="form-group">
	                        <label for="gender">Gender : </label>
	                        Male <input type="radio" value="Male" name="gender" class="gender male_class">
	                        Female <input type="radio" value="Female" name="gender" class="gender female_class">
	                        <span id="gender_error" class="text-danger"></span>        
	                </div>
	                <div class="form-group">
	                        <label for="image"> Image </label>
	                        <input id="image" type="file" name="image" class="btn btn-info">
	                        <span id="image_error" class="text-danger"></span>
	                        <img src="" id="image_display" height='50px'>
	                        <input id="oldimage" type="hidden" name="oldimage" class="form-control">
	                </div>
	                <div id="preview">
						<div id="image_preview"></div>
					</div>
					<!-- <input type="hidden" name="action" value="insert" id="action"> -->
					<!--	<input type="submit" name="action" value="submit"> -->
					<div>
						<button class="btn btn-success" type="submit" id="form_submit" data-toggle="modal">SUBMIT</button>
						<button class="btn btn-success" type="button" name="update" id="update" data-toggle="modal">UPDATE</button>
						<button class="btn btn-success" type="reset" id="reset">RESET</button>
					</div>	
				</form>		
			</div>
		</div>
	</div>
	<!------------------------------ Modal ---------------------------------->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			    </div>
			      	<div class="modal-body">
			     		Data Inserted Successfully
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
			    	</div>
		    </div>
	  	</div>
	</div>
</body>
<!------------------------------------------------------ End Form ------------------------>
	<div>
		<table id="studentdat" border="4" align="center" class="table table-striped table-bordered text-center">
			<h1 class="text-center"><font color="008B8B"><b>....Display Records....</b></font></h1>
			<tr>
				<th><button id="deletes" class="btn btn-danger">Delete</button></th>
				<th>Id</th>
				<th>Full Name</th>
				<th>Email</th>
				<th>Mobile No</th>
				<th>DOB</th>
				<th>Gender</th>
				<th>Image</th>
				<th>Update</th>
			</tr>
				<tbody id="studentdata">
				</tbody>
		</table>
	</div>
<script>
$(document).ready(function(){
	// .................................................client side validation....................
	$('#frm_user_register').validate({
        // rules: {
        //     fname: {
        //         required: true,
        //     },
        //     lname: {
        //         required: true,
        //     },
        //     email: {
        //         required: true,
        //     },
        //     mobile: {
        //         required: true,
        //     },
        //     dob: {
        //         required: true,
        //     },
        //     gender: {
        //         required: true,
        //     },
        //     image: {
        //         required: true,
        //     }
        // },
        // messages: {
        //     fname: 'Please enter First Name.',
        //     lname: 'Please enter last Name.',
        //     email: 'Please Enter Email Address.',
        //     mobile: 'Please Enter Mobile Number.',
        //     dob: 'Please Enter Your Birth Date.',
        //     gender: 'Please Select Your Gender.',
        //     image: 'Please Attech Your File.',
        // },
        highlight: function(element, errorClass, validClass) {
        $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler:  function(form){
        	insert_data(form);
    	}
	});
	// .................................................insert data...................
	function insert_data(form){
		var formData = new FormData(form);
		formData.append("action", 'insert');
		$.ajax({
			url:'singleFileServer.php',
			type:'POST',
			dataType:'JSON',
			data: formData,
            processData: false,
            contentType: false,
			beforeSend:function() {
				$(document).find('.ajax-loader').addClass('active');
			},
			success:function(data){
				if(data.status == false){
					$(document).find('.ajax-loader').removeClass('active');
						$.each(data.error, function(index, value){
		                    console.log(index);
		                    $('#' + index + "_error").html(value);
		                    console.log(value);
	                	});
				}else{
					$("#exampleModalCenter").modal('show');			
					if(data){
						getdata();
						$(document).find('.ajax-loader').removeClass('active');
						$("#frm_user_register").trigger('reset');
					}	
				}
			},
		});
	}
	getdata();
	// .................................................Display Data...................
	function getdata(){
		$.ajax({
			type: "POST",
			url: "singleFileServer.php",
			data: {
				action: 'list'
			},
			dataType: 'JSON',
			success: function(response){
				$html = "";
				$.each(response, function(key, value){
					$html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + value.id + ' </td> <td>' + value.firstname + '  ' + value.lastname + '</td> <td>' + value.email + '</td> <td> ' + value.mobile + ' </td><td> ' + value.dob + ' </td><td> ' + value.gender + ' </td> <td> <img src="images/' + value.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
				});
				$('#studentdata').html($html);
			}
		});
	}
	// .................................................Edit data...................
	$("#update").hide();
	$(document).on('click','.edit',function(){
		// console.log('assa');
		var id = $(this).attr("data-id");
		var name = $('#name').val();
		var lastname = $('#lname').val();
		var email = $('#email').val();
		var mobile = $('#mobile').val();
		var dob = $('#dob').val();
		var gender = $('.gender').val();
		var image = $('#image').val();
		var oldimage = $('#oldimage').val();
		// alert(id);
		$('#update').show();
		$('#form_submit').hide();
		$.ajax({
			url: "singleFileServer.php",
			type: "POST",
			data: {
				'id': id,
				'action': 'edit'
			},
			dataType: "json",
			success: function(data){
				console.log(data);
				$('#name').val(data.users.firstname);
				$('#lname').val(data.users.lastname);
				$('#email').val(data.users.email);
				$('#mobile').val(data.users.mobile);
				$('#dob').val(data.users.dob);
				$('#oldimage').val(data.users.image);
				var radio = data.users.gender;
				$('input:radio[name="gender"][value="'+radio+'"]').attr('checked',true);
				console.log(data.users.image);
				$('#image_display').attr('src','images/'+data.users.image);
				$('#id').val(data.users.id);
			}
		});
	});
	// .................................................Update data...................
	$(document).on('click','#update',function(){
		console.log('assaaaaaaa');
		var form = $("#frm_user_register");
		var formData = new FormData(form[0]);
		formData.append("action", 'update');
		// if(confirm("Are You Sure To Update This Recored")){
			$.ajax({
				url: "singleFileServer.php",
				type: "POST",
				data: formData,
				cache: false,
				processData: false,
	            contentType: false,
				dataType: 'JSON',
				beforeSend:function(){
					$(document).find('.ajax-loader').addClass('active');
				},
				success: function(response){
					if(response.status == true){
						var rowhtml = '<td><input type="checkbox" value="' + response.data.id + '"></td><td> ' + response.data.id + ' </td> <td>' + response.data.fname + '  ' + response.data.lname + '</td> <td>' + response.data.email + '</td> <td> ' + response.data.mobile + ' </td><td> ' + response.data.dob + ' </td><td> ' + response.data.gender + ' </td> <td> <img src="images/' + response.data.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + response.data.id + '>Edit</button></td>';
						$('#studentdata').find('tr[id=' + response.data.id + ']').html(rowhtml);
						alert("data updated successfully");
							// $("#exampleModalCenter").modal('show');
							$('#update').hide();
							$('#form_submit').show();
						$(document).find('.ajax-loader').removeClass('active');
					}else {
						$(document).find('.ajax-loader').removeClass('active');
						$.each(response.error, function(index, value){
	                        console.log(index);
	                        $('#' + index + "_error").html(value);
	                        console.log(value);
	                    });
					}
					
				}
			});
		// }
	});
	// .................................................Multipal Row Deleted...................
	$(document).on('click','#deletes',function(){
		var id = [];
		$(":checkbox:checked").each(function(key){
			id[key]=$(this).val();
		});
			if(id.length === 0){
				alert("Please Selected atleast One Id");
			}else if(confirm("Are you Sure You Want To Deleted this row....")){
				$.ajax({
					url: "singleFileServer.php",
					type: "POST",
					dataType :'JSON',
					data: {
							'id': id,
							'action': 'delet'
						},
					success: function(res){
						// console.log(res.id);return false;
						if(res){
							$.each(res.id, function(key,value){
							// 	console.log(kay);
								$('#studentdata').find('tr[id=' + value + ']').remove();
							});
							alert("successfully deleted");
							// getdata();
						}else{
							alert("no deleted");
						}
					}
				});
			}
	});
	// .................................................resert form...................
		$(document).on('click','#reset',function(){
			// $("#frm_user_register").trigger('reset');
			$('#form_submit').show();
			$('#update').hide();
			$('input:radio[name="gender"]').attr('checked',false);
			$('#image_display').attr('src',"");
		});
	// .................................................Future Date Not Selected...................
	$(function() {
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();
        var maxDate = year + '-' + month + '-' + day;
        $('#dob').attr('max', maxDate);
    });
});
</script>
</html>