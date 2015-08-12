<?php 
include('includes/header.php');
if(validation_errors() != ""){ 
	$errors = validation_errors();
}
include('includes/nav_engine.php');
?>
<div class="row">
	<div class="medium-18 columns">
		<h2>eblast name</h2>
	</div>
</div>
<?php 
if(isset($new_campaign_added)){
?>
<div class="row">
	<div class="medium-12 columns" style="color:#2ba6cb;"><?php echo $new_campaign_added; ?></div>
</div>
<?php
}
?>
<div class="row" style="padding-bottom:15px;">
	<div class="medium-7 columns"><input type="text" name="new_campaign" value="<?php if(isset($new_campaign)){ echo $new_campaign; }else{ echo 'New Campaign'; } ?>" onfocus="this.value='';"/></div>
	<div class="medium-11 columns"><input type="submit" class="button" name="add_newcamp" value="add"/></div>
</div>
<?php
if(isset($empty) && (count($empty) > 0)){
?>
<div class="row">
	<div class="medium-12 columns" style="color:red;">Please select a <strong>developer</strong> and <strong>project</strong> above and then click <strong>submit</strong> first.</div>
</div>
<?php	
}	
if(isset($camp_results) && is_array($camp_results)){
?>
<div class="row">
	<div class="medium-18 columns">
	<table width="100%" cellspacing="0" cellpadding="15" border="1">
		<thead>
			<tr>
				<th width="90%">subject</th>
				<th width="10%" style="text-align:center;">action</th>
			</tr>
		</thead>
		<tbody>	
<?php
	foreach($camp_results as $camprow){
		$campaign_id = $camprow->id;
		$campaign_name = $camprow->campaign_name;
?>
		<tr>
			<td id="campField<?php echo $campaign_id; ?>"><?php echo $campaign_name; ?></td>
			<td style="text-align:center;padding-top:1rem" id="actionWrap<?php echo $campaign_id; ?>"><input type="button" id="campEdit<?php echo $campaign_id; ?>" class="button" name="edit_camp<?php echo $campaign_id; ?>" value="edit" onclick="return editCamp(this.id);"/></td>
		</tr>
<?php		
	}
?>
		</tbody>
	</table>
	</div>
</div>	
<?php	
}
	
include('includes/footer.php');
?>