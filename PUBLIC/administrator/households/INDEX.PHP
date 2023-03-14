<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	

?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
 <div id="main">
 	<div class="container">
 		<h1>Households</h1>
 		<a href="<?php echo url_for('/administrator/households/new.php') ?>" class="btn btn-success">Add household</a>
 		<br><br>
 		<table class="table table-bordered table-hover">
 			<th>Household ID</th>
 			<th>House Number</th>
 			<th>House Address</th>
 			<th>Total Members</th>
 			<th>Action</th>
 			<tbody id="tblHouseholds"></tbody>
 		</table>
 	</div>
 </div>
 <script type="text/javascript">
 	var tblHouseholds = document.getElementById("tblHouseholds");
 	var households = [];
 	document.getElementsByTagName("body")[0].addEventListener("click",retrieveHouseholds());
 	function retrieveHouseholds(keyword="") {
			var httpRequest = new XMLHttpRequest();
			httpRequest.open("GET","/barangay_marinig_ms/public/administrator/households/retrieve.php?keyword="+encodeURI(keyword));

			httpRequest.onload = function() {
				if(httpRequest.status >= 200 && httpRequest.status <= 400) {
					households = JSON.parse(httpRequest.responseText);
					displayHouseholds();
					console.log(households);
				}
			}

			httpRequest.send();
		}
		function displayHouseholds() {
			tblHouseholds.innerHTML = "";
			var display = "";
			for(var i = 0; i < households.length; i++) {
				display += "<tr>";
				display += "<td>" + households[i].house_hold_id + "</td>";
				display += "<td>" + households[i].house_number + "</td>";
				display += "<td>" + households[i].address + "</td>";
				display += "<td>" + households[i].total_members + "</td>";
				display += "<td>";
				display += '<a href="view.php?id='+  households[i].house_hold_id + '" class="btn btn-primary btn-sm">View</a>'; 
				display += '<a href="edit.php?id='+  households[i].house_hold_id + '" class="btn btn-success btn-sm">Edit</a>';  
				display += '<a href="delete.php?id='+  households[i].house_hold_id + '" class="btn btn-danger btn-sm">Deactivate</a>'; 
				display +=  "</td>";
				display += "</tr>";
			}
			tblHouseholds.innerHTML = display;
		}
 </script>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>