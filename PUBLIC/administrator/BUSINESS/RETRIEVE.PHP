<?php require_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	if(isset($_GET['keyword'])) {
		$keyword = $_GET['keyword'];
		//$business = search_business($keyword);
		//echo json_encode($business);
		$business = search_business($keyword);
		echo json_encode($business);
	} else {
		$business = retrieve_all_business();
		echo json_encode($business);
	}
?>