<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="<?php echo url_for("/css/bootstrap.min.css"); ?>">
	<script
  src="<?php echo url_for("/js/jquery-3.3.1.min.js") ?>"></script>
  <script
  src="<?php echo url_for("/js/bootstrap/bootstrap.min.js") ?>"></script>
  <script
  src="<?php echo url_for("/js/bootstrap/bootstrap.min.js") ?>"></script>
  <script
  src="<?php echo url_for("/js/bootstrap/bootstrap.bundle.min.js") ?>"></script>
  
	<script src="<?php echo url_for("/js/main.js"); ?>"></script>
	
	<title><?php echo isset($title) ? $title : "Barangay Marinig MS"; ?></title>
	
  <link rel="stylesheet" type="text/css" href="<?php echo url_for("/css/administrator.css?v=".time()) ?>">
	<style type="text/css">
		
	</style>
</head>
<body>
	<header>
          <!-- LOGO -->
          <nav>
            <div class="line">
               <div class="center">
                  <img class ="full-img" src="<?php echo url_for("/img/logo22.jpg") ?>">
               </div>
                <div id="active-user" style="float: right; top:120px; position: relative; right:15px;">Active User : <?php echo $_SESSION['name']; ?> (<?php echo $_SESSION['position']; ?>) </div>
            </div>
          </nav>
      </header>
    <div id="sidebar-nav">

      <nav class="slide-nav aside-nav">
       
        <ul>
          <li><a href="<?php echo url_for("/administrator/residents") ?>">Residents</a></li>
          <?php if($_SESSION['position'] == "Administrator") : ?>
          <li><a href="<?php echo url_for("/administrator/officials") ?>">Officials</a></li>
          
          <li><a href="<?php echo url_for("/administrator/staffs") ?>">Barangay Hall Staffs</a></li>
          <?php endif; ?>
          <li><a href="<?php echo url_for("/administrator/households") ?>">Households</a></li>
          <li><a href="<?php echo url_for("/administrator/blotters") ?>">Blotters</a></li>
          <li><a href="<?php echo url_for("/administrator/business") ?>">Business</a></li>
          <li><a href="<?php echo url_for("/administrator/barangay_clearance") ?>">Barangay Clearance</a></li>
          <li><a href="<?php echo url_for("/administrator/logout.php") ?>">Logout</a></li>
        </ul>
      </nav>
     </div>

