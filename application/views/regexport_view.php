<?php 
include('includes/header.php');
if(validation_errors() != ""){ 
	$errors = validation_errors();
}
include('includes/nav_engine.php');
?>
<div class="row">
	<div class="medium-18 columns">
		<h2>registrant export</h2>
	</div>
</div>
<div class="row">
	<div class="medium-18 columns">
		<input type="submit" class="button" name="download_reg" value="download"/>
	</div>
</div>
<?php
if(isset($empty) && (count($empty) > 0)){
?>
<div class="row">
	<div class="medium-18 columns">
		<p style="color:red;">Please select a <strong>developer</strong> and <strong>project</strong> above and then click <strong>submit</strong> first.</p>
	</div>
</div>
<?php	
}	
include('includes/footer.php');
?>