<div class="row">
	<div class="medium-18 columns">
		<h2>search</h2>
	</div>
</div>
<?php
//set up search array
$search_array = array(); //select values from db
if(isset($search_results) && is_array($search_results)){
	foreach($search_results as $srows){
		$id = $srows->id;
		$opt_name = $srows->opt_name;
		$opt_value = $srows->opt_value;
		$types = $srows->types;
		$search_array[$opt_name][$types][$id] = $opt_value;
	}
	//set up category
	$available_cat = array();
	foreach($search_array as $key => $val){
		array_push($available_cat, $key);
	}
}

if(isset($available_cat) && is_array($available_cat)){
?>
<div class="row">
	<div class="medium-4 columns">
		<div class="row">
			<div class="medium-18 columns">
				<select class="search_opt" id="filter1" name="filter1">
					<option value="">search by</option>
					<?php 
					foreach($available_cat as $cat_val){
					?>
					<option <?php if(isset($filter1) && ($filter1 == $cat_val)) echo 'selected="selected"';  ?> value="<?php echo $cat_val; ?>"><?php echo str_replace("_", " ", $cat_val); ?></option>	
					<?php				
					}			
					?>
				</select>
			</div>
		</div>
		<?php 
		$item1="";
		$value1="";		
		if(isset($filter1) && ($filter1 != "")){			
			$val_name1 = "search_".$filter1."1";			
			if(isset($$val_name1) && ($$val_name1 != "")){				
				$item1 = $filter1;				
				$value1 = $$val_name1;				
			}		
		}
		?>		
		<input type="hidden" id="post_filter1" name="post_filter1" alt="<?php echo $item1; ?>" value="<?php if(isset($value1) && ($value1 != "")) echo $value1; ?>"/>				
		<?php	
		foreach($search_array as $searchItem => $searchVal){
		?>
		<div class="row respond1" id="<?php echo $searchItem; ?>1" style="display:none;">
			<div class="medium-18 columns">
			<?php
			foreach($searchVal as $type => $obj){
				if($type == "select"){
				?>
					<select class="filter_field1" id="search_<?php echo $searchItem; ?>1" name="search_<?php echo $searchItem; ?>1">
					<?php 
						foreach($obj as $sid => $sval){
					?>
						<option <?php if(isset($value1) && ($value1 == $sval)) echo 'selected="selected"'; ?> value="<?php echo $sval; ?>"><?php echo $sval; ?></option>
					<?php		
						}					
					?>
					</select>
				<?php
				}elseif($type == "input"){
				?>
				<input type="text" class="filter_field1" id="search_<?php echo $searchItem; ?>1" name="search_<?php echo $searchItem; ?>1" value="<?php if(isset($value1)) echo $value1; ?>"/>	
				<?php
				}
			}
			/*	
			if(array_key_exists($catval, $search_array)){ //db search opt
			?>
				<select class="filter_field1" id="search_<?php echo $catval; ?>1" name="search_<?php echo $catval; ?>1">
				<?php 
					foreach($search_array[$catval] as $ds => $dk){
				?>
					<option <?php if(isset($value1) && ($value1 == $dk)) echo 'selected="selected"'; ?> value="<?php echo $dk; ?>"><?php echo $dk; ?></option>
				<?php		
					}
				?>
				</select>
			<?php	
			}else{ // none db search opt
				if(array_key_exists($catval, $none_db_selects)){//select opt
				?>
				<select class="filter_field1" id="search_<?php echo $catval; ?>1" name="search_<?php echo $catval; ?>1">	
				<?php	
				foreach($none_db_selects[$catval] as $nk => $nv){
				?>
					<option <?php if(isset($value1) && ($value1 == $nv)) echo 'selected="selected"'; ?> value="<?php echo $nv; ?>"><?php echo $nv; ?></option>
				<?php	
				}
				?>
				</select>	
				<?php	
				}else{ //input opt
				?>
				<input type="text" class="filter_field1" id="search_<?php echo $catval; ?>1" name="search_<?php echo $catval; ?>1" value="<?php if(isset($value1)) echo $value1; ?>"/>
				<?php
				}
			}
			*/
			?>
			</div>
		</div>		
		<?php		
		}//end of foreach $available_cat	
		?>	
	</div>
	<div class="medium-4 columns">
		<div class="row">
			<div class="medium-18 columns">
				<select class="search_opt" id="filter2" name="filter2">
					<option value="">search by</option>
					<?php 
					foreach($available_cat as $cat_val){
					?>
					<option <?php if(isset($filter2) && ($filter2 == $cat_val)) echo 'selected="selected"'; ?> value="<?php echo $cat_val; ?>"><?php echo str_replace("_", " ", $cat_val); ?></option>			
					<?php			
					}			
					?>
				</select>
			</div>
		</div>
		<?php
		$item2="";
		$value2="";		
		if(isset($filter2) && ($filter2 != "")){			
			$val_name2 = "search_".$filter2."2";			
			if(isset($$val_name2) && ($$val_name2 != "")){				
				$item2 = $filter2;				
				$value2 = $$val_name2;				
			}		
		}		
		?>		
		<input type="hidden" id="post_filter2" name="post_filter2" alt="<?php echo $item2; ?>" value="<?php if(isset($value2) && ($value2 != "")) echo $value2; ?>"/>		
		<?php
		foreach($search_array as $searchItem => $searchVal){
		?>
		<div class="row respond2" id="<?php echo $searchItem; ?>2" style="display:none;">
			<div class="medium-18 columns">
			<?php
			foreach($searchVal as $type => $obj){
				if($type == "select"){
				?>
					<select class="filter_field2" id="search_<?php echo $searchItem; ?>2" name="search_<?php echo $searchItem; ?>2">
					<?php 
						foreach($obj as $sid => $sval){
					?>
						<option <?php if(isset($value2) && ($value2 == $sval)) echo 'selected="selected"'; ?> value="<?php echo $sval; ?>"><?php echo $sval; ?></option>
					<?php		
						}					
					?>
					</select>
				<?php
				}elseif($type == "input"){
				?>
				<input type="text" class="filter_field2" id="search_<?php echo $searchItem; ?>2" name="search_<?php echo $searchItem; ?>2" value="<?php if(isset($value2)) echo $value2; ?>"/>	
				<?php
				}
			}			
			/*	
			if(array_key_exists($catval, $search_array)){ //db search opt
			?>
				<select class="filter_field2" id="search_<?php echo $catval; ?>2" name="search_<?php echo $catval; ?>2">
				<?php 
					foreach($search_array[$catval] as $ds => $dk){
				?>
					<option <?php if(isset($value2) && ($value2 == $dk)) echo 'selected="selected"'; ?> value="<?php echo $dk; ?>"><?php echo $dk; ?></option>
				<?php		
					}
				?>
				</select>
			<?php	
			}else{ // none db search opt
				if(array_key_exists($catval, $none_db_selects)){//select opt
			?>
					<select class="filter_field2" id="search_<?php echo $catval; ?>2" name="search_<?php echo $catval; ?>2">	
					<?php	
					foreach($none_db_selects[$catval] as $nk => $nv){
					?>
						<option <?php if(isset($value2) && ($value2 == $nv)) echo 'selected="selected"'; ?> value="<?php echo $nv; ?>"><?php echo $nv; ?></option>
					<?php	
					}
					?>
					</select>	
				<?php	
				}else{ //input opt
				?>
				<input type="text" class="filter_field2" id="search_<?php echo $catval; ?>2" name="search_<?php echo $catval; ?>2" value="<?php if(isset($value2)) echo $value2; ?>"/>
				<?php
				}
			}
			*/
			?>
			</div>
		</div>		
		<?php		
		}//end of foreach $available_cat	
		?>
	</div>
	<div class="medium-4 columns">
		<div class="row">
			<div class="medium-18 columns">
				<select class="search_opt" id="filter3" name="filter3">
					<option value="">search by</option>
					<?php 
					foreach($available_cat as $cat_val){
					?>
					<option <?php if(isset($filter3) && ($filter3 == $cat_val))?> value="<?php echo $cat_val; ?>"><?php echo str_replace("_", " ", $cat_val); ?></option>			
					<?php			
					}			
					?>
				</select>
			</div>
		</div>
		<?php
		$item3="";
		$value3="";		
		if(isset($filter3) && ($filter3 != "")){			
			$val_name3 = "search_".$filter3."3";			
			if(isset($$val_name3) && ($$val_name3 != "")){				
				$item3 = $filter3;				
				$value3 = $$val_name3;				
			}		
		}		
		?>		
		<input type="hidden" id="post_filter3" name="post_filter3" alt="<?php echo $item3; ?>" value="<?php if(isset($value3) && ($value3 != "")) echo $value3; ?>"/>		
		<?php
		foreach($search_array as $searchItem => $searchVal){
		?>
		<div class="row respond3" id="<?php echo $searchItem; ?>3" style="display:none;">
			<div class="medium-18 columns">
			<?php 
			foreach($searchVal as $type => $obj){
				if($type == "select"){
				?>
					<select class="filter_field3" id="search_<?php echo $searchItem; ?>3" name="search_<?php echo $searchItem; ?>3">
					<?php 
						foreach($obj as $sid => $sval){
					?>
						<option <?php if(isset($value3) && ($value3 == $sval)) echo 'selected="selected"'; ?> value="<?php echo $sval; ?>"><?php echo $sval; ?></option>
					<?php		
						}					
					?>
					</select>
				<?php
				}elseif($type == "input"){
				?>
				<input type="text" class="filter_field3" id="search_<?php echo $searchItem; ?>3" name="search_<?php echo $searchItem; ?>3" value="<?php if(isset($value3)) echo $value3; ?>"/>	
				<?php
				}
			}			
			/*
			if(array_key_exists($catval, $search_array)){ //db search opt
			?>
				<select class="filter_field3" id="search_<?php echo $catval; ?>3" name="search_<?php echo $catval; ?>3">
				<?php 
				foreach($search_array[$catval] as $ds => $dk){
				?>
					<option <?php if(isset($value3) && ($value3 == $dk)) echo 'selected="selected"'; ?> value="<?php echo $dk; ?>"><?php echo $dk; ?></option>
				<?php		
				}
				?>
				</select>
			<?php	
			}else{ // none db search opt
				if(array_key_exists($catval, $none_db_selects)){//select opt
			?>
					<select class="filter_field3" id="search_<?php echo $catval; ?>3" name="search_<?php echo $catval; ?>3">	
					<?php	
					foreach($none_db_selects[$catval] as $nk => $nv){
					?>
						<option <?php if(isset($value3) && ($value3 == $nv)) echo 'selected="selected"'; ?> value="<?php echo $nv; ?>"><?php echo $nv; ?></option>
					<?php	
					}
					?>
					</select>	
				<?php	
				}else{ //input opt
				?>
					<input type="text" class="filter_field3" id="search_<?php echo $catval; ?>3" name="search_<?php echo $catval; ?>3" value="<?php if(isset($value3)) echo $value3; ?>"/>
				<?php
				}
			}
			*/
			?>
			</div>
		</div>		
		<?php		
		}//end of foreach $available_cat	
		?>
	</div>
	<div class="medium-6 columns"></div>
</div>

<div class="row">
	<div class="medium-18 columns"><input type="submit" class="button" id="reset" name="back_to_default" value="reset"/> <input type="submit" class="button" id="show_filter" name="show_filter" value="submit"/></div>
</div>

<?php	
}//end of isset available cat 
?>