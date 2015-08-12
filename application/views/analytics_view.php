<?php 
include('includes/header.php');
if(validation_errors() != ""){ 
	$errors = validation_errors();
}
include('includes/nav_engine.php');

if(isset($developer) && ($developer != "") && isset($project) && ($project != "")){
?>
<div class="row">
	<div class="medium-18 columns">
		<h2>registration analytics</h2>
	</div>
</div>
<div class="row">
	<div class="medium-6 columns">
		<select name="analytics_list">
			<option <?php if(!isset($analytics_list) || ($analytics_list == "")) echo 'selected="selected"'; ?> value=""> select one </option>
			<option <?php if(isset($analytics_list) && ($analytics_list == "registration_stats")) echo 'selected="selected"'; ?> value="registration_stats">registration stats</option>
			<option <?php if(isset($analytics_list) && ($analytics_list == "registration_activity")) echo 'selected="selected"'; ?> value="registration_activity">registration activity</option>
		</select>
	</div>
	<div class="medium-12 columns"><input type="submit" class="button" name="view_analytics" value="view"/></div>
</div>
<?php
}else{
?>

<div class="row">
	<div class="medium-18 columns">
		<?php 
		$color = '#000000';	
		if(isset($empty) && count($empty) > 0){
			$color = 'red';
		} ?>
		<p style="color:<?php echo $color; ?>">Please select a <strong>developer</strong> and <strong>project</strong> above and then click <strong>submit</strong>.</p>
	</div>
</div>	
<?php
}

if(isset($analytics_list)){
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
	if($analytics_list == "registration_stats"){
?>
    <script type="text/javascript">
	(function($){
		google.load("visualization", "1", {packages:["corechart"]});
		
		var data = [];
		var action = "<?php echo $base_url; ?>programs/reganalytics";
		var pjt_id = '<?php echo $project; ?>';
		var dataCarrier = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&project="+pjt_id;
		$.ajax({
			type: "post",
			url: action,
			data: dataCarrier,
			success: function(html){
				var data = jQuery.parseJSON(html);
				var contactData = data.returnContact;
				var layoutData = data.returnLayout;
				var priceData = data.returnPrice;
				var sizeData = data.returnSize;

				getData(contactData, "Contact method", "chart_div");	
				getData(layoutData, "Layout", "chart_div2");	
				getData(priceData, "Price", "chart_div3");	
				getData(sizeData, "Size", "chart_div4");	
			}
		});	
				
	})(jQuery);	
		
	function getData(vals, subject, div){
	  google.setOnLoadCallback(drawChart(vals, subject, div));	
	}

	function drawChart(d, subject, div){
		var data = google.visualization.arrayToDataTable(d);

		// Create the data table. - contact method
		var data = new google.visualization.DataTable();
		
		data.addColumn(d[0][0], d[0][1]);    
		data.addColumn(d[1][0], d[1][1]);
		var dataVal = [];
		var c = 0;
		for(var i=0;i < d.length; i++){
			if(i > 1){
				dataVal[c] = d[i];
			  c++;
			}
		}
		
		data.addRows(dataVal);		
		
		var options = {
			title: subject
		};

		var chart = new google.visualization.PieChart(document.getElementById(div));
		chart.draw(data, options);	
		
	}	
    </script>
	<div class="row">
		<div class="large-18 columns charts" id="chart_div"></div>		
	</div>
  <div class="row">		
		<div class="large-18 columns charts" id="chart_div2"></div>		
	</div>
	<div class="row">
		<div class="large-18 columns charts" id="chart_div3"></div>			
	</div>	
  <div class="row">		
		<div class="large-18 columns charts" id="chart_div4"></div>
	</div>
<?php
	}elseif($analytics_list == "registration_activity"){
?>
    <script type="text/javascript">
	(function($){
		google.load("visualization", "1", {packages:["corechart"]});
		
		var data = [];
		var base_url = $("#base_url").val();
		var action = "<?php echo $base_url; ?>programs/regactivity";
		var pjt_id = '<?php echo $project; ?>';
		var dataCarriers = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&project="+pjt_id;
		$.ajax({
			type: "post",
			url: action,
			data: dataCarriers,
			success: function(html){
				var data = jQuery.parseJSON(html);
				if(data.numOfRecord == 'Empty'){
				  alert('No record available.');	
				}else{
				  getData(data);
				}	
			}
		});	
				
	})(jQuery);	
		
	function getData(vals){
      google.setOnLoadCallback(drawChart(vals));	
	}

	function drawChart(d){
		var data = google.visualization.arrayToDataTable(d);

		var options = {
			title: 'Client Registration'
		};

		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chart.draw(data, options);	
	}	

    </script>

	<div class="row">
        <div class="large-9 columns charts" class="chart_panel" id="chart_div"></div>
        <div class="large-9 columns">&nbsp;</div>
	</div>
<?php
	}
}
include('includes/footer.php');
?>