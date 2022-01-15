<!DOCTYPE html>
<html>
	<head>
		<title>Modal Exampale</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <style type="text/css">
        	.error {
                color: red;
            }
        </style>
	</head>
	<body>
		<div class="text-center">
	      	<button type="button" class="btn btn-primary buy" data-toggle="modal" data-target="#exampleModalCenter">
	        	<h3>Open Form</h3>
	      	</button>
	    </div>
    <!-- Modal -->
	    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	      	<div class="modal-dialog modal-lg" role="document">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<h1 class="text-center"><font color="008B8B"><b>....Registration form....</b></font></h1>
            			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              				<span aria-hidden="true">&times;</span>
            			</button>
	          		</div>
		          	<div class="modal-body">
		          		<div class="container">
							<div class="row">
								<div class="col-md-6">
									<form method="POST" enctype="multipart/form-data" id="frm_email_register">
										<div class="form-group">
											<label>Email</label>
											<input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email.">
											<span id="email_error" class="text-danger"></span>
											<input type="hidden" name="id" id="id" value="">
										</div>
										<div class="form-group">
											<label>Mobile</label>
											<input type="mobile" name="mobile" id="mobile" class="form-control" placeholder="Enter Your Mobile Number.">
											<span id="mobile_error" class="text-danger"></span>
										</div>
										<div>
											<button class="btn btn-success" type="submit" id="btn_submit">SUBMIT</button>
											<button class="btn btn-success" type="button" name="update" id="update">UPDATE</button>
											<button class="btn btn-success" type="reset" id="reset">RESET</button>
										</div>
									</form>
								</div>
							</div>
						</div>
		          	</div>
		          	<div class="modal-footer">
		            	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		          	</div>
		        </div>
		    </div>
		</div>	
	</body>
	<table id="studentdat" border="4" align="center" class="table table-striped table-bordered text-center">
		<tr>
			<th><button id="deletes" class="btn btn-danger">Delete</button></th>
			<th>Id</th>
			<th>Email</th>
			<th>Mobile</th>
			<th>Update</th>
		</tr>
		<tbody id="studentdata">
        </tbody>
	</table>
	<script type="text/javascript">
		$(document).ready(function(){
			//---------------------------Client Side Validation------------------------------
			
			$('#frm_email_register').validate({
				rules: {
               
                email: {
                    required: true,
                    email: true,
                    remote: {
						url: "servermodal_email.php",
						type: "POST",
						dataType: "JSON",
						data:{
							'action':'check_emails',
							email:function(){
							  return $("#email").val()
							},
							id:function(){
							  return $("#id").val()
							}
						}
                    },            
              	},
                mobile: {
                    required: true,
                    remote: {
						url: "servermodal_email.php",
						type: "POST",
						dataType: "JSON",
						data:{
                        	'action':'check_mobiles',
	                        mobile:function(){
	                          	return $("#mobile").val()
	                        },
	                        id:function(){
	                          	return $("#id").val()
	                        }
                      	}
                    },
                },              
            },
            messages: {
                email: {
                  	required: 'Please enter Your email',
                  	remote: "This Email is already taken! Try another.",
               	},
                mobile: {
                  	required: 'Please enter Your Mobile Number',
                  	remote: "This Mobile Number is already taken! Try another.",
               	},
            },
				submitHandler:  function(form){
					insert_data();
          		}
			});
			//-----------------------------Insert Data--------------------------------------
			function insert_data(form){
				var form = $("#frm_email_register");
				var formData = new FormData(form[0]);
		        formData.append("action", 'insert');
		        $.ajax({
		          	url:'server_register.php',
		          	type:'POST',
		          	dataType:'JSON',
		          	data: formData,
	                processData: false,
	                contentType: false,
		          	success:function(data){
			          	if(data.status == false){
			                $.each(data.error, function(index, value){
			                    console.log(index);
			                    $('#' + index + "_error").html(value);
			                    console.log(value);
			                });
			            }else{
			            	if(data){
			            		getdata();
			            		$("#exampleModalCenter").modal('hide');
			            		swal("Good job!", "Data Submited successfully!", "success");
			            	}
			            }
		        	},
		        });
	      	}
	      	getdata();
	      	//--------------------------------------Display Data-----------------------------
	      	function getdata(){
				$.ajax({
					type: "POST",
					url: "servermodal_email.php",
					data: {
						action: 'list'
					},
					dataType: 'JSON',
					success: function(response){
						console.log(response);
						$html = "";
						$.each(response, function(key, value){
							$html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + value.id + ' </td><td>' + value.email + '</td> <td> ' + value.mobile + ' </td></td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
						});
						$('#studentdata').html($html);
					},
				});
			}
			//--------------------------------------------Edit Data--------------------------
			$("#update").hide();
			$(document).on('click','.edit',function(){
				$('.error').html('');
				$("#btn_submit").hide();
				$("#update").show();
				$("#exampleModalCenter").modal('show');
				var id = $(this).attr("data-id");
		        var email = $('#email').val();
		        var mobile = $('#mobile').val();
			        $.ajax({
			          	url: "servermodal_email.php",
			          	type: "POST",
			          	data: {
			            'id': id,
			            'action': 'edit'
		          		},
			          	dataType: "json",
			          	success: function(data){
				            console.log(data);
				            $('#email').val(data.users.email);
				            $('#mobile').val(data.users.mobile);
				            $('#id').val(data.users.id);
			          	}
		        });
			});
			//-----------------------------------------Update Data---------------------------
			$(document).on('click','#update',function(){
				var isformValid = $(document).find("#frm_email_register").valid();
		        // swal("Please Fill All Field !! ","You Click The Button !!", "error");
		        if(isformValid){
		        	var form = $("#frm_email_register");
		          	var formData = new FormData(form[0]);
		          	formData.append("action", 'update');
		            $.ajax({
		              	url: "servermodal_email.php",
		              	type: "POST",
		              	data: formData,
		              	cache: false,
	              		processData: false,
	                    contentType: false,
		              	dataType: 'JSON',
		              
		              	success: function(response){
			                if(response.status == true){
			                    var rowhtml = '<td><input type="checkbox" value="' + response.data.id + '"></td><td> ' + response.data.id + ' </td><td>' + response.data.email + '</td> <td> ' + response.data.mobile + ' </td><td><button type="button" class="edit" data-id=' + response.data.id + '>Edit</button></td>';

			                  	$('#studentdata').find('tr[id=' + response.data.id + ']').html(rowhtml);

			                  	swal("Good job!", "Data Updated successfully!", "success");
			                    $("#exampleModalCenter").modal('hide');
			                }
			                else 
			                {  	
			                	swal("Please Fill All Field !! ","You Click The Button !!", "error");
			                  	$.each(response.error, function(index, value){
				                    $('#' + index + "_error").html(value);
			                  	});
			                }
		              	}
		            });
		        }
			});
			//-------------------------------------------Deleted Data--------------------------------
			$(document).on('click','#deletes',function(){
				var id = [];
		        $(":checkbox:checked").each(function(key){
		          	id[key]=$(this).val();
		        });
		        if(id.length === 0){
            		swal("Please Selected Atleast One Row !! ","You Click The Button !!", "error");
          		}else{
		           	if(confirm("Are you Sure You Want To Deleted this row....")){
		            swal({
		              	title: "Are you sure?",
		              	text: "Once deleted, you will not be able to recover this imaginary file!",
		              	icon: "warning",
		              	buttons: true,
		              	dangerMode: true,
		            })
		            .then((willDelete) => {
		              	if (willDelete) {
		                $.ajax({
		                  	url: "servermodal_email.php",
		                  	type: "POST",
		                  	dataType :'JSON',
		                  	data: {
		                      'id': id,
		                      'action': 'delet'
		                    },
		                  	success: function(res){
			                    if(res){
			                      	$.each(res.id, function(key,value){
			                        	$('#studentdata').find('#' + value ).remove();
			                      	});
			                      swal("Good job!", "Data Deleted successfully!", "success");
			                    }else{
			                      alert("no deleted");
			                    }
		                    }
		                });
		              	}else {
		                	swal("Your imaginary file is safe!");
		              	}
		            });
		            
		          }
        		}
			});
			$(document).on('click','#reset',function(){
		        $('#btn_submit').show();
		        $('#update').hide();
        	});
        	$(".buy").click(function(){
		        $("#reset").click();
		        $("#mobile_error").html('');
		        $("#email_error").html('');
		        $('.error').html('');
           });
		});
	</script>
</html>