<?php 

	/*Including header page*/
	require_once "./includes/header.php";
	require_once "./includes/classes/VideoDetailsFormProvider.php";

 ?>

<!--Start Main page content-->

	<div class="column">
		<?php 

			/*Using the videoDetailsFormProvider function*/
			$formProvider = new VideoDetailsFormProvider($con);
			echo $formProvider->createUploadForm();

		 ?>
	</div>

<!--End Main page content-->

<script>
	/*Shows modal when user clicks submit button on form*/
	$("form").submit(function() {
		$("#loadingModal").modal("show");
	});
</script>

<!-- Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-body" style="width:120;">
        <h2 class="lead">
        	<p align="center">
        		<i class='fas fa-info'></i> Please waiting as this might take a while... <br>
        	</p>
        </h2>
        <p align="center">
        	<img src="media/img/icons/loading-spinner2.gif" alt="loading...">
        </p>
      </div>
    </div>
  </div>
</div>


 <?php 

	/*Including footer page*/
	require_once "./includes/footer.php";

 ?>			