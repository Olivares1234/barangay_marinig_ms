<?php include_once '../../../private/initialize.php';  ?>
<?php require_login(); ?>
<?php
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
	if(is_get_request()) {
		if($keyword == "") {
			$staffs = retrieve_all_staffs();
		} else {
			$staffs = search_staffs($keyword);
		}
		//echo json_encode(mysqli_fetch_assoc($residents));
		echo json_encode($staffs);
	}
	//echo json_encode(retrieve_all_staffs());
?>
