<?php require_once '../../../private/initialize.php'; ?>
<?php
	if(is_post_request()) {
		$household = [];
		$household['house_number'] = $_POST['house_number'];
		$household['address'] = $_POST['house_address'];
		$success = insert_household($household);
		if($success) {
			redirect_to(url_for("/administrator/households/view.php?id=".mysqli_insert_id($conn) ));
		}
	}
?>
<?php include SHARED_PATH.'/administrator_header.php' ?>

	<div id="main">
		<div class="container">
			<a href="<?php echo url_for("/administrator/households/index.php") ?>" class="btn btn-success">&laquo; Back to list</a>
			<h1 class="header-text">Add new household</h1>			
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return validateForm()">
				<div class="form-group">
					<label>House number</label>
					<input type="number" name="house_number" class="form-control" id="txtHouseNo">

				</div>
				<div class="form-group">
					<label>House address</label>
					<input type="text" name="house_address" class="form-control" id="txtAddress">
				</div>
				<button name="btnSave" class="btn btn-success btn-block">Save</button>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		var txtAddress = document.getElementById("txtAddress");
		var txtHouseNo = document.getElementById("txtAddress");

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