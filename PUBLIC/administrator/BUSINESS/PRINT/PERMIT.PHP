<?php require_once '../../../../private/initialize.php'; ?>
<?php
	if(isset($_GET['id'])) {

		$id = $_GET['id'];
		$business = retrieve_business($id);
		$captain = retrieve_barangay_captain();
		$date_issued = strtotime($business['date_issued']);
		$months = ['Enero','Pebrero','Marso','Abril','Mayo','Hunyo','Hulyo','Agosto','Setyembre','Oktubre','Nobyembre','Disyembre'];
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Business Permit</title>
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
		<u><p>PAGLILINAW NG BARANGAY SA BAHAY KALAKAL</p></u>
		<u><p>BARANGAY CLEARANCE FOR BUSINESS ESTABLISHMENT</p></u>
		<div class="paragraph">
			<div class="intro">Sa kinauukulan:</div>
			<div class="introbody">
				<p>Ito ay isang pagpapatunay na ang <u><?php echo $business['business_description'] ?>,</u></p>
				<p>ay pag-aari ni <b><?php echo $business['owner_name']; ?></b> na matatagpuan sa <?php echo $business['business_address'] ?></p>
				<p> PUROK <?php echo $business['purok'] ?> Barangay Marinig, Lungsod ng Cabuyao, Laguna.</p>
				<p>Ang nasabing Negosyo ay hindi nakakapinsala at walang nilabag na Ordinansang pambarangay</p>
			</div><br>
			<div class="introlower">
				<p>IPINAGKALOOB ng ika - <?php echo date('d',$date_issued); ?> ng <?php echo $months[date('m',$date_issued) - 1]; ?> <?php echo date('Y',$date_issued); ?></p><br>
				<p>ISSUED NO. : <?php echo $business['business_permit_id']; ?></p>
				<p>ISSUED AT  : <?php echo $business['date_issued']; ?></p>
				<p>VALIDITY PERIOD : 1 YEAR</p><br>
			</div>
			<div class="name">
				<p><?php echo strtoupper($captain['name']); ?></p>
				<p>Punong Barangay</p>
			</div>
		</div>
		
	</div>
	<script type="text/javascript">
		window.onload = function() {
			window.print();
			window.location.href = "../../business/";
		}
	</script>
	

</body>
</html>