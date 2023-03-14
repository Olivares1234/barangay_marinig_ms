<?php require_once '../../../private/initialize.php'; ?>
<?php
	if (isset($_GET['id']))
	{
		$violation = retrieve_violation_by_id($_GET['id']);

	}
	if (is_post_request())
	{
		update_violation($_POST['violation_id'],$_POST['txtdescription']);
		redirect_to(url_for('administrator/blotters/add_violation.php'));
	}
 ?>
<?php include SHARED_PATH.'/administrator_header.php' ?>
<div id="main">
	<div class="container">
		<a href="<?php echo url_for("/administrator/blotters/add_violation.php") ?>" class="btn btn-success">&laquo; Back to list</a>

		<h1>Update Violation</h1><br>
		<form method="POST">
			<input type="hidden" name="violation_id" value="<?php echo $violation['violation_id'] ?>">
			<input type="text" class="form-control" name="txtdescription" value = "<?php echo $violation['description'] ?>"><br><br>

			<button class="btn btn-success btn-block" name="btnsave">Save</button>
		</form>
		
	</div>
</div>
<?php include SHARED_PATH.'/administrator_footer.php' ?>
