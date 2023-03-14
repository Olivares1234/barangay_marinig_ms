<?php include_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
	$brgy_captain = retrieve_barangay_captain(); 
	$councilors = retrieve_councilors();
?>
<?php include SHARED_PATH. "/administrator_header.php"; ?>
	<div id="main">
		<div class="container">
			<h1>Barangay Officials</h1>
			<div class="card m-auto" style="width:250px;">
				<img class="card-img-top" src="<?php echo url_for('administrator/officials/uploads/'. $brgy_captain['resident_official_id'] . ".png?v=".time()) ?>" alt="Card image">
			  <div class="card-body">
			    <h4 class="card-title"><?php echo $brgy_captain['name']; ?></h4>
			    <p class="card-text"><?php echo $brgy_captain['position']; ?></p>
			    <a class="btn btn-success" href="<?php echo url_for('/administrator/officials/edit.php?id=' . $brgy_captain['resident_official_id']) ?>">Update</a>
			    
			  </div>
			</div>
			<h2>Barangay Councilors</h2>
			<div class="row">
				<?php while($councilor = mysqli_fetch_assoc($councilors)) : ?>
					<div class="card m-3" style="width:250px;">
						<img class="card-img-top" src="<?php echo url_for('administrator/officials/uploads/'. $councilor['resident_official_id'] . ".png?v=".time()) ?>" alt="Card image">
					  <div class="card-body">
					    <h4 class="card-title"><?php echo $councilor['name']; ?></h4>
					    <p class="card-text"><?php echo $councilor['position']; ?></p>
					    <a class="btn btn-success" href="<?php echo url_for('/administrator/officials/edit.php?id=' . $councilor['resident_official_id']) ?>">Update</a>
					  </div>
					</div>
				<?php endwhile; ?>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalCenterTitle">Update Officials</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <div class="form-group">
			        	<input type="text" name="search" class="form-control" placeholder="Search..">
			        	<img src="<?php echo url_for('/img/woman.png') ?>" class="img-official">
			        	<input type="file" name="picture">
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary">Save changes</button>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- /Modal -->
		</div>
	</div>
<?php include SHARED_PATH.'/administrator_footer.php'; ?>