<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	if(empty($id)) {
		redirect_to(url_for("/administrator/staffs/index.php"));
		exit;
	}
	$staffs = retrieve_staff($id);


?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
 <div id="main">
 	<div class="container">
 		<a class="btn btn-success back" href="<?php echo url_for("administrator/staffs/index.php"); ?>">&laquo; Back to List</a>
 		<?php if($action == "insert") {
 			echo '<div class="alert alert-success">Staff recorded successfully</div>';
 		} else if($action == "update") {
 			echo '<div class="alert alert-success">Staff updated successfully</div>';
 		}
 		?>
 		<h1>Resident Information</h1>
 		<div class="resident-info">
	 		<p><b>RESIDENT ID:</b> <?php echo $staffs['resident_id']; ?></p>
	 		<p><b>NAME:</b> <?php echo $staffs['last_name'] . ", " .$staffs['last_name'] . " ". $staffs['middle_name']; ?></p>
	 		<p><b>POSITION:</b> <?php echo $staffs['position']; ?></p>
	 		<p><b>CONTACT NO:</b> <?php echo $staffs['contact_no']; ?></p>
	 		<p><b>DATE HIRED:</b> <?php echo $staffs['date_hired']; ?></p>
	 		<p><b>ADDRESS:</b> <?php echo $staffs['address']; ?></p>
	 		<p><b>DATE OF BIRTH:</b> <?php echo $staffs['date_of_birth']; ?></p>
	 		<p><b>SEX:</b> <?php echo $staffs['sex'] == 0 ? "Male" : "Female"; ?></p>
	 		<p><b>CIVIL STATUS:</b> <?php echo $staffs['civil_status']; ?></p>
	 		<p><b>PLACE OF BIRTH:</b> <?php echo $staffs['place_of_birth']; ?></p>
	 		<p><b>CITIZENSHIP:</b> <?php echo $staffs['citizenship']; ?></p>
	 		<p><b>RESIDENT SINCE:</b> <?php echo $staffs['resident_since']; ?></p>
	 		<p><b>OCCUPATION:</b> <?php echo $staffs['occupation']; ?></p>
	 		<p><b>SALARY PER MONTH:</b> <?php echo $staffs['salary_per_month']; ?></p>
	 		<p><b>REGISTRATION DATE:</b> <?php echo $staffs['registration_date']; ?></p>
 		</div>
 	</div>
 </div>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>