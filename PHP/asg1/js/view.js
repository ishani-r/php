//------------------------------View data----------------------------
$(document).on('click','.view',function(){
	$("#update").hide();
	$("#reset").hide();
	$(this).html('<i class="fa fa-spinner fa-spin"></i>');

	var id = $(this).attr("data-id");
        $.ajax({
          	url: "server_register.php",
          	type: "POST",
          	data: {
	            'id': id,
	            'action': 'edit'
      		},
          	dataType: "json",
          	success: function(data){
        		$("#exampleModalCenter").modal('show');
	            $('#id').val(data.users.id);
	            $('#firstname').html(data.users.firstname+" "+data.users.lastname);
	            $('#email').html(data.users.email);
	            $('#user_name').html(data.users.user_name);
	            $('#mobile').html(data.users.mobile);
	            $('#gender').html(data.users.gender);
        		$('#image_display').attr('src','images/'+data.users.image);
        		$('.view').html('<i class="fa fa-eye" style="font-size:20px"></i>');
        	}
    	});
});
//--------------------------------Edit Data----------------------------------
$(document).on('click','.edit',function(){
	$("#update").show();
	$("#reset").show();
	$(this).html('<i class="fa fa-spinner fa-spin"></i>');
	var id = $(this).attr("data-id");
	    $.ajax({
	      	url: "server_register.php",
	      	type: "POST",
	      	data: {
	        'id': id,
	        'action': 'edit'
	  		},
	      	dataType: "json",
	      	success: function(data){
				$("#exampleModalCenter2").modal('show');
	      		$('#stud_id').val(id);
				$('#first_name').val(data.users.firstname);
				$('#last_name').val(data.users.lastname);
				$('#emails').val(data.users.email);
				$('#user_names').val(data.users.user_name);
				$('#mobiles').val(data.users.mobile);
				var radio = data.users.gender;
				if(radio == 'male'){
					$('.male_class').prop('checked','checked');
				}else if(radio == 'female'){
					$('.female_class').prop('checked','checked');
				}else{
					$('.other_class').prop('checked','checked');
				}
				$('#image_displays').attr('src','images/'+data.users.image);
				$('#oldimage').val(data.users.image);
        		$('.edit').html('<i class="fa fa-edit" style="font-size:20px"></i>');
	      	}
		});
});
//--------------------------------------update data --------------------
$(document).on('click','#update',function(){
	var form = $("#frm_register");
  	var formData = new FormData(form[0]);
  	formData.append("action", 'update');
    $.ajax({
      	url: "server_register.php",
      	type: "POST",
      	data: formData,
      	cache: false,
  		processData: false,
        contentType: false,
      	dataType: 'JSON',
          	success: function(response){
            if(response.status == true){
                var rowhtml = '<td> ' + response.data.id + ' </td> <td><img src="images/' + response.data.image + '" height="50px"><td>' + response.data.firstname + ' ' + response.data.lastname + ' </td><td> ' + response.data.email + ' </td><td> ' + response.data.user_name + ' </td><td> ' + response.data.mobile + ' </td><td> ' + response.data.genders + ' </td><td> ' + response.data.status + ' </td> <td><i data-id=' + response.data.id + ' class="status_checks btn <?php echo $class;?>" data-new_status="<?php echo $new_status; ?>" ><?php echo $status;?></i>active</td> <td><button type="button" class="btn btn-primary view"  data-id=' +response.data.id + '><i class="fa fa-eye" style="font-size:20px"></i></button> <button type="button" class="btn btn-primary edit"  data-id='+response.data.id+'><i class="fa fa-edit" style="font-size:20px"></i></button> <button type="button" class="btn btn-primary stud_delete"  data-id='+response.data.id+'><i class="fa fa-remove" style="font-size:20px;color:red"></i></button></td>';
              	// $('#studentdat').find('tr[id=' + response.data.id + ']').html(rowhtml);
              	swal("Good job!", "Data Updated successfully!", "success");
              	$("#exampleModalCenter2").modal('hide');
              	location.reload();
            }
            else 
            {  	
              	$.each(response.error, function(index, value){
                    $('#' + index + "_error").html(value);
              	});
            }
      	}
    });
});
//-------------------------------------Delete Data----------------------------------
$(document).on('click','.stud_delete',function(){
	var id = $(this).attr("data-id");
	if(confirm("Are you Sure You Want To Deleted this row....")){
		$.ajax({
			url: "server_register.php",
			type: "POST",
			dataType :'JSON',
			data: {
				'id': id,
				'action': 'delet'
			},
			success: function(res){
				console.log(res.data);
				if(res.status == true){
					swal("Good job!", "Data Deleted successfully!", "success");
					window.location.href = "logout.php";
				}else{
					alert("no deleted");
				}
			}
		});
	} else{
		swal("Your imaginary file is safe!");
	}	
});
//----------------------------------Data Table--------------------------------
$(function(){
	$("#studentdat").dataTable();
});
//---------------------------Active Deactive-----------------------------
$(document).on('click','.status_checks',function(){
// var status = ($(this).hasClass("btn-success")) ? '0' : '1';
// var msg = (status=='0')? 'Deactivate' : 'Activate';
	var status = $(this).data('new_status');
	if(confirm("Are you sure to "+ status)){
		// var current_element = $(this);
		url = "server_register.php";
		$.ajax({
			type:"POST",
			url: url,
			data: {id:$(this).data('id'),status:status,
			action : 'stat'},
			success: function(data)
			{   
				location.reload();
			}
		});
	}      
});
//------------------------------Change Password-
