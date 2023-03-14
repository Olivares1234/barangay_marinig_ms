<?php require_once '../../../private/initialize.php'; ?>
<?php
	if(is_post_request()) {
		$clearance = [];
		$clearance['resident_id'] = $_POST['resident_id'];
		$clearance['purpose'] = $_POST['purpose'];
		insert_barangay_clearance($clearance);
		$id = mysqli_insert_id($conn);
		redirect_to(url_for("/administrator/barangay_clearance/print/clearance.php?id=".$id));
	}  
?>
<?php include SHARED_PATH.'/administrator_header.php'; ?>

<div id="main">
	<div class="container">
		<h1 class="header-text">Add Permit</h1>
		<a href="<?php echo url_for('/administrator/barangay_clearance/') ?>" class="btn btn-success">&laquo; Back</a><br><br>
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
			<input type="hidden" name="resident_id" id="txtResidentId">
			<div class="form-group">
				<label>Name:</label>
				<input type="text" id="txtName" class="form-control" readonly>
			</div>
			<div class="form-group">
				<label>Age:</label>
				<input type="text" id="txtAge" class="form-control" readonly>
			</div>
			<div class="form-group">
				<label>Civil Status:</label>
				<input type="text" id="txtCivil" class="form-control" readonly>
			</div>
			<div class="form-group">
				<label>Citizenship:</label>
				<input type="text" id="txtCitizenship" class="form-control" readonly>
			</div>
			<div class="form-group">
				<label>Address:</label>
				<input type="text" id="txtAddress" class="form-control" readonly>
			</div>

			<div class="form-group">
				<label>Purpose:</label>
				<input type="text" class="form-control" name="purpose" id="txtPurpose">
			</div>
			<p id="txtCheck"></p>
			<button type="submit" class="btn btn-success btn-block" id="btnSave">Save and Print</button>
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
		var txtResidentId = document.getElementById("txtResidentId");
		var txtName = document.getElementById("txtName");
		var txtAge = document.getElementById("txtAge");
		var txtCivil = document.getElementById("txtCivil");
		var txtCitizenship = document.getElementById("txtCitizenship");
		var txtAddress = document.getElementById("txtAddress");
		var txtCheck = document.getElementById("txtCheck");
		var btnSave = document.getElementById("btnSave");
		var txtPurpose = document.getElementById("txtPurpose");

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
			txtName.value = parentTr.childNodes[1].innerHTML;
			txtAddress.value = parentTr.childNodes[2].innerHTML;
			txtCivil.value = parentTr.childNodes[5].innerHTML;
			txtCitizenship.value = parentTr.childNodes[6].innerHTML;
			// txtSex.value = parentTr.childNodes[3].innerHTML;
			txtResidentId.value = parentTr.childNodes[0].innerHTML;
			txtAge.value = parentTr.childNodes[4].innerHTML;
			parentTbl.style.display = "none";
			txtSearch.value = "";
			checkRecord(txtResidentId.value);
		}

		function checkRecord(id) {
			var httpRequest = new XMLHttpRequest();
			httpRequest.open("GET","/barangay_marinig_ms/public/administrator/barangay_clearance/check_record.php?id="+ id);

			httpRequest.onload = function() {
				if(httpRequest.status >= 200 && httpRequest.status <= 400) {
					txtCheck.innerHTML = httpRequest.responseText;
					if(txtCheck.innerText == "This resident has no deregatory/criminal records filed in this barangay.") {
						txtCheck.style.color = "green";
						btnSave.disabled = false;
					} else {
						txtCheck.style.color = "red";
						btnSave.disabled = true;
					}

				}
			}

			httpRequest.send();
		}

		function validateForm() {
			var valid = true;
			if(txtResidentId.value.trim() == "") {
				valid = false;
				alert("Please select a resident");
			}
			if(txtPurpose.value.trim() == "") {
				valid = false;
				alert("Please specify the purpose.");
			}
			checkRecord(txtResidentId);
			if(txtCheck.innerText == "This resident has no deregatory/criminal records filed in this barangay.") {
					txtCheck.style.color = "green";
					btnSave.disabled = false;
				} else {
					txtCheck.style.color = "red";
					btnSave.disabled = true;
					valid = false;
					alert("This resident has a record!");
				}
			return valid;
		}
	</script>

<?php include SHARED_PATH.'/administrator_footer.php'; ?>