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
		<h2>eblast stats</h2>
	</div>
</div>
<div class="row">
	<div class="medium-9 columns">
	<?php	
	if(isset($camp_results) && is_array($camp_results)){
		$camp_options = array();
		$camp_options[''] = 'select one';
		$attr = 'id="campaign_list"';
		foreach($camp_results as $camprow){
			$campaign_id = $camprow->id;
			$campaign_name = $camprow->campaign_name;
			$camp_options[$campaign_id] = $campaign_name;
		}

		if(isset($campaign_list) && ($campaign_list != "")){
			$selected_camp = $campaign_list;
		}else{
			$selected_camp = "";
		}		
						
		echo form_dropdown('campaign_list', $camp_options, $selected_camp, $attr);	
	}
	?>
	</div>
	<div class="medium-9 columns"><input type="submit" class="button" name="view_campaign" value="view"/></div>
</div>
<?php
}else{
?>

<div class="row">
	<div class="medium-18 columns">
		<p>Please select a <strong>developer</strong> and <strong>project</strong> above and then click <strong>submit</strong>.</p>
	</div>
</div>	
<?php
}

if(isset($camp_info_result) && is_array($camp_info_result)){
	foreach($camp_info_result as $cirow){
		$campaign_name = $cirow->campaign_name;
		$total_recipients = $cirow->total_recipients;
		$successful_deliveries = $cirow->successful_deliveries;
		$total_bounces = $cirow->total_bounces;
		$times_forwarded = $cirow->times_forwarded;
		$unique_opens = $cirow->unique_opens;
		$total_opens = $cirow->total_opens;
		$unique_clicks = $cirow->unique_clicks;
		$total_clicks = $cirow->total_clicks;
		$unsubscribes = $cirow->unsubscribes;
		$abuse_complaints = $cirow->abuse_complaints;
	}
?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	  
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			['Activities', 'Number of People', { role: 'style' }],
			['Sent', <?php echo $total_recipients; ?>, '#2ea0d5'],
			['Received',  <?php echo $successful_deliveries; ?>, '#81c91a'],
			['Reads',  <?php echo $total_opens; ?>, '#8c2fdc'],
			['Clicks',  <?php echo $total_clicks; ?>, '#f05328']		  
        ]);
        var data2 = google.visualization.arrayToDataTable([
			['Clicks', 'Number of People', { role: 'style' }],
			['Total clicks', <?php echo $total_clicks; ?>, '#2ea0d5'],
			['Unique clicks',  <?php echo $unique_clicks; ?>, '#81c91a']		  
        ]);	
        var data3 = google.visualization.arrayToDataTable([
			['Reads', 'Number of People'],
			['Total Reads', <?php echo $total_opens; ?>],
			['Unique Reads', <?php echo $unique_opens; ?>],
			['Forwards',  <?php echo $times_forwarded; ?>],		  
			['Unsubscribes',  <?php echo $unsubscribes; ?>],		  
			['Abuse/Complaints',  <?php echo $abuse_complaints; ?>]		  
        ]);			

        var options = {
          title: 'Eblast Activity Summary'
        };
        var options2 = {
          title: 'Click Activities'
        };	
        var options3 = {
          title: 'Read Activities'
        };			

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart2.draw(data2, options2);	
        var chart3 = new google.visualization.PieChart(document.getElementById('chart_div3'));
        chart3.draw(data3, options3);			
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
<?php	
}
include('includes/footer.php');
?>