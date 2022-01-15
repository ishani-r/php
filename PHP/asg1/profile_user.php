
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
									</tr>
								</thead>
							
							<?php
								require_once 'database.php';
								$sql = "SELECT * FROM `register`";

						        $result=mysqli_query($conn,$sql);

						        while ($row=mysqli_fetch_array($result))
						        {
						            $id=$row['id'];
						            $firstname=$row['firstname'];
						            $lastname=$row['lastname'];
						            $image=$row['image'];
						            
						            ?>
						            <tr id="<?php echo $id;?>">
						            <td><?php echo $id;?></td>
						            <td><img src="images/<?php echo $row['image']; ?>" height=100 width=100></td>
						            <td><?php echo $firstname.' '.$lastname;?></td>
						            <?php
										$class =' btn-success';
										$new_status = 'deactive';
										if($row['status'] == 'deactive'){
											$class ='btn-danger';
											$new_status = 'active';
										}
									?>
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
	<!-- Loading Scripts -->
	<?php include('includes/footer.php');?>