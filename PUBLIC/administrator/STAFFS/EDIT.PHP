<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$positions = retrieve_all_positions();
	if(is_post_request()) {
		$staff = [];
		$staff['staff_id'] = $_POST['staff_id'];
		$staff['position_id'] = $_POST['position_id'];
		$staff['contact_no'] = $_POST['txtContact'];
		$success = update_staff($staff);
		if($success) {
			redirect_to(url_for("/administrator/staffs/view.php?id=".$staff['staff_id']) . "&action=update");
		}
	} else {
		$staff = retrieve_staff($id);
	}
?>
<?php 
	$title = "Edit Staff | Administrator";
	include SHARED_PATH. "/administrator_header.php"; 
?>
	<div id="main">
		<div class="container">
			<a class="btn btn-success back" href="<?php echo url_for("administrator/staffs/index.php"); ?>">&laquo; Back to List</a>

			<h1 class="header-text">Edit Staff</h1>

			<a href="<?php echo url_for("/administrator/staffs/edit_account.php?id=".$id) ?>" class="btn btn-success">Edit account</a>

			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateStaff()">
				<h3>Staff Info</h3>
				<div class="error small" id="errSelected"></div>
				<div class="form-group">
					<label>Resident Id</label>
					<input type="text" value="<?php echo $staff['resident_id'] ?>" id="txtSelectedId" class="form-control" name="resident_id" readonly>
				</div>
				<div class="form-group">
					<label>Name</label>
					<input type="text" value="<?php echo $staff['last_name'] . ", " .$staff['last_name'] . " ". $staff['middle_name']; ?>"  class="form-control" id="txtName" disabled>
				</div>
				<div class="form-group">
					<label>Address</label>
					<input type="text" value="<?php echo $staff['address'] ?>" class="form-control" id="txtAddress" disabled>
				</div>
				<h3>Staff Information</h3>
				<div class="form-group">
					<label>Position</label>
					<select name="position_id" class="form-control">
						<?php while($position = mysqli_fetch_assoc($positions)) : ?>
							<option value="<?php echo $position['position_id'] ?>" <?php if($position['description'] == $staff['position']) echo "selected"; ?>><?php echo $position['description']; ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<div class="error small" id="errContact"></div>
					<label>Contact No</label>
					<input type="number" class="form-control" id="txtContact" name="txtContact" value="<?php echo $staff['contact_no'] ?>">
				</div>
				<button name="staff_id" class="btn btn-success btn-block" value="<?php echo $id ?>">Save</button>
			</form>
		</div>

	</div>
	<script>
		
	</script>
	
<?php include SHARED_PATH.'/administrator_footer.php'; ?>