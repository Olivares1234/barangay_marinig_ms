<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$staff = retrieve_staff($id);
	if(is_post_request()) {
		 delete_staff($_POST['id']);
		 redirect_to(url_for("/administrator/staffs/index.php"));
	}
?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
 <div id="main">
 	<div class="container">
 		<a class="btn btn-success back" href="<?php echo url_for("administrator/staffs/index.php"); ?>">&laquo; Back to List</a>
 		<h1>Are you sure you want to delete this staff?</h1>
 		<p><b>Name:</b> <?php echo $staff['last_name']. ", ".$staff['first_name']." ".
 		$staff['middle_name']; ?></p>
 		<p><b>Position:</b> <?php echo $staff['position']; ?> </p>
 		<p><b>Address:</b> <?php echo $staff['address']; ?> </p>
 		<p><b>Sex:</b> <?php echo $staff['sex'] == 0 ? "Male" : "Female"; ?> </p>
 		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 			<button type="submit" class="btn btn-warning" name="id" value="<?php echo $staff['staff_id'] ?>">Yes</button>
 		</form>
 	</div>
 </div>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>