<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	if(is_post_request()) {
		$account = [];
		$account['staff_id'] = $_POST['staff_id'];
		$account['username'] = $_POST['username'];
		$account['password'] = $_POST['password'];
		$success = update_account($account);
		if($success) {
			redirect_to(url_for("/administrator/logout.php"));
		}	
	} else {
		$staff = retrieve_staff($id);
	}
?>
<?php include SHARED_PATH.'/administrator_header.php'; ?>
	<div id="main">
		<div class="container">
			<a class="btn btn-success back" href="<?php echo url_for("administrator/staffs/index.php"); ?>">&laquo; Back to List</a>
			<h1 class="header-text">Update Account</h1>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" 
				onsubmit="return validateAccount()">
				<div class="form-group">

					<label>Username</label>
					<div class="error small" id="errUser"></div>
					<input type="text" name="username" class="form-control" value="<?php echo $staff['username'] ?>" id="txtUser">
				</div>
				<div class="form-group">
					<label>New Password</label>
					<div class="error small" id="errPassword"></div>
					<input type="password" name="password" class="form-control" id="txtPassword">
				</div>
				<div class="form-group">
					<label>Confirm Password</label>
					<div class="error small" id="errConfirm"></div>
					<input type="password" name="confirm" class="form-control" id="txtConfirm">
				</div>
				<button type="submit" class="btn btn-success" name="staff_id" value="<?php echo $id ?>">Update Account</button>
			</form>
		</div>
	</div>
	<script>
		var txtUser = document.getElementById("txtUser");
		var txtPassword = document.getElementById("txtPassword");
		var txtConfirm = document.getElementById("txtConfirm");
		//errors
		var errUser = document.getElementById("errUser");
		var errPassword = document.getElementById("errPassword");
		var errConfirm = document.getElementById("errConfirm");
		var error = document.getElementsByTagName("error");

		function validateAccount() {
			var valid = true;
			clearErrorMessage();
			//username
			if(txtUser.value == "") {
				errUser.innerHTML = "Username cannot be blank.";
				valid = false;
			} else if(txtUser.value.length > 20 || txtUser.value.length < 5) {
				errUser.innerHTML = "Username characters length must be between 5 and 20.";
				valid = false;
			}
			//password
			if(txtPassword.value == "" || txtPassword.value == null) {
				errPassword.innerHTML = "Password cannot be blank";
				valid = false;
			} else if(txtPassword.value.length > 20 || txtPassword.value.length < 5) {
				errPassword.innerHTML = "Password characters length must be between 5 and 20.";
				valid = false;
			}
			//confirm
			if(txtPassword.value != txtConfirm.value) {
				errConfirm.innerHTML = "Password and confirm password doesn't match.";
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
<?php include SHARED_PATH.'/administrator_footer.php'; ?>