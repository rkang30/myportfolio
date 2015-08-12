<?php 
if(isset($search_results) && is_array($search_results)){
	$search_array = array();
	$db_select_cat = array("layout", "size", "price", "age", "hear");
	foreach($search_results as $srows){
		$id = $srows->id;
		$opt_name = $srows->opt_name;
		$opt_value = $srows->opt_value;
		$search_array[$opt_name][$id] = $opt_value;
	}
}
?>
<div class="row">
	<div class="medium-18 columns">
		<h2>Add Registrant</h2>
	</div>
</div>
<div class="row">
	<div class="medium-2 columns">title</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($salutation)){
		$salutation = '';
	}
	$title_data = array(
				  'name'        => 'salutation',
				  'id'          => 'salutation',
				  'value'       => $salutation,
				  'maxlength'   => '4',
				  'style'       => '',
				);

	echo form_input($title_data);
	?>
	</div>
	<div class="medium-2 columns">first name</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($first_name)){
		$first_name = '';
	}
	$fn_data = array(
				  'name'        => 'first_name',
				  'id'          => 'first_name',
				  'value'       => $first_name,
				  'maxlength'   => '35',
				  'style'       => '',
				);

	echo form_input($fn_data);
	?>
	</div>
	<div class="medium-2 columns">last name</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($last_name)){
		$last_name = '';
	}
	$ln_data = array(
				  'name'        => 'last_name',
				  'id'          => 'last_name',
				  'value'       => $last_name,
				  'maxlength'   => '55',
				  'style'       => '',
				);

	echo form_input($ln_data);
	?>
	</div>	
</div>
<div class="row">
	<div class="medium-2 columns">address</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($address)){
		$address = '';
	}
	$addr_data = array(
				  'name'        => 'address',
				  'id'          => 'address',
				  'value'       => $address,
				  'maxlength'   => '80',
				  'style'       => '',
				);

	echo form_input($addr_data);
	?>
	</div>
	<div class="medium-2 columns">city</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($city)){
		$city = '';
	}
	$city_data = array(
				  'name'        => 'city',
				  'id'          => 'city',
				  'value'       => $city,
				  'maxlength'   => '50',
				  'style'       => '',
				);

	echo form_input($city_data);
	?>	
	</div>
	<div class="medium-2 columns">postal code</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($postal_code)){
		$postal_code = '';
	}
	$pcode_data = array(
				  'name'        => 'postal_code',
				  'id'          => 'postal_code',
				  'value'       => $postal_code,
				  'maxlength'   => '50',
				  'style'       => '',
				);

	echo form_input($pcode_data);
	?>
	</div>	
