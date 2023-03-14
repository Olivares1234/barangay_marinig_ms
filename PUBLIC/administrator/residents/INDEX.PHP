<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
<?php $residents_count = count_residents() ?>
	<div id="main" onload="Load()">
		<div class="container">
			
			<h1>List of Residents (<?php echo $residents_count; ?>)</h1>

			<a class= "btn btn-success" href="<?php echo url_for("/administrator/residents/new.php"); ?>"><span>Add new Resident</span></a><br><br>
			<b>Search : </b><input type="text" id="txtSearch" class="form-control" placeholder="Enter resident name..."><br><br>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Id</th>
							<th>FullName</th>
							<th>Address</th>
							<th>Sex</th>
							<th>Age</th>
							<th>Civil Status</th>
							<th>Citizenship</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="tblResident">
					</tbody>
				</table>
				<div id="pagination">
					<?php 
					$btnCount = ceil($residents_count / 10);
					for ($i=0; $i < $btnCount; $i++) :
					?>
						<button class="btn btn-primary" type="submit" value="<?php echo $i * 10 ?>" onclick="paginate(this)"><?php echo $i+1; ?></button>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo url_for("/js/table.js"); ?>"></script>
	<script src="<?php echo url_for("/js/resident.js"); ?>"></script>
	<script>
		var tblResident = document.getElementById("tblResident");
		var txtSearch = document.getElementById("txtSearch");
		var pagination = document.getElementById("pagination");
		var listResident;
		var resident = new Resident();


		document.getElementsByTagName("body")[0].addEventListener("load",retrieveResidents());

		txtSearch.addEventListener("keyup",function() {
			if(this.value != "") {
				pagination.style.display = "none";
			} else {
				pagination.style.display = "block";
			}
			retrieveResidents(txtSearch.value);
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
			tblResident.innerHTML = "";
			for(var index = 0; index < listResident.length; index++) {
				var table = new Table();
				var listOfAction = [table.NewAction("View","view.php?id="+listResident[index].getId(),"btn-primary"),
				table.NewAction("Edit","edit.php?id=" + listResident[index].getId(),"btn-success"),
				table.NewAction("Delete","delete.php?id="+listResident[index].getId(),"btn-danger")];
				var action = table.CreateActionTD(listOfAction);
				listResident[index].Insert(tblResident,action);
			}
		}
		function paginate(btn) {
			retrieveResidents("",parseInt(btn.value));
		}
		
	</script>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>