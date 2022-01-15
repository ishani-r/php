
<?php include('includes/header.php');
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

					<div class="row">
						<div class="col-md-12">
							<table>
								<tr>
									<td><strong>First Name</strong></td>
									<td><?php echo '<pre>'; print_r($_SESSION['user_name']); ?></td>
								</tr>
							</table>
						</div>
					</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Loading Scripts -->
	<?php include('includes/footer.php');?>