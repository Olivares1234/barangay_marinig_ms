<?php require_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>

<?php  
	//echo json_encode(retrieve_all_blotters());
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
	if(is_get_request()) {
		if($keyword == "") {
			$blotters = retrieve_all_blotters();
		} else {
			$blotters = search_blotter($keyword);
		}
		//echo json_encode(mysqli_fetch_assoc($residents));
		echo json_encode($blotters);
	}
?>