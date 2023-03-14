<?php require_once '../../../private/initialize.php'; ?>
<?php
 	$violations = retrieve_all_violations(); 
 	$id = isset($_GET['id']) ? $_GET['id'] : "";
 	if(is_post_request()) {
 		$blotter = [];
 		$blotter['blotter_id'] = $_POST['blotter_id'];
 		$blotter['description'] = $_POST['description'];
 		$blotter['violation_id'] = $_POST['violation_id'];
 		$blotter['complainant_name'] = $_POST['complainant_name'];
 		$blotter['respondent_name'] = $_POST['respondent_name'];
 		$blotter['staff_id'] = $_SESSION['staff_id'];
 		$success = update_blotter($blotter);
 		// if($success) {
 		// 	echo "ok";
 		// } else {
 		// 	echo "not ok";
 		// }
 		if($success) {
 			redirect_to(url_for("/administrator/blotters/view.php?id=".$blotter['blotter_id'] . "&action=update"));
 		}

 	} else {
 		$blotter = retrieve_blotter($id);
 	}
 	//echo retrieve_last_blotter_id();
 	//echo json_encode(retrieve_all_blotters());
?>
<?php include SHARED_PATH.'/administrator_header.php' ?>

	<div id="main">
		<div class="container">
			<a href="<?php echo url_for("/administrator/blotters/index.php") ?>" class="btn btn-success">&laquo; Back to list</a>
			<h1 class="header-text">Add new Blotter Record</h1>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return validateForm()">
				
				<div class="form-group">
					<label>Description</label>
					<div class="error small" id="errDescription"></div>
					<textarea name="description" class="form-control" placeholder="Ilahad ang pangyayaring naganap.." rows="5" id="txtDescription"><?php echo $blotter['description']; ?></textarea>
				</div>
				<div class="form-group">
					<label>Select Violation</label>
					<select name="violation_id" class="form-control">
						<?php while($violation = mysqli_fetch_assoc($violations)) : ?>
							<option value="<?php echo $violation['violation_id'] ?>" <?php if($violation['description'] == $blotter['violation']) echo "selected"; ?>><?php echo $violation['description'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label>Complainant Name:</label>
					<div class="error small" id="errComplainant"></div>
					<input type="text" name="complainant_name" class="form-control" id="txtComplainant" value="<?php echo $blotter['complainant_name'] ?>">
				</div>
				<div class="form-group">
					<label>Respondent Name:</label>
					<div class="error small" id="errRespondent"></div>
					<input type="text" name="respondent_name" class="form-control" id="txtRespondent" value="<?php echo $blotter['respondent_name'] ?>">
				</div>
				<input type="hidden" name="blotter_id" value="<?php echo $blotter['blotter_id'] ?>">
				<button class="btn btn-success btn-block" name="btnSaveRecord" >Save Record</button>
			</form>
			
			
		</div>
	</div>
	<script type="text/javascript">
		var txtDescription = document.getElementById("txtDescription");
		var txtComplainant = document.getElementById("txtComplainant");
		var txtRespondent = document.getElementById("txtRespondent");
		//error message
		var error = document.getElementsByClassName("error");
		var errDescription = document.getElementById("errDescription");
		var errComplainant = document.getElementById("errComplainant");
		var errRespondent = document.getElementById("errRespondent");

		function validateForm() {
			var valid = true;
			clearErrorMessage();
			//description
			if(txtDescription.value.trim() == "") {
				errDescription.innerHTML = "Description cannot be blank.";
				valid = false;
			}

			//complainant
			if(txtComplainant.value.trim() == "") {
				errComplainant.innerHTML = "Complainant name cannot be blank.";
				valid = false;
			}

			//respondent
			if(txtRespondent.value.trim() == "") {
				errRespondent.innerHTML = "Respondent name cannot be blank.";
				valid = false;
			}

			if(!valid) {
				alert("There is an error in the input fieds. Please fix to continue the submission of form.");
			}

			return valid;
		}

		function clearErrorMessage() {
			for(var index = 0; index < error.length; index++) {
				error[index].innerHTML = "";
			}
		}
	</script>

<?php include SHARED_PATH.'/administrator_footer.php' ?>