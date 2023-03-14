<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	$civil_status = retrieve_civil_status();
	$errors = ["errLName" => "", "errFName" => "","errMName" => "", "errDateOfBirth" => "", "errPlaceOfBirth" => "", "errAddress" => "", "errResidentSince" => "", "errCitizenship" => "", "errOccupation" => "", "errSalary" => ""];
	$valid = true;
	if(is_post_request()) {
		$resident = [];
		$resident['resident_id'] = $_POST['resident_id'];
		$resident['last_name'] = $_POST['txtLName'];
		$resident['first_name'] = $_POST['txtFName'];
		$resident['middle_name'] = $_POST['txtMName'];
		$resident['date_of_birth'] = $_POST['dateOfBirth'];
		$resident['sex'] = $_POST['sex'];
		$resident['civil_status_id'] = $_POST['civil_status_id'];
		$resident['place_of_birth'] = $_POST['txtPlaceOfBirth'];
		$resident['address'] = $_POST['txtAddress'];
		$resident['resident_since'] = $_POST['dateResidentSince'];
		$resident['citizenship'] = $_POST['txtCitizenship'];
		$resident['occupation'] = $_POST['txtOccupation'];
		$resident['salary_per_month'] = $_POST['txtSalary'];

		// validation for server-side
		if($resident['last_name'] == "") {
			$errors['errLName'] = "Last Name cannot be blank.";
			$valid = false;
		}
		if($resident['first_name'] == "") {
			$errors['errFName'] = "First Name cannot be blank.";
			$valid = false;
		}
		if($resident['middle_name'] == "")
		{
			$errors['errMName'] = "Middle Name cannot be blank.";
			$valid = false;
		}
		if($resident['date_of_birth'] == "")
		{
			$errors['errDateOfBirth'] = "Date of Birth cannot be blank.";
			$valid = false;
		}
		if($resident['place_of_birth'] == "")
		{
			$errors['errPlaceOfBirth'] = "Place of Birth cannot be blank.";
			$valid = false;
		}
		if($resident['address'] == "")
		{
			$errors['errAddress'] = "Address cannot be blank.";
			$valid = false;
		}
		if($resident['resident_since'] == "")
		{
			$errors['errResidentSince'] = "Resident Since cannote be blank.";
			$valid = false;
		}
		if($resident['citizenship'] == "")
		{
			$errors['errCitizenship'] = "Citizenship cannot be blank.";
			$valid = false;
		}
		if($resident['citizenship'] == "")
		{
			$errors['errOccupation'] = "occupation cannot be blank.";
			$valid = false;
		}
		if($resident['salary_per_month'] == "")
		{
			$errors['errSalary'] = "Salary cannot be blank.";
			$valid = false;
		}


		if($valid)
		{
			$success = update_resident($resident);
			if($success) {
				redirect_to(url_for("/administrator/residents/view.php?id=". $resident['resident_id'].
				 "&action=update"));
			}	
		}
		
	} else {
		$id = isset($_GET['id']) ? $_GET['id'] : "";
		$resident = retrieve_resident($id);
		//print_r($resident);
	}
?>
<?php 
	$title = "Update Resident | Administrator";
	include SHARED_PATH. "/administrator_header.php"; 
