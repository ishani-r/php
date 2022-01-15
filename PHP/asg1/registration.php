<?php 
// session_start();
include('includes/header.php');
	if(empty($_SESSION['user_name'])){
		header("location: login_website.php");
	}
?>
<style>
	.error{
		color: red;
	}
</style>
<link rel="stylesheet" type="text/css" href="css/loader.css">

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
			<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
					<h2 class="page-title">Dashboard</h2>
					<!-- <div class="row"> -->
						<div class="col-md-12">
							<table id="studentdat" class="table table-striped table-bordered text-center">
								<thead>
									<tr>
										<th>ID</th>
										<th>Image</th>
										<th>Name</th>
										<th>Email</th>
										<th>UserName</th>
										<th>Mobile</th>
										<th>Gender</th>
										<th>Status</th>
										<th>View</th>
									</tr>
								</thead>
								<!-- <tbody id="studentdata"></tbody> -->
							
							<?php
								require_once 'database.php';
								$sql="select * from register";

						        $result=mysqli_query($conn,$sql);

						        while ($row=mysqli_fetch_array($result))
						        {
						            $id=$row['id'];
						            $firstname=$row['firstname'];
						            $lastname=$row['lastname'];
						            $email=$row['email'];
						            $user_name=$row['user_name'];
						            $mobile=$row['mobile'];
						            $gender=$row['gender'];
						            $status=$row['status'];
						            $image=$row['image'];
						            
						            ?>
						            <tr id="<?php echo $id;?>">
						            <td><?php echo $id;?></td>
						            <td><img src="images/<?php echo $row['image']; ?>" height=50 width=50></td>
						            <td><?php echo $firstname.' '.$lastname;?></td>
						            <td><?php echo $email;?></td>
						            <td><?php echo $user_name;?></td>
						            <td><?php echo $mobile;?></td>
						            <td><?php echo $gender;?></td>
						            <?php
										$class =' btn-success';
										$new_status = 'deactive';
										if($row['status'] == 'deactive'){
											$class ='btn-danger';
											$new_status = 'active';
										}
									?>
						            
						            <td>
										<i data-id="<?php echo $id;?>" class="status_checks btn
										<?php echo $class;?>" data-new_status="<?php echo $new_status; ?>" ><?php echo $status;?>
										</i>
									</td>

						            <td>
						            	<button type="button" class="btn btn-primary view"  data-id='<?php echo $id;?>'><i class="fa fa-eye" style="font-size:20px"></i></button>
						            	<?php
						            		if($_SESSION['user_name'] == $user_name){
						            			
						            	 		echo '<button type="button" class="btn btn-primary edit"  data-id='.$id.'><i class="fa fa-edit" style="font-size:20px"></i></button>&nbsp';
						            	 		echo '<button type="button" class="btn btn-primary stud_delete"  data-id='.$id.'><i class="fa fa-remove" style="font-size:20px;color:red"></i></button>';
						            		}
						            	?>
						            </td>
						           
						            </tr>
						         <?php   
						        }
						    	?>
						    </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //-------------------------------------Modal View----------------------------- -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      	<div class="modal-dialog modal-lg" role="document">
        	<div class="modal-content">
          		<div class="modal-header">
          			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        			</button>
            		<h2 class="text-center"><font color="008B8B"><b>...User Profile...</b></font><img src="images/" align="right" id="image_display" height="100px"></h2>
        			
          		</div>
	          	<div class="modal-body">
	          		<div class="container">
						<div class="row">
							<div class="col-md-8">
								<table  class="table table-striped table-bordered text-center">
									<tr>
										<td>Name</td>
										<td id="firstname"></td>
									</tr>
									<tr>
										<td>Email</td>
										<td id="email"></td>
									</tr>
									<tr>
										<td>User Name</td>
										<td id="user_name"></td>
									</tr>
									<tr>
										<td>Mobile</td>
										<td id="mobile"></td>
									</tr>
									<tr>
										<td>Gender</td>
										<td id="gender"></td>
									</tr>
								</table>
								<div>	
									<button class="btn btn-primary" type="button" name="update" id="update">UPDATE</button>
									<button class="btn btn-primary" type="reset" id="reset">RESET</button>
								</div>
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

	<!----------------------------------------- Modal Edit----------------------------------->
<div id="exampleModalCenter2" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Profile</h4>
			</div>
			<form method="POST" enctype="multipart/form-data" id="frm_register">
				<div class="modal-body">
					<div class="ajax-loader">
				
					</div>
					<div class="form-group">
						<label>First name:</label>
						<input type="text" name="firstname" class="form-control" id="first_name" placeholder="Enter Your First Name">
						<input type="hidden" name="id" id="stud_id" value="">
						<span id="firstname_error" class="error"></span>
					</div>
					<div class="form-group">
						<label>Last name:</label>
						<input type="text" name="lastname" class="form-control" id="last_name" placeholder="Enter Your Last Name">
						<span id="lastname_error" class="error"></span>
					</div>
					<div class="form-group">
						<label>Email :</label>
						<input type="text" name="email" class="form-control" id="emails" readonly placeholder="Enter Your Email.">
					</div>
					<div class="form-group">
						<label>User Name</label>
						<input type="text" name="user_name" class="form-control" id="user_names" readonly placeholder="Enter User Name">
					</div>
					<div class="form-group">
						<label>Mobile No:</label>
						<input type="text" name="mobile" class="form-control" id="mobiles" placeholder="Enter Your Mobile Number.">
						<span id="mobile_error" class="error"></span>
					</div>
					<div class="form-group">
						<label for="gender">Gender : </label>
						Male <input type="radio" value="Male" name="genders" class="genders male_class">
						Female <input type="radio" value="Female" name="genders" class="genders female_class">
						Other <input type="radio" value="Other" name="genders" class="genders other_class">
						<span id="gender_error" class="error"></span>  
					</div>
					<div class="form-group">
						<label for="image"> Image </label>
						<input id="image" type="file" name="image" class="btn btn-info">
						<img src="" id="image_displays" height='50px'>
						<input id="oldimage" type="hidden" name="oldimage" class="form-control">
						<span id="image_error" class="error"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="button" name="update" id="update">UPDATE</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Loading Scripts -->
<?php include('includes/footer.php');?>
