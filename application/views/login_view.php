<?php 
include('includes/header.php');

if(validation_errors() != ""){ 
$errors = validation_errors();		
?>
<br>
	<div class="row">
  	<div class="medium-3 columns"></div>
		<div class="medium-15 columns" style="color:red">
		<?php 
		foreach($errors as $err_key => $err_val){
			echo $err_val.'<br>';
		}
		?>
		</div>
	</div>
<?php 
} //end of validation_errors	

echo form_open('verifylogin'); 
?>
<br>
<div class="row">
	<div class="medium-3 columns top_compt">user name </div>
	<div class="medium-6 columns"><input type="text" class="login_compt" id="username" name="username" onfocus="this.value=''" value="<?php if(isset($username) && $username != ""){ echo $username; }else{ echo 'Username'; } ?>"/></div>
	<div class="medium-9 columns"></div>
</div><!--/.row-->

<div class="row">
	<div class="medium-3 columns top_compt">password </div>
	<div class="medium-6 columns"><input type="password" class="login_compt" id="passowrd" name="password" onfocus="this.value=''" value="<?php if(isset($password) && $password != ""){ echo $password; }else{ echo 'Password'; } ?>"/></div>
  <div class="medium-9 columns"></div>
</div><!--/.row-->

<div class="row">
	<div class="medium-3 columns"></div>
	<div class="medium-15 columns"><input type="submit" class="button login_compt" value="Login"/></div>	
</div><!--/.row-->
</form>
<?php 
include('includes/footer.php');
?>