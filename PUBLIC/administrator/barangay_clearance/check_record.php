<?php require_once '../../../private/initialize.php'; ?>

<?php 
	if(isset($_GET['id'])) {
		$hasRecord = checkRecord($_GET['id']);

		if($hasRecord) {
			echo "This resident has record in this barangay. ";
			$records = getRecord($_GET['id']);
			while($record = mysqli_fetch_assoc($records)) {
				echo '<a href="'. url_for("/administrator/blotters/view.php?id=".$record['blotter_id']) .'">Link</a> ';
			}
		} else {
			echo "This resident has no deregatory/criminal records filed in this barangay.";
		}
	}
?>