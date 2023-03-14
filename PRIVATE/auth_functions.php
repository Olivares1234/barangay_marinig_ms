<?php
	function log_in($staff) {
		$_SESSION['staff_id'] = $staff['staff_id'];
		$_SESSION['position'] = $staff['position'];
		$_SESSION['resident_id'] = $staff['resident_id'];
		$_SESSION['position'] = $staff['position'];
		$_SESSION['name'] = $staff['name'];
	}

	function is_logged_in() {
		return isset($_SESSION['staff_id']);
	}

	function require_login() {
	  if(!is_logged_in()) {
	    redirect_to(url_for('/administrator/login.php'));
	  } else {

	  }
	}
	function logout() {
		session_destroy();
	}


?>
