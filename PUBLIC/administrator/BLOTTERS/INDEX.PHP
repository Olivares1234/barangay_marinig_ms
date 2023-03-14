<?php require_once '../../../private/initialize.php'; ?>
<?php include SHARED_PATH.'/administrator_header.php' ?>

	<div id="main">
		<div class="container">
			<h1>Blotter Management</h1>
			<a href="<?php echo url_for("/administrator/blotters/new.php") ?>" class="btn btn-success">Add new blotter</a>
			<a href="<?php echo url_for("/administrator/blotters/blotter_resident.php") ?>" class="btn btn-success">Add Record of resident</a>
			<a href="<?php echo url_for("/administrator/blotters/add_violation.php") ?>" class="btn btn-success">Add Violation</a>
			<br><br>
			<b>Search : </b><input type="text" id="txtSearch" class="form-control" placeholder="Enter Complainant Name | Respondent Name | Description ..."><br><br>
			<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Blotter Id</th>
							<th>Description</th>
							<th>Complainant</th>
							<th>Complainee</th>
							<th>Violation</th>
							<th>Staff</th>
							<th>Date Report</th>					
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="tblBlotters">
					</tbody>
				</table>
		</div>
	</div>
	<script src="<?php echo url_for("/js/table.js") ?>"></script>
	<script src="<?php echo url_for("/js/blotter.js") ?>"></script>

	<script type="text/javascript">
		var tblBlotters = document.getElementById("tblBlotters");
		var blotter = new Blotter();
		var listBlotter = [];
		var txtSearch = document.getElementById("txtSearch");

		
		document.getElementsByTagName("body")[0].addEventListener("load",retrieveBlotters());

		txtSearch.addEventListener("keyup",function() {
			retrieveBlotters(txtSearch.value);
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
				var listOfAction = [table.NewAction("View","view.php?id="+listBlotter[index].getId(),"btn-primary"),
				table.NewAction("Edit","edit.php?id=" + listBlotter[index].getId(),"btn-success")];
				var action = table.CreateActionTD(listOfAction);
				listBlotter[index].Insert(tblBlotters,action);
			}
		}
	</script>
<?php include SHARED_PATH.'/administrator_footer.php' ?>