<?php 
require_once('includes/header.php');

if(validation_errors() != ""){ 
	$errors = validation_errors();
}
require_once('includes/nav_engine.php');
if(!isset($limit)){
	$limit = 0;
}

if(!isset($developer) || !isset($project) || (!isset($results) && !isset($not_list))){
?>

<div class="row">
	<div class="medium-18 columns">
		<p>Please select a <strong>developer</strong> and <strong>project</strong> above and then click <strong>submit</strong>.</p>
	</div>
</div>	
<?php
}

if(isset($add_reg) || isset($add_new_client)){

	include('includes/reg_add.php');

}elseif((isset($comment_log)) || (isset($add_comment))){

	include('includes/reg_log.php');
	
}elseif(isset($results)){

	include('includes/search_filter_module.php');
	include('includes/reg_add_delete.php');
	include('includes/reg_list.php');
	
}

include('includes/footer.php');
?>