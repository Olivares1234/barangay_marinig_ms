<?php include_once '../../../private/initialize.php'; ?>
<?php
	if(is_post_request()) {
		$official = [];
		$official['resident_id'] = $_POST['resident_id'];
		$official['resident_official_id'] = $_POST['official_id'];
		update_official($official);

		if($_FILES["fileToUpload"]["size"] > 0) {
			//upload image
			$target_dir = "uploads/";
			//echo $target_dir;
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$target_file = $target_dir . $official['resident_official_id'].".png";
			//echo "<script>alert('$target_file')</script>";
			$uploadOk = 1;
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			}
			
		}
		redirect_to(url_for("/administrator/officials/"));
	}
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$official = retrieve_official($id);
	}
?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
<div id="main">
	<div class="container">
		<a href="<?php echo url_for("administrator/officials") ?>" class="btn btn-success">&laquo; Back</a><br>
		<h1 class="header-text">Update Official</h1><br>

		Search : <input type="text" name="search" id="txtSearch" class="form-control" placeholder="Search..">
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
		<h2>Official Details(<?php echo $official['position']; ?>)</h2>
		<img src="<?php echo url_for('administrator/officials/uploads/'. $official['resident_official_id'] . ".png?v=".time()) ?>" style="width: 100px; height: auto;" id="official-img">
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="resident_id" id="txtId">
			<input type="hidden" name="official_id" value="<?php echo $official['resident_official_id'] ?>">
			<div class="form-group">
				<label>Image:</label>
				<input type="file" id="txtPic" class="form-control-file" accept="image/x-png,image/jpeg" name="fileToUpload" readonly>
			</div>
			<div class="form-group">
				<label>Full Name:</label>
				<input type="text" id="txtName" class="form-control" value="<?php echo $official['name'] ?>" readonly>
			</div>
			<div class="form-group">
				<label>Address:</label>
				<input type="text" id="txtAddress" class="form-control" value="<?php echo $official['address'] ?>" readonly>
			</div>
			<div class="form-group">
				<label>Sex:</label>
				<input type="text" id="txtSex" class="form-control" value="<?php echo $official['sex'] == '0' ? "Male" : "Female" ?>" readonly>
			</div>
			<button type="submit" class="btn btn-success btn-block">Save</button>
			<br><br><br>
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
		var txtId = document.getElementById("txtId");
		var txtAddress = document.getElementById("txtAddress");
		var txtSex = document.getElementById("txtSex");
		var txtFullName = document.getElementById("txtName");
		var officialImg = document.getElementById("official-img");
		var txtPic = document.getElementById("txtPic");

		txtPic.onchange = function() {
			readURL(this);
		}
		function readURL(input) {

		  if (input.files && input.files[0]) {
		    var reader = new FileReader();

		    reader.onload = function(e) {
		      //$('#blah').attr('src', e.target.result);
		      officialImg.setAttribute("src",e.target.result);
		    }

		    reader.readAsDataURL(input.files[0]);
		  }
		}

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
			txtAddress.value = parentTr.childNodes[2].innerHTML;
			txtSex.value = parentTr.childNodes[3].innerHTML;
			txtId.value = parentTr.childNodes[0].innerHTML;
			txtFullName.value = parentTr.childNodes[1].innerHTML;
			txtSearch.value = "";
			parentTbl.style.display = "none";
		}

	</script>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>