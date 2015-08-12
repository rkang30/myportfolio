<div class="row">
	<div class="medium-8 columns"><h3>general registrations</h3></div>
	<div class="medium-4 columns"><h3>total: <?php if(isset($num_results)) echo $num_results; ?></h3></div>
	<div class="medium-6 columns" style="text-align:right;">
		<input type="submit" class="button" id="add" style="margin-bottom:1rem;" name="add_reg" value="add"/>
		<input type="button" class="button" id="delete" style="margin-bottom:1rem;" name="delete" value="delete" onclick="return delReg();"/>
	</div>
</div>