?>
	<div id="main">
		<div class="container">
			<a class="btn btn-success back" href="<?php echo url_for("administrator/residents/index.php"); ?>">&laquo; Back to List</a>

			<h1 class="header-text">Update Resident</h1>
			<div><strong>Required Fields <span class="required">*</span></strong></div>
			
			<form id="add-resident"  method="post" onsubmit="return ValidateResidentInfo()" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div id="residentName">
					<div class="form-group">
					    <label>Last Name <span class="required">*</span></label>
					    <div class="error small" id="errLName"><?php if(!empty($errors['errLName'])) echo $errors['errLName']; ?></div>
						<input type="text" class="form-control form-control-sm" placeholder="Last Name" name="txtLName" value="<?php echo $resident['last_name'] ?>">
					</div>
					<div class="form-group">
					    <label>First Name <span class="required">*</span></label>
					    <div class="error small" id="errFName"><?php if(!empty($errors['errFName'])) echo $errors['errFName']; ?></div>
						<input type="text" class="form-control form-control-sm" placeholder="First Name" name="txtFName" value = "<?php echo $resident['first_name'] ?>">
					</div>
					<div class="form-group">
					    <label>Middle Name <span class="required">*</span></label>
					    <div class="error small" id="errMName"><?php if(!empty($errors['errMName'])) echo $errors['errMName']; ?></div>
						<input type="text" class="form-control form-control-sm" placeholder="Middle Name"
						name="txtMName" value = "<?php echo $resident['middle_name'] ?>">
					</div>
				</div>
				<div class="form-group">
					<label>Date of Birth <span class="required">*</span></label>
					<div class="error small" id="errDateOfBirth"><?php if(!empty($errors['errDateOfBirth'])) echo $errors['errDateOfBirth']; ?></div>
					<input type="date" class="form-control form-control-sm" name="dateOfBirth" id="dateOfBirth"
					value = "<?php echo $resident['date_of_birth'] ?>">
				</div>
				<div class="form-group">
					<label>Sex <span class="required">*</span></label>
					<select class="form-control form-control-sm" name="sex" id="selSex">
						<option value="0" <?php if($resident['sex'] == 0) echo "selected"; ?>>Male</option>
						<option value="1" <?php if($resident['sex'] == 1) echo "selected"; ?>>Female</option>
					</select>
				</div>
				<div class="form-group">
					<label>Civil Status <span class="required">*</span></label>
					<select class="form-control form-control-sm" name="civil_status_id" id="selStatus">
						<?php  while($status = mysqli_fetch_assoc($civil_status)) : ?>
							<option value="<?php echo $status['civil_status_id'] ?>" <?php if($status['description'] == $resident['civil_status']) echo "selected"; ?>><?php echo $status['description']; ?></option>
						<?php endwhile; ?>						
					</select>
				</div>
				
				<div class="form-group">
					<label>Place of Birth <span class="required">*</span></label>
					<div class="error small" id="errPlaceOfBirth"><?php if(!empty($errors['errPlaceOfBirth'])) echo $errors['errPlaceOfBirth']; ?></div>
					<input type="text" class="form-control form-control-sm" name="txtPlaceOfBirth" id="txtPlaceOfBirth" value = "<?php echo $resident['place_of_birth'] ?>">
				</div>
				<div class="form-group">
					<label>Address <span class="required">*</span></label>
					<div class="error small" id="errAddress"><?php if(!empty($errors['errAddress'])) echo $errors['errAddress']; ?></div>
					<input type="text" class="form-control form-control-sm" name="txtAddress" id="txtAddress"
					 value = "<?php echo $resident['address'] ?>">
				</div>
				<div class="form-group">
					<label>Resident Since <span class="required">*</span></label>
					<div class="error small" id="errResidentSince"><?php if(!empty($errors['errResidentSince'])) echo $errors['errResidentSince']; ?></div>
					<input type="date" class="form-control form-control-sm" name="dateResidentSince" id="dateResidentSince" value = "<?php echo $resident['resident_since'] ?>">
				</div>
				<div class="form-group">
					<label>Citizenship <span class="required">*</span></label>
					<div class="error small" id="errCitizenship"><?php if(!empty($errors['errCitizenship'])) echo $errors['errCitizenship']; ?></div>
					<input type="text" class="form-control form-control-sm" name="txtCitizenship" id="txtCitizenship"
					 value = "<?php echo $resident['citizenship'] ?>">
				</div>
				<div class="form-group">
					<label>Occupation <span class="required">*</span></label>
					<div class="error small" id="errOccupation"><?php if(!empty($errors['errOccupation'])) echo $errors['errOccupation']; ?></div>
					<input type="text" class="form-control form-control-sm" name="txtOccupation" id="txtOccupation" value = "<?php echo $resident['occupation'] ?>">
				</div>
				<div class="form-group">
					<label>Salary Per Month <span class="required">*</span></label>
					<div class="error small" id="errSalary"><?php if(!empty($errors['errSalary'])) echo $errors['errSalary']; ?></div>
					<input type="number" class="form-control form-control-sm" name="txtSalary" id="txtSalary" value = "<?php echo $resident['salary_per_month'] ?>">
				</div>
				<button type="reset" class="btn btn-danger">Clear Inputs</button>
				<button type="submit" class="btn btn-success" name="resident_id" value ="<?php echo $id ?>">Save</button>
			</form>
		</div>

	</div>
	<script src="<?php echo url_for("/js/resident_validation.js") ?>"></script>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>