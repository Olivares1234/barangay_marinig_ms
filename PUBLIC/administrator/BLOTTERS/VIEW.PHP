<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	if(empty($id)) {
		redirect_to(url_for("/administrator/blotters/index.php"));
		exit;
	}
	$blotter = retrieve_blotter($id);
	$blotter_reported = retrieve_resident_blotter($id);
	

?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
 <div id="main">
 	<div class="container">
 		<a class="btn btn-success back" href="<?php echo url_for("administrator/blotters/index.php"); ?>">&laquo; Back to List</a>
 		<?php if($action == "insert") {
 			echo '<div class="alert alert-success">Blotter recorded successfully</div>';
 		} else if($action == "update") {
 			echo '<div class="alert alert-success">Blotter updated successfully</div>';
 		}
 		?>
 		<h1>Blotter Information</h1>
 		<div class="resident-info">
	 		<p><b>BLOTTER ID:</b> <?php echo $blotter['blotter_id']; ?></p>
	 		<p><b>DESCRIPTION:</b> <div> <?php echo $blotter['description']; ?></div></p>
	 		<p><b>COMPLAINANT NAME:</b><?php echo $blotter['complainant_name']; ?></p>
	 		<p><b>RESPONDENT NAME:</b> <?php echo $blotter['respondent_name']; ?></p>
	 		<p><b>VIOLATION:</b> <?php echo $blotter['violation']; ?></p>
	 		<p><b>STAFF:</b> <?php echo $blotter['staff']; ?></p>
 		</div>
 		
 		<?php 
 		 	if(mysqli_num_rows($blotter_reported) > 0) {
 		 		echo "<h3>Resident Involved</h3>";
				while ($resident = mysqli_fetch_assoc($blotter_reported)) {
					$sex = $resident['sex'] == "0" ? "Male" : "Female";
					echo "<p>NAME : $resident[name]</p>
					<p>SEX : $sex</p>
					<p>ADDRESS : $resident[address]</p><hr>";
				}
			}
 		 ?>
 	</div>
 </div>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>