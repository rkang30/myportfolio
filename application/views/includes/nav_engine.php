<?php 
$uri = uri_string();
$str_array = explode("/", $uri);
$first_seg = $str_array[0];

switch($first_seg){
	case 'home':
	$form = 'verifyproject';
	$attributes = array('id' => 'engine_form');
	break;

	case 'verifyproject':
	$form = 'verifyproject';
	$attributes = array('id' => 'engine_form');
	break;	
	
	case 'analytics':
	$form = 'verifydata';
	$attributes = "";
	break; 
	
	case 'eblasts':
	$form = 'verifyeblast';
	$attributes = "";
	break;
	
	case 'eblastnames':
	$form = 'verifyeblastname';
	$attributes = "";
	break;	
	
	case 'regexport':
	$form = 'verifyregexport';
	$attributes = "";
	break;		
	
	default:
	return false;
	break;
}

echo form_open($form, $attributes); 

?>
<div class="row">
	<div class="large-9 columns" id="dev_logo">  
  	<ul class="small-block-grid-3">
    	<li id="view_reg"><a id="reg_views_link" href="">view<br>registrants</a></li>
      <li id="reg_analys"><a id="reg_analys_link" href="">registration<br>analytics</a></li>
      <li id="eblast_stats"><a id="eblast_analys_link" href="">e-blast<br>statistics</a></li>
      <?php if(isset($permission) && ($permission == 1)){ ?><li id="eblast_camp"><a id="eblast_name_link" href="">e-blast<br>name</a></li><?php } ?>
      <?php if(isset($permission) && ($permission == 1)){ ?><li id="eblast_export"><a id="eblast_reg_export_link" href="">e-blast<br>export</a></li><?php } ?>    
   </ul>	
   
   
   	
	</div><!--/.large-9 .columns-->
  
	<div class="large-9 columns">	
  	<div class="row" id="menu-box">
    	<div class="medium-7 columns"><select id="developer" name="developer" <?php if(isset($errors) && array_key_exists('developer', $errors)) echo 'style="border:1px solid red;"'; ?>>
		<?php
			if(count($developer_names) > 1){
		?>	
				<option value="" <?php if(!isset($developer)){ echo 'selected="selected"'; } ?>> select developer </option>
			<?php		
				foreach($developer_names as $devkey => $deval){
			?>
					<option <?php if(isset($developer) && ($developer == $devkey)) echo 'selected="selected"'; ?> value="<?php echo $devkey; ?>"><?php echo $deval; ?></option>
			<?php
				}
			?>				
			<?php	
			}else{
				foreach($developer_names as $devkey => $deval){
			?>
					<option <?php if(isset($developer) && ($developer == $devkey)) echo 'selected="selected"'; ?> value="<?php echo $devkey; ?>"><?php echo $deval; ?></option>
			<?php
				}
			}
			?>
		</select>	</div><!--/.medium-9 .columns-->
      <div class="medium-7 columns"><select id="project" name="project" <?php if(isset($errors) && array_key_exists('project', $errors)) echo 'style="border:1px solid red;"'; ?>></select></div>
      <div class="medium-4 columns"><input type="submit" id="find_project" class="button" name="find_project" value="submit"/></div>
    </div><!--/.row-->  
		
	</div><!--/.medium-9 .columns-->
</div><!--/.row-->

<div class="row">
	<div class="medium-18 columns"><div id="menu-bar"></div></div>
</div><!--/.row-->