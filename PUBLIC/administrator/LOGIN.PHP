<?php require_once '../../private/initialize.php'; ?>
<?php 
	if(is_post_request()) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		// if(auth_staff($username,$password)) {
		// 	login_staff();
		// } else {
		//  	echo "<script>alert('incorrect username or password')</script>";
		// }
		$login = auth_staff($username,$password);
		if($login) {
			log_in($login);
			redirect_to(url_for("administrator/residents"));
		} else {
			echo "<script>alert('incorrect username or password')</script>";
		}
	} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login | Barangay Marinig MS</title>
	<link rel="stylesheet" type="text/css" href="<?php echo url_for("/css/bootstrap.min.css") ?>">
	<style>
		/*style specific for login only*/
		.login-container {
			width: 500px;
			margin: 100px auto;
		}
		form h1 {
			font-size: 35px;
		}
	</style>	
</head>
<body>
	<div class="container">
		<div class="login-container">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				<h1 class="text-primary">Login to your account</h1>
				<div class="form-group">
					<label for="txtUsername">Username</label>
					<input type="text" name="username" id="txtUsername" class="form-control">
				</div>
				<div class="form-group">
					<label for="txtPassword">Password</label>
					<input type="password" name="password" id="txtPassword" class="form-control">
				</div>
				<button type="submit" class="btn btn-success btn-block" name="btnLogin">Login</button>
			</form>
		</div>
	</div>
	
</body>
</html>