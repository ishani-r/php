<?php
require_once("dbcontroler.php");
$db_handle = new DBcontroler();
if(!empty($_POST["country_id"])) {
	$query = "SELECT id,state_name FROM states WHERE countryID = '" . $_POST["country_id"] . "' order by state_name asc";
	$results = $db_handle->runQuery($query);
	?>
<option value disabled selected>Select State</option>
<?php
// print_r($results);
	foreach ($results as $states) {
		?>
	<option value="<?php echo $states["id"]; ?>"><?php echo $states["state_name"];?></option>

<?php
	}
}
?>
