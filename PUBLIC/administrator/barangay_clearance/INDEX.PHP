<?php require_once '../../../private/initialize.php'; ?>

<?php include SHARED_PATH.'/administrator_header.php'; ?>
<div id="main">
	<div class="container">
		<h1 class="header-text">Barangay Clearance</h1>
		<a href="<?php echo url_for("/administrator/barangay_clearance/add.php") ?>" class="btn btn-success">Add Clearance</a>
		<br><br>
		<input type="text" name="search" id="txtSearch" placeholder="Search.." class="form-control">
		<br><br>
		<table class="table">
			<th>ID</th>
			<th>Full Name</th>
			<th>Address</th>
			<th>Purpose</th>
			<th>Date Issued</th>
			<th>Action</th>
			<tbody id="tblClearance"></tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	var tblClearance = document.getElementById("tblClearance");
	var txtSearch = document.getElementById("txtSearch");
	var data;
	document.getElementsByTagName("body")[0].addEventListener("load",retrieveClearance());

	txtSearch.addEventListener("keyup",function() {
			retrieveClearance(txtSearch.value);
		});
	function retrieveClearance(keyword="") {
			var httpRequest = new XMLHttpRequest();
			httpRequest.open("GET","/barangay_marinig_ms/public/administrator/barangay_clearance/retrieve.php?keyword="+encodeURI(keyword));

			httpRequest.onload = function() {
				if(httpRequest.status >= 200 && httpRequest.status <= 400) {
					//console.log(httpRequest.responseText);
					data = JSON.parse(httpRequest.responseText);
					//console.log(data);
					displayClearance();
				}
			}

			httpRequest.send();
		}
		function displayClearance() {
			tblClearance.innerHTML = "";
			var display = "";
			for(var index = 0; index < data.length; index++) {
				display += "<tr>";
				display += "<td>"+ data[index].barangay_clearance_id +"</td>";
				display += "<td>"+ data[index].last_name + ", " + data[index].first_name + " "+ data[index].middle_name +"</td>";
				display += "<td>"+ data[index].address +"</td>";
				display += "<td>"+ data[index].purpose +"</td>";
				display += "<td>"+ data[index].date_issued +"</td>";
				display += '<td><a href="print/clearance.php?id='+ data[index].barangay_clearance_id +'" class="btn btn-success">Print</a></td>';
				display += "</tr>";
			}
			tblClearance.innerHTML = display;
		}
</script>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>