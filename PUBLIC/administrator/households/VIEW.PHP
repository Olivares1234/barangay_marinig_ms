<?php require_once '../../../private/initialize.php'; ?>
<?php
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$household = retrieve_household($id);
	
	if(is_post_request()) {
		remove_members($_POST['resident_id'],$_POST['house_hold_id']);
	}
	$members = retrieve_members($id);
?>
<?php include SHARED_PATH.'/administrator_header.php' ?>

	<div id="main">
		<div class="container">
			<a href="<?php echo url_for("/administrator/households/index.php") ?>" class="btn btn-success">&laquo; Back to list</a>
			<h1 class="header-text">Household Information</h1>
			<a href="<?php echo url_for("/administrator/households/add_member.php?id=".$id) ?>" class="btn btn-success">Add new member</a><br><br>
			<p><b>HOUSE NUMBER: </b><?php echo $household['house_number']; ?></p>	
			<p><b>HOUSE ADDRESS: </b><?php echo $household['address']; ?></p>
			<?php if(mysqli_num_rows($members) > 0) : ?>
				<br>
				<h3>Members</h3>
				<hr>
				<table class="table">
					<th>Name</th>
					<th>Sex</th>
					<th>DOB</th>
					<th>Role In the family</th>
					<th>Occupation</th>
					<th>Salary Per Month</th>
				<?php while ($member = mysqli_fetch_assoc($members)) : ?>
					<tr>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?id=".$id ?>" onsubmit="return confirmDelete()">
						<td><?php echo $member['name']; ?></td>
						<td><?php echo $member['sex'] == 0 ? "Male" : "Female"; ?></td>
						<td><?php echo $member['date_of_birth']; ?></td>
						<td><?php echo $member['role_in_the_family']; ?></td>
						<td><?php echo $member['occupation']; ?></td>
						<td><?php echo $member['salary_per_month']; ?></td>
						<input type="hidden" name="house_hold_id" value="<?php echo $id ?>">
						<input type="hidden" name="resident_id" value="<?php echo $member['resident_id'] ?>">
						<td><button type="submit" class="btn btn-danger">Remove</button></td>
					</form>
					</tr>
				<?php endwhile; ?>
				</table>
			<?php endif; ?>

		</div>
	</div>
	<script type="text/javascript">
		function confirmDelete() {
			return confirm("Are you sure you want to remove resident?");
		}
	</script>
<?php include SHARED_PATH.'/administrator_footer.php' ?>