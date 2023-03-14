<?php require_once '../../../private/initialize.php'; ?>
<?php
 	if(is_post_request()) {
 		insert_resident_blotter($_POST['blotter_id'],$_POST['resident_id']);
 		redirect_to(url_for("/administrator/blotters/view.php?id=". $_POST['blotter_id']));
 	}
?>
<?php include SHARED_PATH.'/administrator_header.php' ?>

	<div id="main">
		<div class="container">
			<a href="<?php echo url_for("/administrator/blotters/index.php") ?>" class="btn btn-success">&laquo; Back to list</a>
			<h1 class="header-text">Add Record of a resident</h1>
			
				<hr>
				<div class="form-group">

					<label><b>Search blotter report</b></label>
					<input type="text" id="txtSearchBlotter" class="form-control" placeholder="Search blotter report...">
				</div>
				<table class="table" style="display: none;" id="tblBlotterList">
					<th>Blotter Id</th>
					<th>Description</th>
					<th>Complainant</th>
					<th>Respondent</th>
					<th>Violation</th>
					<th>Staff</th>
					<th>Date Report</th>					
					<th>Actions</th>
					<tbody id="tblBlotter">
						
					</tbody>
				</table>
				<h3>Selected Blotter Report</h3>
				<div class="form-group">
					<label>Blotter Id</label>
					<input type="text" readonly class="form-control" id="txtBlotterId">
				</div>
				<div class="form-group">
					<label>description</label>
					<textarea rows="5" class="form-control" readonly id="txtDescription"></textarea>
				</div>
				<div class="form-group">
					<label>Complainant</label>
					<input type="text" readonly class="form-control" id="txtComplainant">
				</div>
				<div class="form-group">
					<label>Respondent</label>
					<input type="text" readonly class="form-control" id="txtRespondent">
				</div>
				<div class="form-group">
					<label>Violation</label>
					<input type="text" readonly class="form-control" id="txtViolation">
				</div>
				<div class="form-group">
					<label>Date Report</label>
					<input type="text" readonly class="form-control" id="txtDateReport">
				</div>
				
				<hr>
				<div class="form-group">

					<label><b>Search resident for report</b></label>
					<input type="text" id="txtSearchResident" class="form-control" placeholder="Search resident...">
				</div>
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
				<h3>Selected Resident</h3>
				<div class="form-group">
					<label>Resident Id</label>
					<input type="text" readonly class="form-control" id="txtResidentId">
				</div>
				<div class="form-group">
					<label>Resident Name</label>
					<input type="text" readonly class="form-control" id="txtName">
				</div>
				<div class="form-group">
					<label>Sex</label>
					<input type="text" readonly class="form-control" id="txtSex">
				</div>
				<div class="form-group">
					<label>Address</label>
					<input type="text" readonly class="form-control" id="txtAddress">
				</div>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onsubmit="return validateForm()">
				<input type="hidden" name="blotter_id" id="txtSelectedBlotter">
				<input type="hidden" name="resident_id" id="txtSelectedResident">	
				<button class="btn btn-success btn-block" name="btnSaveRecord" >Save Record</button>
			</form>
			
			
		</div>
	</div>
	<script src="<?php echo url_for("/js/table.js") ?>"></script>
	<script src="<?php echo url_for("/js/blotter.js") ?>"></script>
	<script src="<?php echo url_for("/js/resident.js") ?>"></script>
	<script type="text/javascript">
		var tblBlotterList = document.getElementById("tblBlotterList");
		var tblBlotters = document.getElementById("tblBlotter");
		var txtSearchBlotter = document.getElementById("txtSearchBlotter");
		var blotter = new Blotter();
		var listBlotter = [];
		var txtSearchResident = document.getElementById("txtSearchResident");
		var tblResult = document.getElementById("tblResult");
		var tblResultBody = document.getElementById("tblResultBody");
		var listResident;
		var resident = new Resident();
		tblResult.style.display = "none";

		//dom
		var txtBlotterId = document.getElementById("txtBlotterId");
		var txtDescription = document.getElementById("txtDescription");
		var txtComplainant = document.getElementById("txtComplainant");
		var txtRespondent = document.getElementById("txtRespondent");
		var txtViolation = document.getElementById("txtViolation");
		var txtDateReport = document.getElementById("txtDateReport");
		var txtSelectedBlotter = document.getElementById("txtSelectedBlotter");
		
		var txtSelectedResident = document.getElementById("txtSelectedResident");
		var txtResidentId = document.getElementById("txtResidentId");
		var txtName = document.getElementById("txtName");
		var txtSex = document.getElementById("txtSex");
		var txtAddress = document.getElementById("txtAddress");
		


		txtSearchBlotter.addEventListener("keyup",function() {
			if(txtSearchBlotter.value == "") {
				tblBlotterList.style.display = "none";
			} else {
				tblBlotterList.style.display = "block";
				retrieveBlotters(txtSearchBlotter.value);
			}
		});

		function retrieveBlotters(keyword="") {
			var httpRequest = new XMLHttpRequest();
			httpRequest.open("GET","/barangay_marinig_ms/public/administrator/blotters/retrieve.php?keyword=" + encodeURI(keyword));

			httpRequest.onload = function() {
				if(httpRequest.status >= 200 && httpRequest.status <= 400) {
					var data = JSON.parse(httpRequest.responseText);
					listBlotter = blotter.ParseJSON(data);
					displayBlotters();
					console.log(data);
				}
			}

			httpRequest.send();
		}
		
		function displayBlotters() {
			tblBlotters.innerHTML = "";
			for(var index = 0; index < listBlotter.length; index++) {
				var table = new Table();
				var listOfAction = [table.NewButton("select","btn btn-primary btnSelect",selectBlotter)];
				var action = table.CreateActionTD(listOfAction);				
				listBlotter[index].Insert(tblBlotters,action);
			}
		}
		function selectBlotter(btn) {
			var parentTD = btn.parentNode;
			var parentTR = parentTD.parentNode;

			txtBlotterId.value = parentTR.childNodes[0].innerHTML;
			txtDescription.value = parentTR.childNodes[1].innerHTML;
			txtComplainant.value = parentTR.childNodes[2].innerHTML;
			txtRespondent.value = parentTR.childNodes[3].innerHTML;
			txtViolation.value = parentTR.childNodes[4].innerHTML;
			txtDateReport.value = parentTR.childNodes[6].innerHTML;
			txtSelectedBlotter.value = parentTR.childNodes[0].innerHTML;

			tblBlotterList.style.display = "none";
			txtSearchBlotter.value = "";
		}
		


/******************************** RESIDENT **********************************************/
		txtSearchResident.addEventListener("keyup", function() {
			if(txtSearchResident.value == "") {
				tblResult.style.display = "none";
			} else {
				tblResult.style.display = "block";
				retrieveResidents(txtSearchResident.value);
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
			txtResidentId.value = parentTr.children[0].innerHTML;
			txtSelectedResident.value = parentTr.children[0].innerHTML;
			txtName.value = parentTr.children[1].innerHTML;
			txtAddress.value = parentTr.children[2].innerHTML;
			txtSex.value = parentTr.children[3].innerHTML;
			parentTbl.style.display = "none";
			txtSearchResident.value = "";
		}

		function validateForm() {
			if(txtSelectedBlotter.value.trim() == "") {
				alert("Please select a blotter report");
				return false;
			}
			if(txtSelectedResident.value.trim() == "") {
				alert("Please select a resident");
				return false;
			}
			
			return true;
		}
	</script>

<?php include SHARED_PATH.'/administrator_footer.php' ?>