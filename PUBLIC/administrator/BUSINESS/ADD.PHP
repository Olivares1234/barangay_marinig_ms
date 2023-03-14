<?php require_once '../../../private/initialize.php'; ?>
<?php 
	if(is_post_request()) {
		$business = [];
		$business['resident_id'] = $_POST['owner-id'];
		$business['business_description'] = strtoupper($_POST['business-description']);
		$business['business_address'] = strtoupper($_POST['address']);
		$business['purok'] = $_POST['purok'];
		insert_business($business);
		$id = mysqli_insert_id($conn);
		redirect_to(url_for("/administrator/business/print/permit.php?id=".$id));
	}
?>
<?php include SHARED_PATH.'/administrator_header.php'; ?>

<div id="main">
	<div class="container">
		<h1 class="header-text">Add Permit</h1>
		<a href="<?php echo url_for('/administrator/business/index.php') ?>" class="btn btn-success">&laquo; Back</a><br>
		Searh Resident : <input type="text" id="txtSearch" class="form-control" placeholder="Search resident..">
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
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return validateForm()">
			<input type="hidden" name="owner-id" class="form-control" id="txtOwnerId">
			<div class="form-group">
				<label><b>Owner Name:</b></label>
				<input type="text" name="owner-name" class="form-control" readonly id="txtOwnerName">
			</div>
			<div class="form-group">
				<label><b>Business Description:</b></label>
				<input type="text" name="business-description" class="form-control" placeholder="Aling Puring Sari-Sari Store..." id="txtDescription">
			</div>
			<h2>Address</h2>
			<div class="form-group">
				<label><b>Purok:</b></label>
				<select class="form-control" name="purok">
					<option value="1">Purok 1</option>
					<option value="2">Purok 2</option>
					<option value="3">Purok 3</option>
					<option value="4">Purok 4</option>
					<option value="5">Purok 5</option>
					<option value="6">Purok 6</option>
				</select>
			</div>
			<div class="form-group">
				<label><b>Specific Address:</b></label>
				<div class="row">
					<div class="col">
						<input type="text" name="address" class="form-control" placeholder="House no. / Bkl - Lot - Subd." id="txtAddress">
					</div>
					<div class="col">
						<input type="text" readonly value="Marinig, Cabuyao, Laguna." class="form-control">
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-success btn-block">Save and Print</button>
			<br>
			<br>
		</form>
	</div>
</div>
<script src="<?php echo url_for("/js/table.js") ?>"></script>
<script src="<?php echo url_for("/js/resident.js") ?>"></script>
	<script type="text/javascript">
		var txtSearch = document.getElementById("txtSearch");
		var tblResult = document.getElementById("tblResult");
		var tblResultBody = document.getElementById("tblResultBody");
		var listResident;
		var resident = new Resident();
		// var selectedId = document.getElementById("selectedId");
		// var txtName = document.getElementById("txtName");
		// var txtAddress = document.getElementById("txtAddress");
		// var txtSex = document.getElementById("txtSex");
		var txtOwnerId = document.getElementById("txtOwnerId");
		var txtOwnerName = document.getElementById("txtOwnerName");
		var txtAddress = document.getElementById("txtAddress");
		var txtDescription = document.getElementById("txtDescription");
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
			// selectedId.value = parentTr.childNodes[0].innerHTML;
			// txtName.value = parentTr.childNodes[1].innerHTML;
			// txtAddress.value = parentTr.childNodes[2].innerHTML;
			// txtSex.value = parentTr.childNodes[3].innerHTML;
			txtOwnerId.value = parentTr.childNodes[0].innerHTML;
			txtOwnerName.value = parentTr.childNodes[1].innerHTML;
			parentTbl.style.display = "none";
			txtSearch.value = "";
		}

		function validateForm() {
			var valid = true;
			if(txtOwnerId.value.trim() == "" || txtDescription.value.trim() == "" || txtAddress.value.trim() == "") {
				valid = false;
				alert("Please fill up all fields");
			}
			return valid;
		}
	</script>

<?php include SHARED_PATH.'/administrator_footer.php'; ?>