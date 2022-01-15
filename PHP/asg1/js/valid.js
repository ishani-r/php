
	$('#frm_register').validate({
		rules:{
			firstname:{
				required: true,
				nowhitespace: true,
			},
			lastname:{
				required: true,
				nowhitespace: true,
			},
			email: {
                required: true,
				nowhitespace: true,
                email: true,
                remote: {
					url: "server_register.php",
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
			user_name:{
				required: true,
				nowhitespace: true,
				remote: {
					url: "server_register.php",
					type: "POST",
					dataType: "JSON",
					data:{
						'action':'check_user',
						user:function(){
							return $("#user_name").val()
						},
						id:function(){
							return $("#id").val()
						}
					}
				},
			},
			mobile: {
				required: true,
				nowhitespace: true,
				remote: {
					url: "server_register.php",
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
			password:{
				required: true,
				nowhitespace: true,
			},
			cpassword:{
				required: true,
				nowhitespace: true,
			},
			gender:{
				required: true,
				nowhitespace: true,
			}
		},
		messages: {
			firstname: {
				required: 'Enter First Name.',
			},
			lastname: 'Enter Last Name',
			email: {
              	required: 'Enter Your Email',
              	remote: "This Email is already taken! Try another.",
       		},
			user_name: {
				required: 'Enter Your User Name',
              	remote: "This User Name is already taken! Try another.",
              },
			mobile: {
				required:'Enter Your Mobile Number',
				remote: "This Mobile is already taken! Try another.",
			},
			password: 'Enter Your Password',
			cpassword: 'Enter Your Confirm Password',
			gender: 'Select Your Gender',
		},
		submitHandler:  function(form){
			insert_data();
  		}
	});
	//-----------------------------------Insert Data----------------------------
	function insert_data(){
		$('.error').html("");
		var form = $("#frm_register");
		var formData = new FormData(form[0]);
		formData.append("action", 'insert');
		console.log("aaaaaaaaaaaaaa");
        $.ajax({
          	url:'server_register.php',
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
	          		console.log(data.msg);
	          		$("#image_error").html(data.msg);
	                $.each(data.error, function(index, value){
	                    console.log(index);
	                    $('#' + index + "_error").html(value);
	                    console.log(value);
	                });
	            }else{
	            	if(data){
	            		swal("Good job!", "Your Data Submited successfully!", "success");
	            		window.location.href = data.url;
	            	}
	            }
        	},
        });
	}
	//-----------------------------------Validation Login---------------
	$('#frm_login').validate({
		rules:{
			user_name:{
				required: true,
				nowhitespace: true,
			},
			password:{
				required: true,
				nowhitespace: true,
			}
		},
		messages:{
			user_name: 'Enter Your User Name',
			password: 'Enter Your Password',
		},
	});
	//-----------------------------------login--------------------------
	$("#frm_login").submit(function(e) {
		e.preventDefault();
		var user_name = $("#user_name").val();
		var password = $("#password").val();
		$.ajax({
			url: "login_website.php",
			method: "post",
			data: {
				user_name: user_name,
				password: password,
				login: true,
			},
			dataType: "JSON",
			success: function(data) {
				if (data.status == true){
					swal("Good job!", "You are login Successfully", "success");
					window.location.href = "dashboard.php";
				}else {
					if(data.status == "false"){
						window.location.href = data.url;
					}
						alert(data.msg);
				}
			}
		});
	});
	//-----------------------------------Validation Change Password-------------------
	$('#frm_change_pass').validate({
		rules:{
			password:{
				required: true,
			},
			new_pass:{
				required: true,
			},
			confirm_pass:{
				required: true,
			}
		},
			messages:{
				password: 'Enter Your Current Password',
				new_pass: 'Enter Your New Password',
				confirm_pass: 'Enter Confirm Password',
		},
	});
	//-----------------------------------Change Password---------------
	$('#frm_change_pass').submit(function(e){
		e.preventDefault();
		var password = $("#password").val();
		var new_pass = $("#new_pass").val();
		var confirm_pass = $("#confirm_pass").val();
		var id = $("#change_id").val();
		$.ajax({
			url: "change_password.php",
			method: "POST",
			data:{
				password: password,
				new_pass: new_pass,
				confirm_pass: confirm_pass,
				id: id,
				change_pass: true,
			},
				dataType: "JSON",
				success: function(data) {
					if(data.status == true){
						swal("Good job!", "Your Password Update Successfully", "success");
						window.location.href = "login_website.php";
					}else {
					if(data.status == false){
						$.each(data.error, function(index, value){
	                    $('#' + index + "_error").html(value);
	                    console.log(value);
	                });
						$("#password_error").html(data.msgs);
						$("#confirm_pass_error").html(data.msg);
					}
				}
			},
		});
	});
	//-----------------------------------forget password-------------
	$('#frm_forgot_pass').validate({
		rules:{
			email:{
				required: true,
			},
		},
		messages:{
			email: 'Please Enter Email.',
		},
		submitHandler: function(){
			var email = $("#email").val();
			$.ajax({
				url: "forget.php",
				method: "POST",
				data:{
					email: email,
					forgot: true,
				},
				dataType: "JSON",
				success: function(data) {
					if(data.status == true){
						alert("Youe Email Send successfully");
						swal({
							position: 'top-end',
							icon: 'success',
							title: 'Your work has been saved',
							showConfirmButton: false,
							timer: 1500
						});
							window.location.href = "otp.php";
					}
					else {
						if(data.status == false){
							swal("error!", "User Email is Not Sign In ! Please Sign Up.", "error");
						}
					}
				},
			});
		}
	});
	//-----------------------------------sign up otp-----------------------------
	$('#frm_sign_up').validate({
		rules:{
			signup_otp:{
				required: true,
			},
		},
		messages:{
			signup_otp: 'Enter OTP',
		},
		submitHandler: function(){
			var email = $("#email").val();
			var signup_otp = $("#signup_otp").val();
			console.log(email);
			$.ajax({
				url: "singup_otp.php",
				method: "POST",
				data:{
					email: email,
					signup_otp: signup_otp,
					otp: true,
				},
				dataType: "JSON",
				success: function(data){
					if(data.status == true){
						alert("Your Account is verified successfully.");
						window.location.href = "dashboard.php";
					}else {
						if(data.status == false){
							swal("error!", "Your Account is Not Verify.", "error");
						}
					}
				}
			});
		}
	});
	//-----------------------------------send otp---------------------------
	$('#frm_otp').validate({
		rules:{
			otp:{
				required: true,
			},
			new_pass:{
				required: true,
			},
			confirm_pass:{
				required: true,
			}
		},
		messages:{
			otp: 'Please Enter OTP!',
			new_pass: 'Please Enter New Password!',
			confirm_pass: 'Please Enter Confirm Password!',
		},
		submitHandler: function(){
			var email = $("#email").val();
			var otp = $("#otp").val();
			var new_pass = $('#new_pass').val();
			var confirm_pass = $('#confirm_pass').val();
			console.log(confirm_pass);
			$.ajax({
				url: "otp.php",
				method: "POST",
				data:{
					email: email,
					otp: otp,
					new_pass: new_pass,
					confirm_pass: confirm_pass,
					check_otp: true,
				},
				dataType: "JSON",
				success: function(data){
					if(data.status == false){
						$("#otp_error").html(data.msg);
						$("#otp_error").html(data.ms);
					}else{
						if(data.status == true){
							swal("Good job!", "Your Password is Successfully Updated", "success");
							window.location.href = "login_website.php";
						}
					}
				}
			});
		}
	});
	//-----------------------------------Rsend OTP-----------------------------
	$('#frm_sign_up').validate({
		rules:{
			signup_otp:{
				required: true,
			},
		},
		messages:{
			signup_otp: 'Enter OTP',
		},
		submitHandler: function(){
			var email = $("#email").val();
			var signup_otp = $("#signup_otp").val();
			console.log(email);
			$.ajax({
				url: "reset_otp.php",
				method: "POST",
				data:{
					email: email,
					signup_otp: signup_otp,
					otp: true,
				},
				dataType: "JSON",
				success: function(data){
						alert("Your Account is verified successfully.");
					if(data.status == true){
						window.location.href = "dashboard.php";
					}else {
						if(data.status == false){
							swal("error!", "Your Account is Not Verify.", "error");
						}
					}
				}
			});
		}
	});
	//-----------------------------------signup_resend_otp---------------------
	$('#singup_resend_otp').click(function(e){
		e.preventDefault();
		var email = $("#email").val();
		console.log(email);
		$.ajax({
			url: "singup_otp.php",
			method: "POST",
			data:{
				email: email,
				action: 'reset',
			},
			dataType: "JSON",
			success: function(data){
				if(data.status == true){
					alert(data.msg);
					window.location.href = data.url;
				}
			}
		});
	});
	//-----------------------------------forgot_resend_otp-------------------------------
	$('#resend_otp').click(function(e){
		e.preventDefault();
		alert(123);
		var email = $("#email").val();
		console.log(email);
		$.ajax({
			url:"otp.php",
			method:"POST",
			data:{
				email: email,
				action: 'resend',
			},
			dataType: "JSON",
			success: function(data){
				console.log(data.status);
				if(data.status == true){
					alert(data.msg);
				}
			}
		});
	});