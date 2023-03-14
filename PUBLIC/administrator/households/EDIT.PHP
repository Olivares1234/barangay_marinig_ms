<?php require_once '../../../private/initialize.php'; ?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$household = retrieve_household($id);
	$errors = ["errHouseNo" => "", "errAddress" => ""];



	if (is_post_request()) {
		$valid = true;
		$household = [];
		$household['house_hold_id'] = $_POST['btnSave'];
		$household['house_number'] = $_POST['house_number'];
		$household['address'] = $_POST['house_address'];

		if($household['house_number'] == "") {
			$errors['errHouseNo'] = "House number cannot be blank";
			$valid = false;
		}
		if($household['address'] == "") {
			$errors['errAddress'] = "Address cannot be blank.";
			$valid = false;
		}

		if($valid) {
			$success = update_households($household);
			if ($success){
				redirect_to(url_for("/administrator/households/view.php?id=".$household['house_hold_id'] ));
			}
		}

		
	}
?>
<?php include SHARED_PATH.'/administrator_header.php' ?>

	<div id="main">
		<div class="container">
			<a href="<?php echo url_for("/administrator/households/index.php") ?>" class="btn btn-success">&laquo; Back to list</a>
			<h1 class="header-text">Edit household</h1>			
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?id=".$id ?>" onsubmit="return validateForm()">
				<div class="form-group">
					<label>House number</label>
					<div class="small error"><?php echo $errors['errHouseNo']; ?></div>
					<input type="text" name="house_number" class="form-control" id="txtHouseNo" value="<?php echo $household['house_number'] ?>">

				</div>
				<div class="form-group">
					<label>House address</label>
					<div class="small error"><?php echo $errors['errAddress']; ?></div>
					<input type="text" name="house_address" class="form-control" id="txtAddress" value = "<?php echo $household['address'] ?>">
				</div>
				<button name="btnSave" class="btn btn-success btn-block" value ="<?php echo $id ?>">Save</button>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		var txtAddress = document.getElementById("txtAddress");
		var txtHouseNo = document.getElementById("txtHouseNo");

		function validateForm() {
			var valid = true;
			if(txtAddress.value.trim() == "" || txtHouseNo.value.trim() == "") {
				alert("Please fill up all fields");
				valid = false
			}  

			return valid;
		}
	</script>
<?php include SHARED_PATH.'/administrator_footer.php' ?>