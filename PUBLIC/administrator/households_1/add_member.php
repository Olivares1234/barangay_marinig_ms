<?php require_once '../../../private/initialize.php'; ?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	if(is_post_request()) {
		$member = [];
		$member['house_hold_id'] = $_POST['house_hold_id'];
		$member['resident_id'] = $_POST['resident_id'];
		$member['role_in_the_family'] = $_POST['role_in_the_family'];
		$success = insert_member($member);
		if($success) {
			redirect_to(url_for("/administrator/households/view.php?id=".$member['house_hold_id']));
		}
	}
?>
<?php include SHARED_PATH.'/administrator_header.php' ?>

	<div id="main">
		<div class="container">
			<a href="<?php echo url_for("/administrator/households/view.php?id=".$id) ?>" class="btn btn-success">&laquo; Back to list</a>
				<h1 class="header-text">Add Member</h1>
				<br>
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
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				<h3>Resident Info</h3>
				<div class="form-group">
					<label>Id</label>
					<input type="text" name="resident_id" class="form-control" readonly id="selectedId">
				</div>
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" readonly id="txtName">
				</div>
				<div class="form-group">
					<label>Address</label>
					<input type="text" class="form-control" readonly id="txtAddress">
				</div>
				<div class="form-group">
					<label>Sex</label>
					<input type="text" class="form-control" readonly id="txtSex">
				</div>
				<div class="form-group">
					<label>Role in the family</label>
					<select name="role_in_the_family" class="form-control">
						<option value="Mother">Mother</option>
						<option value="Father">Father</option>
						<option value="Guardian">Guardian</option>
						<option value="Child">Child</option>
						<option value="Others">Others</option>
					</select>
				</div>
				<input type="hidden" name="house_hold_id" value="<?php echo $id ?>">
				<button type="submit" name="btnAdd" class="btn btn-success btn-block">Add</button>
			</form>
		</div>
	</div>
	<script src="<?php echo url_for("/js/table.js") ?>"></script>
	<script src="<?php echo url_for("/js/resident.js") ?>"></script>
	<script type="text/javascript">
		var txtSearch = document.getElementById("txtSearch");
		var tblResult = document.getElementById("tblResult");
		var tblResultBody = document.getElementById("tblResultBody");
		var txt
		var listResident;
		var resident = new Resident();
		var selectedId = document.getElementById("selectedId");
		var txtName = document.getElementById("txtName");
		var txtAddress = document.getElementById("txtAddress");
		var txtSex = document.getElementById("txtSex");
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
			selectedId.value = parentTr.childNodes[0].innerHTML;
			txtName.value = parentTr.childNodes[1].innerHTML;
			txtAddress.value = parentTr.childNodes[2].innerHTML;
			txtSex.value = parentTr.childNodes[3].innerHTML;
			parentTbl.style.display = "none";
			txtSearch.value = "";
		}
	</script>
<?php include SHARED_PATH.'/administrator_footer.php' ?>