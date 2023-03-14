<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); ?>
<?php
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
	$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
	if(is_get_request()) {
		if($keyword == "") {
			$residents = retrieve_all_residents(["offset" => $offset]);
		} else {
			$residents = search_residents_available($keyword);
		}
		//echo json_encode(mysqli_fetch_assoc($residents));
		echo json_encode($residents);
	}
 ?>