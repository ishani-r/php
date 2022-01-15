
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
<?php
$query = "SELECT * FROM `register` ";
$sql = mysqli_query($conn,$query);
$rowcount = mysqli_num_rows($sql);
?>
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">

													<div class="stat-panel-number h1 "><?php echo $rowcount; ?></div>
													<div class="stat-panel-title text-uppercase">Users</div>
												</div>
											</div>
											<a href="reg_users.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
<?php
$q = "SELECT * FROM `register` WHERE `gender`= 'female'";
$sql = mysqli_query($conn,$q);
$row_count = mysqli_num_rows($sql);
?>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">

													<div class="stat-panel-number h1 "><?php echo $row_count; ?></div>
													<div class="stat-panel-title text-uppercase">Female Users</div>
												</div>
											</div>
											<a href="female_user.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
<?php
$q = "SELECT * FROM `register` WHERE `gender`='male'";
$sql = mysqli_query($conn,$q);
$row_count = mysqli_num_rows($sql);
?>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">


													<div class="stat-panel-number h1 "><?php echo $row_count; ?></div>
													<div class="stat-panel-title text-uppercase">Male Users</div>
												</div>
											</div>
											<a href="male_user.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-warning text-light">
												<div class="stat-panel text-center">
												
													<div class="stat-panel-number h1 "><img src="download-ishani.png" height="45px"></div>
													<div class="stat-panel-title text-uppercase">Users Profiles</div>
												</div>
											</div>
											<a href="profile_user.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>



<!-- <div class="row">
					<div class="col-md-12">

						
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-primary text-light">
												<div class="stat-panel text-center">

													<div class="stat-panel-number h1 "></div>
													<div class="stat-panel-title text-uppercase">Subscibers</div>
												</div>
											</div>
											<a href="manage-subscribers.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-success text-light">
												<div class="stat-panel text-center">
												
													<div class="stat-panel-number h1 "></div>
													<div class="stat-panel-title text-uppercase">Queries</div>
												</div>
											</div>
											<a href="manage-conactusquery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
									<div class="col-md-3">
										<div class="panel panel-default">
											<div class="panel-body bk-info text-light">
												<div class="stat-panel text-center">

													<div class="stat-panel-number h1 "></div>
													<div class="stat-panel-title text-uppercase">Testimonials</div>
												</div>
											</div>
											<a href="testimonials.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
										</div>
									</div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
 -->








			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<?php include('includes/footer.php');?>