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
<?php include SHARED_PATH.'/administrator_footer.php'; ?>