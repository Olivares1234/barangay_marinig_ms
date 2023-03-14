<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	if(empty($id)) {
		redirect_to(url_for("/administrator/residents/index.php"));
		exit;
	}
	$resident = retrieve_resident($id);
	// if(isset($_GET['action'])) {
	// 	$action = $_GET['action'];
	// } else {
	// 	$action = ""
	// }

?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
 <div id="main">
 	<div class="container">
 		<a class="btn btn-success back" href="<?php echo url_for("administrator/residents/index.php"); ?>">&laquo; Back to List</a>
 		<?php if($action == "insert") {
 			echo '<div class="alert alert-success">Resident recorded successfully</div>';
 		} else if($action == "update") {
 			echo '<div class="alert alert-success">Resident updated successfully</div>';
 		}
 		?>
 		<h1>Resident Information</h1>
 		<div class="resident-info">
	 		<p><b>RESIDENT ID:</b> <?php echo $resident['resident_id']; ?></p>
	 		<p><b>NAME:</b> <?php echo $resident['last_name'] . ", " .$resident['last_name'] . " ". $resident['middle_name']; ?></p>
	 		<p><b>ADDRESS:</b> <?php echo $resident['address']; ?></p>
	 		<p><b>DATE OF BIRTH:</b> <?php echo $resident['date_of_birth']; ?></p>
	 		<p><b>SEX:</b> <?php echo $resident['sex'] == 0 ? "Male" : "Female"; ?></p>
	 		<p><b>CIVIL STATUS:</b> <?php echo $resident['civil_status']; ?></p>
	 		<p><b>PLACE OF BIRTH:</b> <?php echo $resident['place_of_birth']; ?></p>
	 		<p><b>CITIZENSHIP:</b> <?php echo $resident['citizenship']; ?></p>
	 		<p><b>RESIDENT SINCE:</b> <?php echo $resident['resident_since']; ?></p>
	 		<p><b>OCCUPATION:</b> <?php echo $resident['occupation']; ?></p>
	 		<p><b>SALARY PER MONTH:</b> <?php echo $resident['salary_per_month']; ?></p>
	 		<p><b>REGISTRATION DATE:</b> <?php echo $resident['registration_date']; ?></p>
 		</div>
 	</div>
 </div>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>