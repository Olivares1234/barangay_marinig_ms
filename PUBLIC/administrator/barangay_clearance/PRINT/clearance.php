<?php require_once '../../../../private/initialize.php'; ?>
<?php 
	if(isset($_GET['id'])) {
		$clearance = retrieve_clearance($_GET['id']);
		$resident = retrieve_resident($clearance['resident_id']);
		$captain = retrieve_barangay_captain();

		//compute birthdate
		$date = new DateTime($resident['date_of_birth']);
 		$now = new DateTime();
 		$interval = $now->diff($date);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Barangay Clearance</title>
	<style type="text/css">
		#mariniglogo
		{
			opacity: 0.1;
			margin: 0 auto;

		}
		#marinig
		{
			align: center;
		}
		

		.header {
			/*float: right;*/
			position: absolute;
			text-align: center;
			/*margin-left: 20px;
			
			margin-right: 100px;
			*/
			
			margin: 250px auto 0 auto;
			width: 100%;
		}
		#header
		{
			text-align: left;
			margin-left:  20px;
			margin-right: 80px;
			margin-top: 10px;
		}

		.body p {
			position: relative;
			z-index: 1;
			top: 50px;
			font-size: 20px;
			text-align: center;
		}
		.body .paragraph .intro
		{
			position: relative;
			z-index: 1;
			top: 100px;
			text-align: left;
		}
		.body .paragraph .introbody p
		{
			position: relative;
			z-index: 1;
			top: 150px;
			text-align: center;
			font-size: 170%;
		}
		.body .paragraph .introlower p
		{
			position: relative;
			z-index: 1;
			top: 200px;
			text-align: left;
			font-size: 170%;
		}
		.body .paragraph .name p
		{
			position: relative;
			z-index: 1;
			top: 150px;
			text-align: right;
			font-size: 170%;
		}
		#number
		{
			margin-left: 170px;
			margin-right: 300px;
		}
		#header-pic {
			width: 100%;
			height: auto;
		}
		.intro {
			font-size:170%;
		}
		.name p {
			text-align: center;
		}
	</style> 
</head>
<body>

	<div class = "header">
		<img src="background.jpg" id="mariniglogo">
	</div>
	<div id="header">
		<img src="header.jpg" id="header-pic">
	</div>
<!-- 	<div id="number"><b>Some text missing<b></div> -->
	<hr> 
	<div class="body">
		<center><h1>BARANGAY CLEARANCE</h1></center>
		<div class="paragraph">
			<div class="intro">TO WHOM IT MAY CONCERN:</div>
			<div class="introbody">
				<!-- <p>Ito ay isang pagpapatunay na ang <u>EDEN'S SARI-SARI STORE AT LUTONG ULAM,</u></p>
				<p>ay pag-aari ni <b>EDEN V. VICENTE</b> na matatagpuan sa BLK 20 LOT 05 PH-1</p>
				<p>CELESTINE HOMES PUROK 3 Barangay Marinig, Lungsod ng Cabuyao, Laguna.</p>
				<p>Ang nasabing Negosyo ay hindi nakakapinsala at walang nilabag na Ordinansang pambarangay</p> -->
				<p>This is to certify that <b style="text-transform: uppercase;"><?php echo $resident['last_name'] . ', '.$resident['first_name'] . ' ' . $resident['middle_name'] ; ?>, <?php echo $interval->y ; ?> years old, <?php echo $resident['civil_status']; ?>, <?php echo $resident['citizenship']; ?></b>, is a bonafide resident of Barangay Marinig, with postal address at <b style="text-transform: uppercase;"><?php echo $resident['address']; ?></b> and that has no deregatory/criminal records filed in this barangay.
				</p>
			</div><br>
			<div class="introlower">
				<p>ISSUED NO. : <?php echo $clearance['barangay_clearance_id']; ?></p>
				<p>ISSUED AT  : <?php echo $clearance['date_issued']; ?></p>
				<p>VALIDITY PERIOD : 1 YEAR</p><br>
			</div>
			<div class="name">
				<p><?php echo $captain['name']; ?></p>
				<p>Punong Barangay</p>
			</div>
		</div>
		
	</div>
	<script type="text/javascript">
		window.onload = function() {
			window.print();
			window.location.href = "../../barangay_clearance/";
		}
	</script>

</body>
</html>