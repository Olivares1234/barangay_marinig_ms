<?php require_once '../../../private/initialize.php'; ?>

<?php include SHARED_PATH.'/administrator_header.php'; ?>

<div id="main">
	<div class="container">
		<h1 class="header-text">Business Permit</h1>
		<a href="<?php echo url_for('/administrator/business/add.php') ?>" class="btn btn-success">Add Permit</a>
		<br><br>
		<input type="text" name="search" id="txtSearch" class="form-control" placeholder="Search business..."><br>
		<table class="table table-bordered table-hover">
 			<th>Permit ID</th>
 			<th>Owner</th>
 			<th>Business Description</th>
 			<th>Business Address</th>
 			<th>Date Issued</th>
 			<th>Expiration</th>
 			<th>Action</th>
 			<tbody id="tblBusiness"></tbody>
 		</table>
	</div>
</div>
<script>
	var tblBusiness = document.getElementById("tblBusiness");
	var txtSearch = document.getElementById("txtSearch");
	var data;

	document.getElementsByTagName("body")[0].addEventListener("load",retrieveBusiness());

	txtSearch.addEventListener("keyup",function() {
			retrieveBusiness(txtSearch.value);
		});
	function retrieveBusiness(keyword="") {
			var httpRequest = new XMLHttpRequest();
			httpRequest.open("GET","/barangay_marinig_ms/public/administrator/business/retrieve.php?keyword="+encodeURI(keyword));

			httpRequest.onload = function() {
				if(httpRequest.status >= 200 && httpRequest.status <= 400) {
					//console.log(httpRequest.responseText);
					data = JSON.parse(httpRequest.responseText);
					//console.log(data);
					displayBusiness();
				}
			}

			httpRequest.send();
		}
		function displayBusiness() {
			tblBusiness.innerHTML = "";
			var display = "";
			for(var index = 0; index < data.length; index++) {
				var exp = new Date(data[index].date_issued);
				exp.setFullYear(exp.getFullYear() + 1);
				display += "<tr>";
				display += "<td>"+ data[index].business_permit_id +"</td>";
				display += "<td>"+ data[index].owner_name +"</td>";
				display += "<td>"+ data[index].business_description +"</td>";
				display += "<td>"+ data[index].business_address + " PUROK " + data[index].purok + "</td>";
				display += "<td>"+ data[index].date_issued +"</td>";

				display += "<td>"+ exp.getFullYear() + "-" + (exp.getMonth() + 1) + "-" + exp.getDate() +"</td>";
				display += '<td><a class="btn btn-success" href="print/permit.php?id='+  data[index].business_permit_id+'">Print</a></td>';
				display += "</tr>";
			}
			tblBusiness.innerHTML = display;
		}
</script>

<?php include SHARED_PATH.'/administrator_footer.php'; ?>