<?php 
$base_url = $this->config->base_url();
date_default_timezone_set('America/Toronto');
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">-->
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="PB Marketing Admin Login" />  
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PB Marketing Admin Login</title>

<!-- js -->
<script language="javascript" type="text/javascript" src="<?php echo $base_url; ?>asset/js/jquery-1.11.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base_url; ?>asset/js/foundation.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base_url; ?>asset/js/vendor/modernizr.js"></script>

<!-- css -->
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>asset/css/foundation.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>asset/css/normalize.css">	
</head>
<body>

	<section class="main-section">
		<div class="fullheight_wrapper">
			<div class="row headbar" id="topmenubar">
				
				<div class="medium-3 columns" id="logo_img">
					<!--<div id="icon_wrapper"><a class="left-off-canvas-toggle menu-icon" href="#"><div><div></div></div></a></div>-->
					<a href="<?php echo $base_url; ?>"><img src="<?php echo $base_url; ?>asset/images/PB_marketing_logo.png" alt="PB marketing logo" border="0"/></a>
				</div>

				<div class="medium-10 columns" id="logo-divider">
        
        	<div class="row">
          <div class="large-6 columns"><p>contact</p><p><a href="mailto:support@pbmarketing.ca">support@pbmarketing.ca</a><br>416 960 4885 ext 223</p></div><!--/.medium-9 .columns-->
          <div class="large-12 columns"><p>address</p><p>55 St. Clair Ave. W. Suite 205<br>Toronto, Ontario, M4V 2Y7</p></div><!--/.medium-9 .columns-->
        </div><!--/.row-->
        
        </div><!--/.medium-10 .columns-->
        
				<div class="medium-5 columns"><p id="copyright-header">&copy; pb marketing ltd. <?php echo date("Y"); ?></p><?php if(isset($user) && ($user != "")){ echo '<p id="logout"><a href="'.$base_url.'home/logout">Logout</a><p>'; } ?></div>
			</div><!-- end of #topmenubar -->	