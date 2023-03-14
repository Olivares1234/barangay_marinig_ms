<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php
	//echo retrieve_last_staff_id();
	$positions = retrieve_all_positions();
	if(is_post_request()) {
		$staff = [];
		$staff['resident_id'] = $_POST['resident_id'];
		$staff['position_id'] = $_POST['position_id'];
		$staff['username'] = $_POST['txtUser'];
		$staff['password'] = $_POST['txtPassword'];
		$staff['contact_no'] = $_POST['txtContact'];
		$success = insert_staff($staff);
		if($success) {
			redirect_to(url_for("/administrator/staffs/view.php?id=".retrieve_last_staff_id(). "&action=insert"));
		}
	} 
?>
<?php 
	$title = "Add new Staff | Administrator";
	include SHARED_PATH. "/administrator_header.php"; 
?>
	<div id="main">
		<div class="container">
			<a class="btn btn-success back" href="<?php echo url_for("administrator/staffs/index.php"); ?>">&laquo; Back to List</a>

			<h1 class="header-text">Add new Staffs</h1>
			<div><strong>Required Fields <span class="required">*</span></strong></div>
			Searh Resident : <input type="text" id="txtSearch" class="form-control">
			<table id="tblResult" class="table">
				<th>Id</th>
				<th>FullName</th>
				<th>Address</th>
				<th>Sex</th>
				<th>Age</th>
				<th>Civil Status</th>
				<th>Citizenship</th>
				<th>Actions</th>
				<tbody id="tblResultBody">
					
				</tbody>
			</table>
			<br><br>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateStaff()">
				<h3>Selected Resident</h3>
				<div class="error small" id="errSelected"></div>
				<div class="form-group">
					<label>Resident Id</label>
					<input type="text" value="no selected" id="txtSelectedId" class="form-control" name="resident_id" readonly>
				</div>
				<div class="form-group">
					<label>Name</label>
					<input type="text" value="no selected"  class="form-control" id="txtName" disabled>
				</div>
				<div class="form-group">
					<label>Address</label>
					<input type="text" value="no selected" class="form-control" id="txtAddress" disabled>
				</div>
				<h3>Staff Information</h3>
				<div class="form-group">
					<label>Position</label>
					<select name="position_id" class="form-control">
						<?php while($position = mysqli_fetch_assoc($positions)) : ?>
							<option value="<?php echo $position['position_id'] ?>"><?php echo $position['description']; ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<div class="error small" id="errContact"></div>
					<label>Mobile No</label>
					<input type="number" class="form-control" id="txtContact" name="txtContact">
				</div>
				<h3>Account</h3>
				<div class="form-group">
					<div class="error small" id="errUser"></div>
					<label>Username</label>
					<input type="text" class="form-control" id="txtUser" name="txtUser">
				</div>
				<div class="form-group">
					<div class="error small" id="errPassword"></div>
					<label>Password</label>
					<input type="password" class="form-control" id="txtPassword" name="txtPassword">
				</div>
				<div class="form-group">
					<div class="error small" id="errConfirm"></div>
					<label>Confirm Password</label>
					<input type="password" class="form-control" id="txtConfirm" name="txtConfirm">
				</div>
				<button name="btnSave" class="btn btn-success btn-block">Save</button>
			</form>
		</div>

	</div>
	<script src="<?php echo url_for("/js/staff_validation.js") ?>"></script>
	<script src="<?php echo url_for("/js/table.js") ?>"></script>
	<script src="<?php echo url_for("/js/resident.js") ?>"></script>
	<script>
		var txtSearch = document.getElementById("txtSearch");
		var tblResult = document.getElementById("tblResult");
		var tblResultBody = document.getElementById("tblResultBody");
		var txtSelectedId = document.getElementById("txtSelectedId");
		var txtName = document.getElementById("txtName");
		var txtAddress = document.getElementById("txtAddress");
		var listResident;
		var resident = new Resident();
		tblResult.style.display = "none";

		txtSearch.addEventListener("keyup", function() {
			if(txtSearch.value == "") {
				tblResult.style.display = "none";
			} else {
				tblResult.style.display = "block";
				retrieveResidents(txtSearch.value);
			}
		});

		function retrieveResidents(keyword="",offset="0") {
			var httpRequest = new XMLHttpRequest();
			httpRequest.open("GET","/barangay_marinig_ms/public/administrator/residents/retrieve.php?keyword="+encodeURI(keyword) + "&offset=" + encodeURI(offset));

			httpRequest.onload = function() {
				if(httpRequest.status >= 200 && httpRequest.status <= 400) {
					var data = JSON.parse(httpRequest.responseText);
					listResident = resident.ParseJSON(data);
					displayResidents();
					console.log(data);
				}
			}

			httpRequest.send();
		}
		function displayResidents() {
			tblResultBody.innerHTML = "";
			for(var index = 0; index < listResident.length; index++) {
				var table = new Table();
				var listOfAction = [table.NewButton("select","btn btn-primary btnSelect",selectResident)];
				var action = table.CreateActionTD(listOfAction);
				listResident[index].Insert(tblResultBody,action);
			}
		}
		function selectResident(btn) {
			var parentTd = btn.parentNode;
			var parentTr = parentTd.parentNode;
			var parentTbl = parentTr.parentNode.parentNode;
			//var selectedId = parentTr.children[0].innerHTML;
			txtSelectedId.value = parentTr.children[0].innerHTML;
			txtName.value = parentTr.children[1].innerHTML;
			txtAddress.value = parentTr.children[2].innerHTML;
			parentTbl.style.display = "none";
			txtSearch.value = "";
		}
	</script>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>