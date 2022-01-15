
<?php include('includes/header.php');
	require_once 'database.php';
	if(empty($_SESSION['user_name'])){
	header("location: login_website.php");
}
?>
	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Dashboard</h2>
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
						            	<?php
						            		if($status == 'active'){
											?>
											<button class="btn btn-success"><?php echo $status;?></button>
										<?php
						            		}else{
						            		?>
						            		<button class="btn btn-danger"><?php echo $status;?></button>
										<?php
						            		}
						            		?>
									</td>

						            <td>
						            	<button type="button" class="btn btn-primary view"  data-id='<?php echo $id;?>'><i class="fa fa-eye" style="font-size:20px"></i></button>
						            	<!-- <?php
						            		if($_SESSION['user_name'] == $user_name){
						            			
						            	 		echo '<button type="button" class="btn btn-primary edit"  data-id='.$id.'><i class="fa fa-edit" style="font-size:20px"></i></button>&nbsp';
						            	 		echo '<button type="button" class="btn btn-primary stud_delete"  data-id='.$id.'><i class="fa fa-remove" style="font-size:20px;color:red"></i></button>';
						            		}
						            	?> -->
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
	<!-- Loading Scripts -->
	<?php include('includes/footer.php');?>