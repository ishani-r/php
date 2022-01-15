<?php
require_once("dbcontroler.php");
$db_handle = new DBcontroler();
if(!empty($_POST["state_id"])) {
	$query = "SELECT * FROM city WHERE stateID = '" . $_POST["state_id"] . "' order by city_name asc";
	$results = $db_handle->runQuery($query);
	?>
<option value disabled selected>Select City</option>
<?php
	foreach ($results as $cty) {
		?>
<option value="<?php echo $cty["id"]; ?>"><?php echo $cty["city_name"];?></option>
<?php
	}
}
?>