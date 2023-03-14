<?php include_once '../../../private/initialize.php'; ?>
<?php
	require_login();
	if(isset($_GET['keyword'])) {
		echo json_encode(search_clearance($_GET['keyword']));
	} else {
		echo json_encode(retrieve_clearances());
	}
	
?>