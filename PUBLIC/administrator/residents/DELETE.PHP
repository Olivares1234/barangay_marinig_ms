<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$resident = retrieve_resident($id);
	if(is_post_request()) {
		 delete_resident($_POST['id']);
		 redirect_to(url_for("/administrator/residents/index.php"));
	}
	// if(isset($_GET['id'])) {
		
	// 	$resident = retrieve_resident($id);
	// } else {
	// 	//redirect_to(url_for("/administrator/residents/index.php"));
	// 	//exit;
	// }
?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
 <div id="main">
 	<div class="container">
 		<a class="btn btn-success back" href="<?php echo url_for("administrator/residents/index.php"); ?>">&laquo; Back to List</a>
 		<h1>Are you sure you want to delete this resident?</h1>
 		<p>Name: <?php echo $resident['last_name']. ", ".$resident['first_name']." ".
 		$resident['middle_name']; ?></p>
 		<p>Address: <?php echo $resident['address']; ?> </p>
 		<p>Sex: <?php echo $resident['sex'] == 0 ? "Male" : "Female"; ?> </p>
 		<p>Occupation:  <?php echo $resident['occupation'] ?></p>
 		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 			<button type="submit" class="btn btn-warning" name="id" value="<?php echo $resident['resident_id'] ?>">Yes</button>
 		</form>
 	</div>
 </div>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>