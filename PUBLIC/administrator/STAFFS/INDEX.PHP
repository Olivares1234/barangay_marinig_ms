<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>

	<div id="main">
		<div class="container">
			<h1>List of Staffs(<?php echo count_staffs(); ?>)</h1>
			<a class= "btn btn-success" href="<?php echo url_for("/administrator/staffs/new.php"); ?>">Add new Staff</a><br><br>
			<b>Search : </b><input type="text" id="txtSearch" class="form-control" placeholder="Enter staff name..."><br><br>
			<table class="table table-bordered">
				<th>Staff Id</th>
				<th>Name</th>
				<th>Address</th>
				<th>Sex</th>
				<th>Age</th>
				<th>Position</th>
				<th>Date Hired</th>
				<th>Action</th>
				<tbody id="tblStaff">
					
				</tbody>
			</table>
		</div>
	</div>
	<script src="<?php echo url_for("/js/table.js"); ?>"></script>
	<script src="<?php echo url_for("/js/resident.js"); ?>"></script>
	<script src="<?php echo url_for("/js/staff.js"); ?>"></script>
	<script>
		var listStaff = [];
		var staff = new Staff();
		var tblStaff = document.getElementById("tblStaff");

		document.getElementsByTagName("body")[0].addEventListener("load",retrieveStaffs());

		txtSearch.addEventListener("keyup",function() {
			retrieveStaffs(txtSearch.value);
		});

		function retrieveStaffs(keyword="") {
			var httpRequest = new XMLHttpRequest();
			httpRequest.open("GET","/barangay_marinig_ms/public/administrator/staffs/retrieve.php?keyword=" + encodeURI(keyword));

			httpRequest.onload = function() {
				if(httpRequest.status >= 200 && httpRequest.status <= 400) {
					var data = JSON.parse(httpRequest.responseText);
					listStaff = staff.ParseJSON(data);
					displayStaffs();
					console.log(data);
				}
			}

			httpRequest.send();
		}
		
		function displayStaffs() {
			tblStaff.innerHTML = "";
			for(var index = 0; index < listStaff.length; index++) {
				var table = new Table();
				var listOfAction = [table.NewAction("View","view.php?id="+listStaff[index].getStaffId(),"btn-primary"),
				table.NewAction("Edit","edit.php?id=" + listStaff[index].getStaffId(),"btn-success"),
				table.NewAction("Delete","delete.php?id="+listStaff[index].getStaffId(),"btn-danger")];
				if(listStaff[index].getPosition() == "Administrator") {
					listOfAction[listOfAction.length-1].style.display="none";
				}
				var action = table.CreateActionTD(listOfAction);
				listStaff[index].Insert(tblStaff,action);
			}
		}
	</script>


<?php include SHARED_PATH.'/administrator_footer.php'; ?>