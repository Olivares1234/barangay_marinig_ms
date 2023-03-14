<?php require_once '../../private/initialize.php'; ?>
<?php
	logout();
	redirect_to(url_for("administrator/login.php"));
?>