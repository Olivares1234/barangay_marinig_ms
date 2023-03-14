<?php require_once '../../../private/initialize.php'; ?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$households = retrieve_household($id);

	if (is_post_request()) {
		$success = delete_households($_POST['id']);
		if ($success){
			redirect_to(url_for("administrator/households/index.php"));
		}
	}
 ?>
<?php include SHARED_PATH.'/administrator_header.php' ?>
	<div id="main">
		<div class="container">
			<a class="btn btn-success back" href="/barangay_marinig_ms/public/administrator/households/index.php">&laquo; Back to List</a>
			<h1>ARE YOU SURE YOU WANT TO DEACTIVATE THIS HOUSEHOLD ?</h1>
			<p>House No.: <?php echo $households["house_number"] ?></p>
			<p>House Address: <?php echo $households["address"] ?></p>
			<p>Total Members: <?php echo $households["total_members"] ?></p>
			<form method="post" action="/barangay_marinig_ms/public/administrator/households/delete.php">
 			<button type="submit" class="btn btn-warning" name="id" value="<?php echo $id ?>">Yes</button>
 			</form>

		</div>
	</div>
<?php include SHARED_PATH.'/administrator_footer.php' ?>