</div>
<div class="row">
	<div class="medium-2 columns">telephone</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($telephone)){
		$telephone = '';
	}
	$phone_data = array(
				  'name'        => 'telephone',
				  'id'          => 'telephone',
				  'value'       => $telephone,
				  'maxlength'   => '50',
				  'style'       => '',
				);

	echo form_input($phone_data);
	?>
	</div>
	<div class="medium-2 columns">email</div>
	<div class="medium-4 columns">
	<?php 
	if(!isset($email)){
		$email = '';
	}
	$email_data = array(
				  'name'        => 'email',
				  'id'          => 'email',
				  'value'       => $email,
				  'maxlength'   => '50',
				  'style'       => '',
				);

	echo form_input($email_data);
	?>
	</div>
	<div class="medium-2 columns">layout</div>
	<div class="medium-4 columns">
	<select name="layout" <?php if(!isset($search_array['layout'])) echo 'disabled="disabled"'; ?>>
	<?php 
	if(isset($search_array['layout']) && is_array($search_array['layout'])){
	?>
		<option value=""> select one </option>
	<?php
		foreach($search_array['layout'] as $lk => $lv){
	?>
		<option value="<?php echo $lv; ?>"><?php echo $lv; ?></option>
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
<div class="row">
	<div class="medium-2 columns">size</div>
	<div class="medium-4 columns">
	<select name="size" <?php if(!isset($search_array['size'])) echo 'disabled="disabled"'; ?>>
	<?php 
	if(isset($search_array['size']) && is_array($search_array['size'])){
	?>
		<option value=""> select one </option>
	<?php
		foreach($search_array['size'] as $sk => $sv){
	?>
		<option value="<?php echo $sv; ?>"><?php echo $sv; ?></option>
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
	<div class="medium-2 columns">price</div>
	<div class="medium-4 columns">
	<select name="price" <?php if(!isset($search_array['price'])) echo 'disabled="disabled"'; ?>>
	<?php 
	if(isset($search_array['price']) && is_array($search_array['price'])){
	?>
		<option value=""> select one </option>
	<?php
		foreach($search_array['price'] as $pk => $pv){
	?>
		<option value="<?php echo $pv; ?>"><?php echo $pv; ?></option>
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
	<div class="medium-2 columns">age</div>
	<div class="medium-4 columns">
	<select name="age" <?php if(!isset($search_array['age'])) echo 'disabled="disabled"'; ?>>
	<?php 
	if(isset($search_array['age']) && is_array($search_array['age'])){
	?>
		<option value=""> select one </option>
	<?php
		foreach($search_array['age'] as $ak => $av){
	?>
		<option value="<?php echo $av; ?>"><?php echo $av; ?></option>
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
<div class="row">
	<div class="medium-2 columns">hear</div>
	<div class="medium-4 columns">
	<select name="hear" <?php if(!isset($search_array['hear'])) echo 'disabled="disabled"'; ?>>
	<?php 
	if(isset($search_array['hear']) && is_array($search_array['hear'])){
	?>
		<option value=""> select one </option>
	<?php
		foreach($search_array['hear'] as $hk => $hv){
	?>
		<option value="<?php echo $hv; ?>"><?php echo $hv; ?></option>
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
	<div class="medium-2 columns">rent/own</div>
	<div class="medium-4 columns">
	<select name="rent_own">
		<option value=""> select one </option>
		<option value="Rent">Rent</option>
		<option value="Own">Own</option>
	</select>
	</div>
	<div class="medium-2 columns">contact method</div>
	<div class="medium-4 columns">
	<select name="contact_how">
		<option value=""> select one </option>
		<option value="Email">Email</option>
		<option value="Phone">Phone</option>
	</select>
	</div>
</div>
<div class="row">
	<div class="medium-2 columns">realtor</div>
	<div class="medium-4 columns">
	<select name="realtor" <?php if(!isset($search_array['realtor'])) echo 'disabled="disabled"'; ?>>
	<?php 
	if(isset($search_array['realtor']) && is_array($search_array['realtor'])){
	?>
		<option value=""> select one </option>
	<?php
		foreach($search_array['realtor'] as $hk => $hv){
	?>
		<option value="<?php echo $hv; ?>"><?php echo $hv; ?></option>
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
	<div class="medium-2 columns">work with realtor</div>
	<div class="medium-4 columns">
	<select name="realtor" <?php if(!isset($search_array['work_with_realtor'])) echo 'disabled="disabled"'; ?>>
	<?php 
	if(isset($search_array['work_with_realtor']) && is_array($search_array['work_with_realtor'])){
	?>
		<option value=""> select one </option>
	<?php
		foreach($search_array['work_with_realtor'] as $hk => $hv){
	?>
		<option value="<?php echo $hv; ?>"><?php echo $hv; ?></option>
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
	<div class="medium-6 columns">&nbsp;</div>
</div>
<div class="row">
	<div class="medium-2 columns">comments</div>
	<div class="medium-16 columns">
	<?php 
	if(!isset($comments)){
		$comments = '';
	}
	$comments_data = array(
				  'name'        => 'comments',
				  'id'          => 'comments',
				  'value'       => $comments,
				  'rows'		=> '5',
				  'style'       => 'width:100%'
				);

	echo form_textarea($comments_data);
	?>	
	</div>
</div>
<div class="row">
	<div class="medium-15 columns" style="margin-top:15px;">
		<input type="submit" class="button" name="reg_cancel" value="back to list"/>
		<input type="submit" class="button" name="add_new_client" value="add"/>
	</div>
	<div class="medium-3 columns">&nbsp;</div>
</div>
<?php 
if(isset($affected_results) && ($affected_results == 1)){
?>
<div class="row">
	<div class="medium-18 columns">Successfully added</div>
</div>
<?php	
}
?>