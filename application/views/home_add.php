<?php 
include('includes/header.php');
include('includes/nav_engine.php');

if(validation_errors() != ""){ 
	$errors = validation_errors();
}
?>
<div class="row">
	<div class="medium-18 columns">
		<h2>search</h2>
	</div>
</div>
<div class="row">
	<div class="medium-3 columns" style="padding-top:.5rem;">add registrations</div>
	<div class="medium-12 columns" style="text-align:right;padding-top:.5rem;"></div>
	<div class="medium-3 columns" style="text-align:right;"></div>
</div>
<div class="row">
	<div class="medium-18 columns">
		<table width="100%" cellspacing="0" cellpadding="15" style="border-top:1px solid #333333;margin:0;">
			<tr><td style="line-height: 1rem;padding:0;">&nbsp;</td></tr>
		</table>
	</div>
</div>
<?php 
include('includes/footer.php');
?>