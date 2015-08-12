<div class="row">
	<div class="medium-18 columns">
		<h2>Registrant Comment Log</h2>
	</div>
</div>
<?php 
if(isset($comment_affected_rows) && ($comment_affected_rows == 1)){
$color = 'green';
$msg = 'Successfully Added!';
?>
<div class="row">
	<div class="medium-18 columns" style="color:<?php echo $color; ?>;"><?php echo $msg; ?></div>
</div>
<?php
}else{
	$color = "red";
	$msg = "";
	if(isset($errors)){
		foreach($errors as $errkey => $errval){
			$msg .= $errval."<br>";
		}
		
	}
?>
<div class="row">
	<div class="medium-18 columns" style="color:<?php echo $color; ?>;"><?php echo $msg; ?></div>
</div>
<?php	
}

if(isset($org_results) && count($org_results) > 0){
	foreach($org_results as $org_result){
		$org_id = $org_result->id_register;
		$org_first_name = $org_result->first_name;
		$org_comments = $org_result->comments;
		$marked_comment_flag = $org_result->comment_flag;
		$org_created = $org_result->created;
?>
		<div class="row cell-wrapper"><!-- status starts -->
			<div class="medium-12 columns" style="margin-bottom:15px;">
				<?php if($marked_comment_flag == "need to follow up"){ ?>
					<img src="<?php echo $base_url;?>asset/images/follow-flag.png" alt="need to follow up" border="0"/>
				<?php }elseif($marked_comment_flag == "no need to follow up"){ ?>
					<img src="<?php echo $base_url;?>asset/images/nofollow-flag.png" alt="no need to follow up" border="0"/>
				<?php }?> 
				<span class="<?php if($marked_comment_flag == "need to follow up"){ echo 'followup-status'; }elseif($marked_comment_flag == "no need to follow up"){ echo 'nofollow-status'; }?>"><?php echo ucfirst($marked_comment_flag); ?></span>
			</div>
			<div class="medium-6 columns"></div>
		</div><!-- status ends -->
<?php		
		if($org_comments != ""){
?>
		<div class="row cell-wrapper">
			<div class="medium-12 columns">
				<div class="row org_comment">
					<div class="medium-4 columns comment_left"><?php echo $org_first_name; ?></div>
					<div class="medium-10 columns comment_left"><?php echo $org_comments; ?></div>
					<div class="medium-4 columns text-center"><?php echo $org_created; ?></div>
				</div>
			</div>
			<div class="medium-6 columns"></div>
		</div>
<?php		
		}		
	}
}

if(isset($log_results) && count($log_results) > 0){
	foreach($log_results as $log_result){
		$author = $log_result->author;
		$comment = $log_result->comment;
		$dt_created = $log_result->dt_created;
?>
<div class="row cell-wrapper">
	<div class="medium-12 columns">
		<div class="row new_log">
			<div class="medium-4 columns comment_left"><?php echo $author; ?></div>
			<div class="medium-10 columns comment_left"><?php echo $comment; ?></div>
			<div class="medium-4 columns text-center"><?php echo $dt_created; ?></div>
		</div>
	</div>
	<div class="medium-6 columns">&nbsp;</div>
</div>	
<?php		
	}	
}
?>
<div class="row cell-wrapper" style="margin-top:15px;">
	<div class="medium-12 columns">
	<?php 
		if(isset($new_comment_log)){
			$comment_log = $new_comment_log;
		}else{
			$comment_log = '';
		}
		
		if(isset($errors["new_comment_log"])){ 
			$warning = "border:1px solid red;";
		}else{
			$warning = "";
		}		
		
		$text_data = array(
			'name' => 'new_comment_log',
			'id' => 'new_comment_log',
			'value' => $comment_log,
			'style' => 'width:100%;padding:10px 15px;'.$warning
		);
		echo form_textarea($text_data);
	?>
	</div>
	<div class="medium-6 columns"></div>
</div>
<div class="row cell-wrapper" style="margin-top:15px;">
	
	<div class="medium-5 columns">
		<div class="row">
			<div class="large-4 columns">Status</div>
			<div class="large-14 columns">
				<select name="comment_flag" <?php if(!isset($comment_flags)) echo 'disabled="disabled"'; if(isset($errors["comment_flag"])){ echo 'style="border:1px solid red;"'; }?>>
				<?php 
				if(isset($comment_flags) && is_array($comment_flags)){
				?>
					<option value=""> select one </option>
				<?php	
					foreach($comment_flags as $comment_flag){
				?>
					<option value="<?php echo $comment_flag; ?>"><?php echo ucfirst($comment_flag); ?></option>
				<?php		
					}
				}else{
				?>
					<option value=""> N/A </option>
				<?php	
				}
				?>
				</select>				
			</div>
		</div> 
	</div>
	<div class="medium-13 columns"></div>
</div>
<div class="row">
	<div class="medium-12 columns" style="text-align:right;"><br>
		<a href="/home/index/<?php echo $developer; ?>/<?php echo $project; ?>/<?php echo $org_id; ?>/<?php echo $paginate; ?>"><input type="button" class="button" name="reg_comment_cancel" value="back to list"/></a>
		<input type="submit" class="button" name="add_comment" value="add"/>
		<input type="hidden" name="entered_reg_id" value="<?php if(isset($reg_id)) echo $reg_id; ?>"/>
		<input type="hidden" name="paginate_number" value="<?php echo $paginate; ?>"/>
	</div>
	<div class="medium-6 columns"></div>
</div>