<?php require_once '../../../private/initialize.php'; ?>
<?php
	if (is_post_request())
	{
		if (isset($_POST['btnsave']))
		{
			insert_violation($_POST['txtAddNew']);
		}	
	}
	$violations = retrieve_all_violations();

	

?>
<?php include SHARED_PATH.'/administrator_header.php' ?>
<script type="text/javascript" src="<?php url_for('/administrator/js/jquery-3.3.1.min.js') ?>"></script>
<div id="main">
	<div class="container">
		<a href="<?php echo url_for("/administrator/blotters") ?>" class="btn btn-success">&laquo; Back</a>
		<br><br>

		<button id="btnaddnew" class="btn btn-primary btn-block">Add New</button>
		<br><br>
		<div id="control-hide" hidden>
			<center>
				<form method="POST" id="mainForm"  onsubmit="return validateForm()">
					<input type="text" size="100px" name="txtAddNew" id="txtAddNew">
					<button id="btnsave" class="btn btn-success" name="btnsave">Save</button>	
				</form>

				<button id="btncancel" class="btn btn-success">Cancel</button>	  

			
			</center>
		</div>

		<div id="tablehide" hidden>
			<h1 class="header-text" align="center">List of Violation</h1>
			<hr>
			<table class="table table-bordered table-hover" id="tblviolation">
				<th>Violation</th>
				<th align="center">Action</th>
				<tbody id="tblBlotter">
					<?php while($violation = mysqli_fetch_assoc($violations)) : ?>
						<tr>
							<td><?php echo $violation['description'] ?></td>
							<td><a href="<?php echo url_for('administrator/blotters/edit_violation.php?id='.$violation['violation_id'])?>" class="btn btn-success">Edit</a></td>
						</tr>
					<?php endwhile; ?>
				</tbody>							
			</table>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function()
			{
				$("#tablehide").fadeIn(1000).removeAttr("hidden", false);


				$("#btnaddnew").click(function()
					{
						$("#control-hide").fadeIn(800).removeAttr("hidden", false);
					});

				$("#btncancel").click(function()
					{
						$("#control-hide").fadeOut(500);
					});
			});


		function validateForm()
				{
					var status = true;
					
					if ($("#txtAddNew").val().trim() == "")
					{
						alert("Please fill up the form!");
						status = false;
					}
					return status;
					
				}
	</script>
</div>
 <?php include SHARED_PATH.'/administrator_footer.php' ?>